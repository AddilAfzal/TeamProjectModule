<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function create()
    {
        return view(auth()->user()->role . '.reports.create')->with('title', 'Create Reports');
    }



    public function ticketStockTurnoverIndex() {
        return view(auth()->user()->role . '.reports.ticket-stock-turnover.index')->with('title', 'Generate Stock Turnover Report');
    }

    public function ticketStockTurnoverGenerate(Request $request) {

        $startPeriod = $request->dateFrom;
        $endPeriod = $request->dateTo;

        $blanksReceived_agentsStock =
            \App\Blank::select((DB::raw('blank_type_id as type, count(*) as count, min(blank_number) as min, max(blank_number) as max')))
            ->whereBetween('created_at', [$request->dateFrom, $request->dateTo])
            ->groupBy('blank_type_id')->get();

        $blanksReceived_subAgentsStock =
            \App\Blank::select((DB::raw('blank_type_id as type, count(*) as count, min(blank_number) as min, max(blank_number) as max, user_id as code')))
                ->whereBetween('created_at', [$request->dateFrom, $request->dateTo])
                ->whereNotIn('user_id', [0])
                ->groupBy('blank_type_id', 'user_id')
                ->orderBy('min','desc')
                ->get();


        $assignedUsedBlanks_assigned =
            \App\Blank::select((DB::raw('blank_type_id as type, count(*) as count, min(blank_number) as min, max(blank_number) as max, user_id as code')))
                ->whereBetween('assigned_at', [$request->dateFrom, $request->dateTo])
                ->whereNotIn('user_id', [0])
                ->groupBy('blank_type_id', 'user_id')
                ->orderBy('min','desc')
                ->get();

        $assignedUsedBlanks_used =
            \App\Blank::select((DB::raw('blank_type_id as type, count(*) as count, min(blank_number) as min, max(blank_number) as max')))
                ->whereBetween('sold_at', [$request->dateFrom, $request->dateTo])
                ->whereNotIn('user_id', [0])
                ->groupBy('blank_type_id')
                ->orderBy('min','desc')
                ->get();

        $finalAmounts_agentsAmmount =
            \App\Blank::select((DB::raw('blank_type_id as type, count(*) as count, min(blank_number) as min, max(blank_number) as max')))
                ->where('is_sold', 0)
                ->groupBy('blank_type_id')
                ->orderBy('min','desc')
                ->get();

        $finalAmounts_subAgentsAmmount =
            \App\Blank::select((DB::raw('blank_type_id as type, count(*) as count, min(blank_number) as min, max(blank_number) as max, user_id as code')))
                ->where('is_sold', 0)
                ->groupBy('blank_type_id', 'user_id')
                ->orderBy('min','desc')
                ->get();

        $array =
            [
                'blanksReceived_agentsStock' => $blanksReceived_agentsStock,
                'blanksReceived_subAgentsStock' => $blanksReceived_subAgentsStock,
                'assignedUsedBlanks_assigned' => $assignedUsedBlanks_assigned,
                'assignedUsedBlanks_used' => $assignedUsedBlanks_used,
                'finalAmounts_agentsAmmount' => $finalAmounts_agentsAmmount,
                'finalAmounts_subAgentsAmmount' => $finalAmounts_subAgentsAmmount,
                'start_period' => $startPeriod,
                'end_period' => $endPeriod,
            ];

        $pdf = \PDF::loadView('reports.ticket-stock-turnover', $array)->setPaper('a4', 'portrait');
        return $pdf->download('report.pdf');
    }

    public function individualSalesReportCreate() {
        $advisors = \App\User::where('role', 'advisor')->get();
        return view(auth()->user()->role . '.reports.individual-sales.create')
            ->with('title', 'Generate Individual Sales Report')
            ->with('advisors', $advisors);
    }

    public function globalSalesReportCreate() {
        return view(auth()->user()->role . '.reports.global-sales.create')
            ->with('title', 'Generate Global Sales Report');
    }

    public function individualSalesReportShow() {
        $link = "/" . auth()->user()->role ."/reports/individual-sales/pdf?dateFrom="
            .  urlencode(request()->input('dateFrom'))
            . "&dateTo=" .  urlencode(request()->input('dateTo'))
            . "&advisor=" .  urlencode(request()->input('advisor'))
            . "&reportScope=" .  urlencode(request()->input('reportScope'));

        return view(auth()->user()->role . '.reports.individual-sales.show')
            ->with('title', 'Individual Sales Report')
            ->with('link', $link);
    }

    public function globalSalesReportShow() {
        $link = "/" . auth()->user()->role ."/reports/global-sales/pdf?dateFrom="
            .  urlencode(request()->input('dateFrom'))
            . "&dateTo=" .  urlencode(request()->input('dateTo'))
            . "&reportScope=" .  urlencode(request()->input('reportScope'));

        return view(auth()->user()->role . '.reports.global-sales.show')
            ->with('title', 'Global Sales Report')
            ->with('link', $link);
    }

    public function individualSalesReportGenerate() {

        $this->validate(request(),
            [
                'advisor' => 'exists:users,id'
            ]);

        if(auth()->user()->role == 'manager') {
            $advisorId = request()->input('advisor');
        } else {
            $advisorId = auth()->user()->id;
        }

        $startPeriod = request()->input('dateFrom');
        $endPeriod =  request()->input('dateTo');

        $SaleFareUSD = 0;
        $currencyTotal = 0;
        $taxLocalTotal = 0;
        $taxOtherTotal = 0;
        $saleTotalTotal = 0;
        $cashTotal = 0;
        $saleUSDTotal = 0;
        $saleTotalCurrency = 0;
        $commissionAmountTotal = 0;
        $ticketsCount = 0;


        $scope_blank_type_ids = array_pluck(\App\BlankType::where('scope', request()->input('reportScope'))->get(),'id');

        $blanks = \App\User::find($advisorId)->blanks()
            ->whereBetween('sold_at', [$startPeriod, $endPeriod])
            ->whereIn('blank_type_id', $scope_blank_type_ids)
            ->orderBy('blank_number')->get();

        foreach($blanks as $blank) {
            if($blank->sale->AwaitingPayment == 1) {

            } else {
                $SaleFareUSD += $blank->sale->SaleFareUSD;
                $currencyTotal += $blank->sale->SaleFare;
                $taxLocalTotal += $blank->sale->SaleTaxLocal;
                $taxOtherTotal += $blank->sale->SaleTaxOther;
                $saleTotalTotal += $blank->sale->SaleTotal;
                if($blank->sale->PaymentMethod == 'CASH') {
                    $cashTotal += $blank->sale->SaleTotal;
                }
                if($blank->sale->PaymentMethod == 'CARD') {
                    $saleUSDTotal += round($blank->sale->SaleTotal / $blank->sale->CurrencyRate);
                    $saleTotalCurrency += round($blank->sale->SaleTotal);
                }

                $commissionAmountTotal += $blank->sale->SaleCommission;
                $ticketsCount += 1;
            }
        }

        $array =
            [
                'start_period' => $startPeriod,
                'end_period' => $endPeriod,
                'blanks' => $blanks,
                'SaleFareUSD' => round($SaleFareUSD),
                'scope' =>  request()->input('reportScope'),
                'advisor' => \App\User::find($advisorId),
                'currencyTotal' => $currencyTotal,
                'taxLocalTotal' => $taxLocalTotal,
                'taxOtherTotal' => $taxOtherTotal,
                'saleTotalTotal' => round($saleTotalTotal),
                'cashTotal' => round($cashTotal),
                'saleUSDTotal' => $saleUSDTotal,
                'saleTotalCurrency' => $saleTotalCurrency,
                'commissionAmountTotal' => round($commissionAmountTotal),
                'ticketsCount' => $ticketsCount,
                'totalNet' => $saleTotalCurrency - $commissionAmountTotal,
            ];

        $pdf = \PDF::loadView('reports.individual-sales', $array)->setPaper('a4', 'landscape');
        return $pdf->stream('report.pdf');
    }

    public function globalSalesReportGenerate() {

        $this->validate(request(),
            [
                'advisor' => 'exists:users,id'
            ]);

        $startPeriod = request()->input('dateFrom');
        $endPeriod =  request()->input('dateTo');

        $SaleFareUSD = 0;
        $currencyTotal = 0;
        $taxLocalTotal = 0;
        $taxOtherTotal = 0;
        $saleTotalTotal = 0;
        $cashTotal = 0;
        $saleUSDTotal = 0;
        $saleTotalCurrency = 0;
        $commissionAmountTotal = 0;
        $ticketsCount = 0;


        $scope_blank_type_ids = array_pluck(\App\BlankType::where('scope', request()->input('reportScope'))->get(),'id');

        $blanks = \App\Blank::
            whereBetween('sold_at', [$startPeriod, $endPeriod])
            ->whereIn('blank_type_id', $scope_blank_type_ids)
            ->orderBy('blank_number')
            ->get();

        foreach($blanks as $blank) {
            if($blank->sale->AwaitingPayment == 1) {

            } else {
                $SaleFareUSD += $blank->sale->SaleFareUSD;
                $currencyTotal += $blank->sale->SaleFare;
                $taxLocalTotal += $blank->sale->SaleTaxLocal;
                $taxOtherTotal += $blank->sale->SaleTaxOther;
                $saleTotalTotal += $blank->sale->SaleTotal;
                if($blank->sale->PaymentMethod == 'CASH') {
                    $cashTotal += $blank->sale->SaleTotal;
                }
                if($blank->sale->PaymentMethod == 'CARD') {
                    $saleUSDTotal += round($blank->sale->SaleTotal / $blank->sale->CurrencyRate);
                    $saleTotalCurrency += round($blank->sale->SaleTotal);
                }

                $commissionAmountTotal += $blank->sale->SaleCommission;
                $ticketsCount += 1;
            }
        }

        $array =
            [
                'start_period' => $startPeriod,
                'end_period' => $endPeriod,
                'blanks' => $blanks,
                'SaleFareUSD' => round($SaleFareUSD),
                'scope' =>  request()->input('reportScope'),
                'currencyTotal' => $currencyTotal,
                'taxLocalTotal' => $taxLocalTotal,
                'taxOtherTotal' => $taxOtherTotal,
                'saleTotalTotal' => round($saleTotalTotal),
                'cashTotal' => round($cashTotal),
                'saleUSDTotal' => $saleUSDTotal,
                'saleTotalCurrency' => $saleTotalCurrency,
                'commissionAmountTotal' => round($commissionAmountTotal),
                'ticketsCount' => $ticketsCount,
                'totalNet' => $currencyTotal - $commissionAmountTotal,
            ];

        $pdf = \PDF::loadView('reports.global-sales', $array)->setPaper('a4', 'landscape');
        return $pdf->stream('report.pdf');
    }
}

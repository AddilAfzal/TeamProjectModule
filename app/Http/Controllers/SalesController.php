<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;


class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales = \App\Sale::all();
        return view(auth()->user()->role . ".sales.index")->with('title', 'Sales')->with('sales', $sales);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//        $domesticBlanks = \App\User::find(auth()->user()->id)->getDomesticBlanks();
//        $interlineBlanks = \App\User::find(auth()->user()->id)->getInterlineBlanks();
        $blanks = \App\User::find(Auth::user()->id)->getBlanks();

        return view(auth()->user()->role . ".sales.create")
            ->with('title', 'Sales')
            ->with('blanks', $blanks);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateRequest($request);
        if($request->paymentMethod == 'CARD') {
            if(!preg_match('/^\d{14,16}$/', $request->creditCardNumber)) {
                return redirect()->back()->withErrors(['creditCardNumber' => "The credit card number provided is invalid."])->withInput();
            }
        }

        $customer = \App\Customer::find($request->customerId);
        $blank = \App\Blank::find($request->blankId);

        $fare = $customer->calculateDiscountedFarePrice($request->fare);
        $saleTotal = $fare + $request->taxLocal + $request->taxOther;

        $blank->is_sold = 1;
        $blank->sold_at = \Carbon\Carbon::createFromTimestamp(time());
        $blank->save();

        $sale = \App\Sale::create(
            [
                'user_id' => auth()->user()->id,
                'customer_id' => $customer->id,
                'blank_id' => $blank->id,
                'SaleRef' => time() . rand(10 * 45, 100 * 98),
                'SaleTime' => \Carbon\Carbon::createFromTimestamp(time()),
                'SaleCurrency' => \App\TravelAgent::getLocalCurrency(),
                'CurrencyRate' => \App\Currency::find(\App\TravelAgent::getLocalCurrency())->Rate,
                'SaleFareUSD' => ($fare) / (\App\Currency::find(\App\TravelAgent::getLocalCurrency())->Rate),
                'SaleFare' => $fare,
                'SaleTaxLocal' => $request->taxLocal,
                'SaleTaxOther' => $request->taxOther,
                'SaleTotal' => $saleTotal,
                'DiscountType' => $customer->discount->type,
                'DiscountAmount' => ($request->fare - $fare),
                'CommissionRate' => $blank->blank_type->commission_rate,
                'SaleCommission' => $blank->blank_type->commission_rate * $fare,
                'AwaitingPayment' => (($request->payLater == 1) ? true : false),
                'PaymentMethod' => (($request->payLater == 1) ? 'PENDING' : $request->paymentMethod),
                'CardNumber' => (isset($request->creditCardNumber) ? $request->creditCardNumber : null ),
                'CardType' => (isset($request->cardType) ? $request->cardType : null ),
                'PaymentTime' => (($request->payLater == 1) ? null : \Carbon\Carbon::createFromTimestamp(time())),
            ]
        );

        if($request->payLater == 1)
        {
            $customer->addToBalance($saleTotal);
        }


        return redirect(auth()->user()->role . '/sales/')->with('message', ['Sale Recorded Successfully', "Sale was recorded successfully. Reference Number: {$sale->SaleRef} "]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sale = \App\Sale::find($id);
        return view(auth()->user()->role . ".sales.show")->with('title', 'Sales')->with('sale', $sale);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function find(Request $request)
    {
        //$users = \App\Customer::where('Firstname', $request->get('name'))->limit(5)->get(['Title', 'Firstname', 'Surname', 'DateOfBirth', 'PhoneNumber', 'id']);
        $customers = DB::table('customers')
            ->join('addresses', 'customers.id', '=', 'addresses.customer_id')
            ->select('Title', 'Firstname', 'Surname', 'DateOfBirth', 'PrimaryPhoneNumber', 'customers.id', 'addresses.*')
            ->where('Firstname', $request->get('name'))
            ->limit(5)
            ->get();

        return $customers;
        //$customers = \App\Customer::all(['Firstname', 'Surname', 'Title',])->where('id', '=', '3')->get();
    }

    public function confirmation()
    {
        $request = request();
        $this->validateRequest($request);
        $request->flash();
        return view(auth()->user()->role . ".sales.confirmation")->with('title', 'Sale Confirmation');
    }

    public function validateRequest(Request $request)
    {
        $this->validate($request,
            [
                "blankId" => ['required',
                    Rule::exists('blanks', 'id')
                        ->where(
                            function ($query) {
                                $query->where(
                                    [
                                        'is_sold' => 0,
                                        'user_id' => auth()->user()->id,
                                        'id' => request('blankId'),
                                    ]
                                );
                            }
                        )
                ],
                "fare" => "required|regex:/^\d*(\.\d{2})?$/",
                "taxLocal" => "required|regex:/^\d*(\.\d{2})?$/",
                "taxOther" => "required|regex:/^\d*(\.\d{2})?$/",
                "customerId" => "required|exists:customers,id",
                "paymentMethod" => "required|in:" . implode(",", \App\Customer::$payment_methods),
                "creditCardNumber" => "required_if:paymentMethod,CARD",
                "cardType" => "required_if:paymentMethod,CARD",
                "firstName" => "required",
                "surname" => "required",
                "dateOfBirth" => "required",
                "addressLine1" => "required",
                "addressLine2" => "",
                "addressLine3" => "",
                "addressLine4" => "",
                "town" => "required",
                "postalArea" => "required",
                "governingDistrict" => "required",
                "emailAddress" => "required|email",
                "primaryPhoneNumber" => "required",
                "secondaryPhoneNumber" => "",
                "payLater" => "in:1"
            ]
        );
    }

    public function overdueIndex() {
        return view(auth()->user()->role . ".sales.overdue")->with('title', 'Overdue Sales');
    }

    public function search() {
        
        return view(auth()->user()->role . ".sales.search")->with('title', 'Search Sale')->with('message', 'Search Sale');
    }

    public function updatePaymentStatus(Request $request)
    {
        $this->validate($request,
            [
                'id' => [
                    'required',
                    Rule::exists('sales')->where(function ($query) {
                        $query->where('AwaitingPayment', "1")
                                ->where('PaymentMethod', "PENDING");
                    }),
                ],
                'paymentMethod' => "required|in:" . implode(',', \App\Customer::$payment_methods),
                'creditCard' => 'required_if:paymentMethod,CARD',
                'cardType' => 'required_if:paymentMethod,CARD',
            ]
        );
        if($request->paymentMethod == 'CARD') {
            if(!preg_match('/^\d{14,16}$/', str_replace(' ', '',$request->creditCard))) {
                return redirect()->back()->withErrors(['creditCard' => "The credit card number provided is invalid."])->withInput();
            }
        }
        if($request->paymentMethod == 'CARD') {
            if(!preg_match('/^[A-Z]{1,3}$/', $request->cardType)) {
                return redirect()->back()->withErrors(['cardType' => "The credit card type provided is invalid. Must be one to three upper case characters."])->withInput();
            }
        }


        $sale = \App\Sale::find($request->id);
        $sale->PaymentMethod = $request->paymentMethod;
        $sale->PaymentTime = \Carbon\Carbon::createFromTimestamp(time());
        $sale->AwaitingPayment = 0;
        $sale->CardNumber = ($request->creditCard != null) ? str_replace(' ', '',$request->creditCard) : null;
        $sale->CardType = ($request->cardType != null) ? $request->cardType : null;
        $sale->save();

        $customer = \App\Customer::find($sale->customer_id);
        $customer->deductFromBalance($sale->SaleTotal);

        return redirect(auth()->user()->role . '/sales/' . $request->id)->with('message', ['Payment Status Updated Successfully', "The payment status of this sale was updated successfully."]);
    }
}

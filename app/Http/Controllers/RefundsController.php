<?php

namespace App\Http\Controllers;

use App\Blank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class RefundsController extends Controller
{
    public function index()
    {
        $refunds = \App\Refund::all();
        return view(auth()->user()->role . '.refunds.index')->with('title', 'Refunds')->with('refunds', $refunds);
    }

    public function create()
    {
        $sold_blanks = \App\Blank::all()->where('is_sold', 1)->whereNotIn('id', array_pluck(\App\Refund::select('blank_id')->get(), 'blank_id') );

        return view(auth()->user()->role . '.refunds.create')->with('title', 'Record Refund')->with('blanks', $sold_blanks);
    }

    public function store(Request $request)
    {

        $this->validate($request,
            [
                'blankId' => 'required|exists:blanks,id|not_exists:refunds,blank_id',
                'refundAmount' => 'required|regex:/^\d*(\.\d{2})?$/',
                "refundMethod" => "required|in:" . implode(",", \App\Customer::$payment_methods),
                "refundReason" => "required|string",
            ]
        );
        $blank = \App\Blank::find($request->blankId);
        $sale = $blank->sale;

        $refund = \App\Refund::recordRefund($blank->id, $sale->id, auth()->user()->id, $request->refundAmount, $request->refundReason, $request->refundMethod, \Carbon\Carbon::createFromTimestamp(time()));

        return redirect(auth()->user()->role . '/refunds/')->with('message', ['Refund Recorded Successfully', "Refund was recorded successfully."]);
    }

    public function show(\App\Refund $refund)
    {
        return view(auth()->user()->role . ".refunds.show")->with('title', 'Refund Details')->with('refund', $refund);
    }

}

<?php

namespace App\Http\Controllers;

use App\Currency;
use Illuminate\Http\Request;

class CurrenciesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view(auth()->user()->role . ".currencies.index")->with('currencies', Currency::all()->sortBy('CurrencyName'))->with('title', 'Currencies');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view(auth()->user()->role . ".currencies.create")->with('title', 'Create Currency');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,
        [
            'name' => 'required|not_exists:currencies,CurrencyName',
            'abbreviation' => 'required|not_exists:currencies,CurrencyAbbreviation',
            'currentRate' => 'required|regex:/^([0-9]{1,5}(\.[0-9]{1,4})?)$/',
        ]
        );

        \App\Currency::create([
            'CurrencyName' => $request['name'],
            'CurrencyAbbreviation' => $request['abbreviation'],
            'Rate' => $request['currentRate']
        ]);

        return redirect(auth()->user()->role . "/currencies/")->with('message', ['Currency Added Successfully', "Currency was added successfully."]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view(auth()->user()->role . ".currencies.show")->with('currency', Currency::find($id))->with('title', 'Currencies');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function updateRate(Request $request)
    {
        $this->validate($request,
            [
                'id' => 'required|exists:currencies,id',
                'rate' => 'required|regex:/^([0-9]{1,5}(\.[0-9]{1,4})?)$/'
            ]
        );

        $currency = \App\Currency::find($request->id);
        $currency->Rate = $request->rate;
        $currency->save();

        return redirect(auth()->user()->role . '/currencies/' . $request->id)->with('message', ['Currency Rate Updated Successfully', "The current rate associated with this currency was updated successfully."]);

    }
}

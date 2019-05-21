<?php

namespace App\Http\Controllers;

use App\TravelAgent;
use Illuminate\Http\Request;

class TravelAgentController extends Controller
{
    public function index() {
        return view('admin.travelagent.index')->with('title', 'Travel Agent Details');
    }
    public function edit() {
        return view('admin.travelagent.edit')->with('title', 'Edit Travel Agent Details')
            ->with('address', TravelAgent::getAddress())
            ->with('name', TravelAgent::getName())
            ->with('phone', TravelAgent::getPhoneNumber());
    }

    public function update(Request $request) {
        $this->validate(request(),
            [
                'name' => 'required|max:50',
                'AddressLine1' => 'required|max:100',
                'AddressLine2' => 'max:100',
                'AddressLine3' => 'max:100',
                'AddressLine4' => 'max:100',
                'CityTown' => 'required|max:50',
                'PostalArea' => 'required|max:20',
                'GoverningDistrict' => 'required|max:100',
                'phoneNumber' => 'required|min:11',
                'localCurrency' => 'required|exists:currencies,id',
            ]);

        TravelAgent::setAddress($request->all());
        TravelAgent::setName($request->name);
        TravelAgent::setLocalCurrency($request->localCurrency);
        TravelAgent::setPhoneNumber($request->phoneNumber);

        return redirect("/admin/travelagent")->with('message', ['Success', 'Travel agent details were updated successfully!']);
    }

}

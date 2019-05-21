<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DiscountsController extends Controller
{
    public function index() {
        $discounts = \App\Discount::all();
        return view(auth()->user()->role . '.discounts.index')
            ->with('discounts', $discounts)
            ->with('title', 'Discounts');
    }

    public function show(\App\Discount $discount) {
        return view(auth()->user()->role . '.discounts.show')
            ->with('discount', $discount)
            ->with('title', 'Discount');
    }

    public function create() {
        return view(auth()->user()->role . '.discounts.create')
            ->with('title', 'Create Discount');
    }

    public function store(Request $request) {
        $this->validate($request,
            [
                'discountBand' => "required|unique:discounts,band",
                'discountRate' => "required",
                'discountType' => ["required", Rule::in(['FIXED','FLEXIBLE'])],
            ]
            );

        if($request->discountType == 'FLEXIBLE') {
            if(!preg_match('/^(?:[0-9]+\,0\.[0-9]{1,2})(?:\|[0-9]+\,0\.[0-9]{1,2})*$/', str_replace(' ', '',$request->discountRate))) {
                return redirect()->back()->withErrors(['discountRate' => "The discount rate provided is invalid."])->withInput();
            }
        }

        $discount = new \App\Discount;
        $discount->band = $request->discountBand;
        $discount->type = $request->discountType;
        $discount->rate = $request->discountRate;
        $discount->save();

        return redirect(auth()->user()->role . '/discounts/' . $discount->id)->with('message', ['Band was created Successfully', "A new band has been created successfully."]);
    }

    public function destroy(Request $request)
    {
        $this->validate($request,
            [
                'discountId' => 'required|exists:discounts,id'
            ]
        );

        $discount = \App\Discount::find($request->discountId);

        if(count($discount->customers) > 0) {
            return redirect(auth()->user()->role . '/discounts/' . $discount->id)
                ->with('message',['Failed', 'Cannot deleted a discount band that has customers assigned.']);
        }

        \App\Discount::destroy($discount->id);

        return redirect("/" . auth()->user()->role . "/discounts/")
            ->with('message',['Deleted Successfully', 'Discount band has been deleted.']);

        //check that there arent any customers on this plan

    }

    public function assignCustomer(Request $request)
    {
        $this->validate($request,
            [
                'discountId' => 'required|exists:discounts,id',
                'customerId' => 'required|exists:customers,id'
            ]
        );

        $discount = \App\Discount::find($request->discountId);
        $customer = \App\Customer::find($request->customerId);

        if($customer->Type != 'VALUED')
        {
            return redirect()->back()->withErrors(['customerId' => "Please select a valued customer."])->withInput();
        } else {
            $customer->discount_id = $discount->id;
            $customer->save();

            return redirect(auth()->user()->role . '/discounts/' . $discount->id)
                ->with('message',['Assigned Successfully', 'Your selected user has been re-assigned a new discount band.']);
        }


        //Check that customer is valued
        //Check that discount id
    }
}

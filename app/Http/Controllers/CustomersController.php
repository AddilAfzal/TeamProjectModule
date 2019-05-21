<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = \App\Customer::all();
        return view(auth()->user()->role . '.customers.index')
            ->with('title', 'Customers')
            ->with('customers', $customers);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function create()
    {
        return view(auth()->user()->role . '.customers.create')
            ->with('title', 'Create Customer');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $array = \App\Customer::$payment_methods;
        $this->validate($request,
            [
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
                "emailAddress" => "required|unique:customers,EmailAddress|email",
                "primaryPhoneNumber" => "required",
                "secondaryPhoneNumber" => "",
                "paymentMethod" => ["required", Rule::in($array)],
            ]);

        $customer = \App\Customer::create(
            [
                "Title" => $request->title,
                "Firstname" => $request->firstName,
                "Surname" => $request->surname,
                "DateOfBirth" => $request->dateOfBirth,
                "PrimaryPhoneNumber" => $request->primaryPhoneNumber,
                "SecondaryPhoneNumber" => $request->secondaryPhoneNumber,
                "EmailAddress" => $request->emailAddress,
                "BalanceOutstanding" => "0.00",
                "IsValued" => false,
                "IsRegular" => false
            ]
        );

        $customer->save();

        $address = \App\Address::create(
            [
                'AddressLine1' => $request->addressLine1,
                'AddressLine2' => $request->addressLine2,
                'AddressLine3' => $request->addressLine3,
                'AddressLine4' => $request->addressLine4,
                'CityTown' => $request->town,
                'PostalArea' => $request->postalArea,
                'GoverningDistrict' => $request->governingDistrict,
                'customer_id' => $customer->id
            ]
        );

        $address->save();

        //dd($request->all());
        return redirect("/" . auth()->user()->role . "/customers")->with('message',['Success', 'Customer account was created.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $customer = \App\Customer::find($id);

        if($customer->discount->type == 'FLEXIBLE') {
            foreach(explode('|', $customer->discount->rate) as $range) {
                $tmp = explode(',', $range);
                $discountRanges[$tmp[0]] = $tmp[1];
            }
        } else {
            $discountRanges = [];
        }

        $awaiting_payment = $customer->sales()->where('AwaitingPayment', 1)->get();

        return view(auth()->user()->role . '.customers.show')
            ->with('title', 'Customer')
            ->with('customer', $customer)
            ->with('discountRanges', $discountRanges)
            ->with('awaiting_payment', $awaiting_payment);
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
    public function destroy(Request $request)
    {
        $this->validate($request,
            [
                'customerId' => 'required|exists:customers,id'
            ]);

        $customer = \App\Customer::find($request->customerId);
        //dd($customer->sales);
        if(count($customer->sales) > 0)
        {
            return redirect("/" . auth()->user()->role . "/customers/" . $customer->id)->with( 'message', ['Failed', 'Cannot delete a customer account that has sales associated with it.'] );
        } else {
            \App\Customer::destroy($customer->id);
            return redirect("/" . auth()->user()->role . "/customers/")->with('message', [ 'Account Deleted', 'Account was deleted successfully.'] );
        }

    }

    public function search(Request $request)
    {
        $this->validate($request,
            [
                'customerName' => 'required|string'
            ]);

        $customers = \App\Customer::where('Surname', 'LIKE', "%" . $request->customerName . "%")->get();

        return view(auth()->user()->role . '.customers.search')
            ->with('customers', $customers)
            ->with('message', count($customers) . " result" . ((count($customers) != 1) ? "s" : "" ) . " found matching '" . $request->customerName . "'")
            ->with('title', 'Search Customer');
    }

    public function paymentLetterIndex(\App\Customer $customer) {
        $awaiting_payment = $customer->sales()->where('AwaitingPayment', 1)->get();

        return view(auth()->user()->role . '.customers.payment-letter.index')
            ->with('title', 'Customer Payment Letter')
            ->with('customer', $customer);
    }

    public function paymentLetterGet(\App\Customer $customer) {
        $awaiting_payment = $customer->sales()->where('AwaitingPayment', 1)->get();

        $a = array_pluck($awaiting_payment,'SaleTotal');

        $array =
            [
                'customer' => $customer,
                'agent' => \App\TravelAgent::class,
                'date' => \Carbon\Carbon::today()->format('l jS \\of F Y'),
                'amount' => array_sum($a),
                'currency' => \App\Currency::find(\App\TravelAgent::getLocalCurrency()),
                'manager' => auth()->user()
            ];


        $pdf = \PDF::loadView('manager.customers.payment-letter.reminder_letter', $array)->setPaper('a4', 'portrait');
        return $pdf->stream('customer-reminder-letter.pdf',array('Attachment'=>0));;

//        return view(auth()->user()->role . '.customers.payment-letter.reminder_letter')
//            ->with('customer', $customer);
    }

    public function updateAccountType(Request $request)
    {
        $this->validate($request,
            [
                'customerId' => 'required|exists:customers,id',
                'customerType' => 'required|in:' . implode(',',\App\Customer::$account_types)
            ]
        );

        $customer = \App\Customer::find($request->customerId);
        $customer->updateAccountType($request->customerType);

        return redirect("/" . auth()->user()->role . "/customers/" . $customer->id)->with('message',['Updated Successfully', 'Account type has been updated.']);
    }

    public function updateContact(Request $request)
    {
        $this->validate($request,
            [
                "customerId" => "required|exists:customers,id",
                "addressLine1" => "required",
                "addressLine2" => "",
                "addressLine3" => "",
                "addressLine4" => "",
                "town" => "required",
                "postalArea" => "required",
                "governingDistrict" => "required",
                "emailAddress" => "required|email",
                "primaryPhoneNumber" => "required",
                "secondaryPhoneNumber" => ""
            ]);

        $customer = \App\Customer::find($request->customerId);

        $customer->address->AddressLine1 = $request->addressLine1;
        $customer->address->AddressLine2 = $request->addressLine2;
        $customer->address->AddressLine3 = $request->addressLine3;
        $customer->address->AddressLine4 = $request->addressLine4;
        $customer->address->CityTown = $request->town;
        $customer->address->PostalArea = $request->postalArea;
        $customer->address->GoverningDistrict = $request->governingDistrict;
        $customer->EmailAddress = $request->emailAddress;
        $customer->PrimaryPhoneNumber = $request->primaryPhoneNumber;
        $customer->SecondaryPhoneNumber = $request->secondaryPhoneNumber;
        $customer->updated_at = time();

        $customer->save();
        $customer->address->save();

        return redirect("/" . auth()->user()->role . "/customers/" . $customer->id)->with('message',['Updated Successfully', 'Contact details were updated successfully.']);
    }

    public function logPaymentReminder(Request $request) {

        $this->validate($request,
            [
                'customerId' => 'required|exists:customers,id'
            ]
        );

        $customer = \App\Customer::find($request->customerId);

        $awaiting_payment = $customer->sales()->where('AwaitingPayment', 1)->get();

        $a = array_pluck($awaiting_payment,'SaleTotal');

        $sum = array_sum(array_pluck($awaiting_payment,'SaleTotal'));

        if(count($awaiting_payment) < 1) {
            return redirect()->back()->withErrors(['customerId' => "This customer cannot be issued a payment reminder letter as they do not have any debit associated with their account."])->withInput();
        }

        $letter = \App\ReminderLetter::create(
            [
                'customer_id' => $customer->id,
                'user_id' => auth()->user()->id,
                'amount_due' => $sum,
                'sent_date' => \Carbon\Carbon::createFromTimestamp(time())
            ]
        );

        return redirect("/" . auth()->user()->role . "/customers/$customer->id/payment-letter")->with('message',['Payment Reminder Logged Successfully', 'The system has logged that a new payment reminder letter was sent.']);
    }

}

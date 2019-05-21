<?php

namespace App\Http\Controllers;

use App\BlankType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class BlankTypesController extends Controller
{
    public function index() {
        $valid_filters = ['INTERLINE', 'DOMESTIC', 'NA'];

        if(in_array(request()->input('filter'), $valid_filters)) {
            $blankTypes = BlankType::all()->where('scope', request()->input('filter'));
        } else {
            $blankTypes = BlankType::all()->sortBy('prefix');
        }

        //dd(request()->input());

        return view(auth()->user()->role . '.blanktypes.index')->with('title', 'Blank Types')->with('types', $blankTypes)->with('valid_filters', $valid_filters);
    }

    public function create() {
        return view('admin.blanktypes.create')
            ->with('title', 'Create Blank Type')
            ->with('subTypes', BlankType::$valid_blank_sub_types)
            ->with('scopes', BlankType::$valid_scopes);
    }

    public function store()
    {
        $this->validate(request(),
            [
                'inputBlankTypeNumber' => 'integer|required|digits:3|not_exists:blank_types,prefix',
                'selectBlankSubType' => 'blanktype_subtype|required',
                'selectBlankScope' => 'blanktype_scope|required',
                'inputCommissionRate' => 'commission_rate|required',
                'inputNumberOfCoupons' => 'required|integer|between:1,100',
            ]
        );

        BlankType::create(
            [
                'prefix' => request('inputBlankTypeNumber'),
                'commission_rate' => request('inputCommissionRate'),
                'type' => request('selectBlankSubType'),
                'scope' => request('selectBlankScope'),
                'number_of_coupons' => request('inputNumberOfCoupons')
            ]
        );

        return redirect('/' . auth()->user()->role . "/blanktypes/")
            ->with('message',['Registered Successfully', 'Blank Type was registered successfully.']);;
    }

    public function show($id) {
        $blank_type = \App\BlankType::find($id);
        if($blank_type == null) {
            abort(404);
        }

        $blanks = \App\Blank::where('blank_type_id', $id)->simplePaginate(20);

        //dd($blank_type);
        return view(auth()->user()->role . '.blanktypes.show')
            ->with('title', 'Blank Type ' . $blank_type->prefix)
            ->with('blank_type', $blank_type)
            ->with('blanks', $blanks);
    }

    public function updateRate(Request $request)
    {
        $this->validate($request,
            [
                'blank_type_id' => 'required|exists:blank_types,id',
                'blank_type_rate' => 'required|regex:/^([0-9]{1,2}(?:\.[0-9]{1,2})?)$/',
            ]
        );

        $blank_type = \App\BlankType::find($request->blank_type_id);

        $blank_type->Commission_rate = $request->blank_type_rate/100;

        $blank_type->save();

        return redirect('/' . auth()->user()->role . "/blanktypes/")
            ->with('message',['Updated Successfully', 'Commission rate was updated successfully.']);;
    }
}

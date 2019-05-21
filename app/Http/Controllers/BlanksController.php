<?php

namespace App\Http\Controllers;

use App\Blank;
use App\BlankType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlanksController extends Controller
{
    private $ats = ['title' => 'Blanks', 'loggedin' => true, 'firstname' => 'Addil', 'surname' => 'Afzal'];

    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('admin');
    }

    public function index()
    {
        $valid_filters = ['INTERLINE', 'DOMESTIC', 'NA'];

        if(in_array(request()->input('filter'), $valid_filters)) {
            $blankTypes = BlankType::all()->where('scope', request()->input('filter'));
        } else {
            $blankTypes = BlankType::all()->sortBy('prefix');
        }
        
        $blanks = Blank::latest()->simplePaginate(15);
        return view(auth()->user()->role . '.blanks.index')->with('blanks', $blanks)->with('title', 'Blanks');
    }

    public function create()
    {
        $types = \App\BlankType::all();
        return view(auth()->user()->role . '.blanks.create')->with('types',$types)->with('title','Blanks');
    }

    public function store(Request $request)
    {
        $messages = [
            'size'    => 'The :attribute must be exactly :size characters in length'
        ];

//        $this->validate(request(),
//            [
//                'inputBlankNumberFrom' => 'integer|required|digits:8',
//                'inputBlankNumberTo' => 'integer|required|digits:8',
//                'selectBlankType' => 'exists:blank_types,id|required'
//            ],
//            $messages
//        );

        //Is from greater than to?
        if($request->inputBlankNumberFrom > $request->inputBlankNumberTo ) {
            return redirect()->back()->withErrors(['inputBlankNumberFrom' => 'Blank Number Range: Invalid range specified.'])->withInput();
        }

        $blank_type = \App\BlankType::find($request->selectBlankType);

        $blankFromFull = $blank_type->prefix . $request->inputBlankNumberFrom;
        $blankToFull = $blank_type->prefix . $request->inputBlankNumberTo;

        //Do blank in the range already exist?
        $blanksCount = DB::table('blanks')
            ->whereBetween('blank_number', [$blankFromFull, $blankToFull])->count();
        $blanksMax = DB::table('blanks')->whereBetween('blank_number', [$blankFromFull, $blankToFull])->max('blank_number');
        $blanksMin = DB::table('blanks')->whereBetween('blank_number', [$blankFromFull, $blankToFull])->min('blank_number');

        if($blanksCount == 1) {
            return redirect()->back()
                ->withErrors(['inputBlankNumberFrom' => 'A blank within the given range already exists. Blank: ' . $blanksMin])->withInput();
        } elseif($blanksCount > 1) {
            return redirect()->back()
                ->withErrors(['inputBlankNumberFrom' => 'Blanks within the given range already exists. Overlapping range: ' . $blanksMin . ' - ' . $blanksMax])->withInput();
        } else {
            //Continue
        }


        //Check that first 3 numbers of blank number are in blank types table.

        $tmp = $request->inputBlankNumberTo - $request->inputBlankNumberFrom;

        for($i = 0; $i < ($tmp + 1); $i++) {
            $blank = new \App\Blank;
            $blank->blank_number = "" . $blankFromFull + $i . "";
            $blank->blank_type_id = request('selectBlankType');
            $blank->user_id = 0; //Un assigned
            $blank->created_at = \Carbon\Carbon::createFromTimestamp(time());
            $blank->is_sold = false;
            $blank->save();
        }



        return redirect("/" . auth()->user()->role . "/blanks")->with('message',['Registration Successful', 'Blanks were registered successfully.']);
    }

    public function show(Blank $blank)
    {
        $users = \App\User::where('role', "!=", 'admin')->get();
        return view(auth()->user()->role . '.blanks.show')->with('title', 'Blank')->with('blank', $blank)->with('users', $users);
    }

    public function assign(Request $request) {
        $this->validate($request,
            [
                'blankId' => 'exists:blanks,id|required',
                'travelAdvisor' => 'exists:users,id|required'
            ]);
        $blank = \App\Blank::find($request->blankId);
        if(!$blank->assign($request->travelAdvisor)) {
            return redirect("/" . auth()->user()->role . "/blanks/" . $request->blankId)
                ->with('message',['Failed', 'Cannot re-assign a blank that has been sold.']);
        } else {
            return redirect("/" . auth()->user()->role . "/blanks/" . $request->blankId)
                ->with('message',['Success', 'Blank has been assigned to ' . \App\User::find($request->travelAdvisor)->name]);
        }

    }

    public function destroy(Request $request)
    {
        $this->validate($request,
            [
                'blankId' => 'exists:blanks,id|required'
            ]);

        $blank = \App\Blank::find($request->blankId);
        $blank_number = $blank->blank_number;
        \App\Blank::destroy($request->blankId);

        return redirect("/" . auth()->user()->role . "/blanks/")
            ->with('message',['Success', 'Blank with number ' . $blank_number . ' has been deleted.']);
    }

    public function search(Request $request) {
        $blanks = \App\Blank::where('blank_number', 'LIKE', "%{$request->blankNumber}%")->get();
        return view(auth()->user()->role . '.blanks.search')
            ->with('blanks', $blanks)
            ->with('message', count($blanks) . " result" . ((count($blanks) != 1) ? "s" : "" ) . " found matching '" . $request->blankNumber . "'")
            ->with('title', 'Search Blank');
    }


}

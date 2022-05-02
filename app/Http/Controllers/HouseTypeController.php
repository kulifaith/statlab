<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HouseType;
use App\Models\House;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class HouseTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $housetype = HouseType::orderBy('id', 'asc')->get();
        //Load the view and pass the house
        return view('housetype.index')->with('housetype',$housetype);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('housetype.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
            //store
            $house = new HouseType;
            $house->name = $request->get('name');
            $house->created_by = Auth::user()->id;
            $house->save();

            // todo: put option to redirect to page to add antibiotic with zone diameters, save and add antibiotic
            return redirect('housetype')
                ->with('message', trans('messages.success-creating-house'))->with('activehouse', $house->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $house = House::find($id);
        $houseType = HouseType::orderBy('name','ASC')->pluck('name', 'id')->toArray();
        
        return view('housetype.show')
        ->with('house',$house)
        ->with('houseType',$houseType);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $houseType = HouseType::find($id);

        return view('housetype.edit')
        ->with('houseType', $houseType);
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
        
            // Update
            $house = HouseType::find($id);
            $house->name = $request->get('name');
            $house->updated_by = Auth::user()->id;
            $house->save();
            return redirect('housetype')
                ->with('message', trans('messages.success-updating-house')) ->with('activehouse', $house->id);
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

}

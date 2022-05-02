<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Site;
use App\Models\HouseType;
use App\Models\House;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class HouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $house = House::orderBy('id', 'asc')->get();
        $site = ['Select Site']+Site::orderBy('name','ASC')->pluck('name', 'id')->toArray();
        $houseType = ['Select House Type']+HouseType::orderBy('name','ASC')->pluck('name', 'id')->toArray();
        //Load the view and pass the house
        return view('house.index')
        ->with('house',$house)
        ->with('site',$site)
        ->with('houseType',$houseType);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $houseType = ['Select House Type']+HouseType::orderBy('name','ASC')->pluck('name', 'id')->toArray();
        $site = ['Select Site']+Site::orderBy('name','ASC')->pluck('name', 'id')->toArray();

        return view('house.create')
                ->with('houseType', $houseType)
                ->with('site', $site);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'house_no' => 'required',
            'category_id' => 'required'

        ], [
            'house_no.required' => 'House number required',
            'category_id.required' => 'House type required'
        ]);

            //store
            $house = new House;
            \Log::info($house);
            $house->house_no = $request->get('house_no');
            $house->category_id = $request->get('category_id');
            $house->site_id = $request->get('site_id');
            $house->description = $request->get('description');
            $house->price = $request->get('price');
            $house->created_by = Auth::user()->id;
            $house->save();

            // todo: put option to redirect to page to add antibiotic with zone diameters, save and add antibiotic
            return redirect('house')
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
        
        return view('house.show')
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
        $house = House::find($id);
        $houseType = HouseType::orderBy('name','ASC')->pluck('name', 'id')->toArray();
        $site = ['Select Site']+Site::orderBy('name','ASC')->pluck('name', 'id')->toArray();
        return view('house.edit')
        ->with('house', $house)
        ->with('site', $site)
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
            $house = House::find($id);
            $house->house_no = $request->get('house_no');
            $house->site_id = $request->get('site_id');
            $house->category_id = $request->get('category_id');
            $house->price = $request->get('price');
            $house->description = $request->get('description');
            $house->updated_by = Auth::user()->id;
            $house->save();
            return redirect('house')
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

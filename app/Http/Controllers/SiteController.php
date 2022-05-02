<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HouseType;
use App\Models\Site;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $site = Site::orderBy('id', 'asc')->get();
        //Load the view and pass the house
        return view('site.index')
        ->with('site',$site);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('site.create');
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
            'name' => 'required',
            'location' => 'required'

        ], [
            'name.required' => 'Name required',
            'location.required' => 'Location required'
        ]);

            //store
            $site = new Site;
            $site->name = $request->get('name');
            $site->location = $request->get('location');
            $site->created_by = Auth::user()->id;
            $site->save();

            // todo: put option to redirect to page to add antibiotic with zone diameters, save and add antibiotic
            return redirect('site')
                ->with('message', trans('messages.success-creating-site'))->with('activesite', $site->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $site = Site::find($id);
        
        return view('site.show')
        ->with('site',$site);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $site = Site::find($id);

        return view('site.edit')
        ->with('site', $site);
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
        $rules = array('name' => 'required');
        $validator = Validator::make($request->all(), $rules);

        // process the login
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        } else {
            // Update
            $site = Site::find($id);
            $site->name = $request->get('name');
            $site->location = $request->get('location');
            $site->updated_by = Auth::user()->id;
            $site->save();
            return redirect('site')
                ->with('message', trans('messages.success-updating-site')) ->with('activesite', $site->id);
        }
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

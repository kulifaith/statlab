<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LabRow;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class LabRowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $row = LabRow::orderBy('id', 'desc')->get();
        //Load the view and pass the house
        return view('labrows.index')
        ->with('row',$row);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
            'name' => 'required'

        ], [
            'name.required' => 'Name required'
        ]);

            //store
            $row = new LabRow;
            $row->name = $request->get('name');
            $row->no_of_computers = $request->get('no_of_computers');
            $row->save();
                
            return redirect('labrows')
                ->with('message', trans('messages.success-creating-record'))->with('activerows', $row->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $row = LabRow::find($id);

        return view('labrows.edit')
        ->with('row', $row);
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
            $row = LabRow::find($id);
            $row->name = $request->get('name');
            $row->no_of_computers = $request->get('no_of_computers');
            $row->save();

            return redirect('labrows')
                ->with('message', trans('messages.success-updating-record')) ->with('activelabrows', $row->id);
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

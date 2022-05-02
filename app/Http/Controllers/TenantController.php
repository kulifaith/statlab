<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\House;
use App\Models\HouseType;
use App\Models\Site;
use App\Models\Tenant;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use DB;

class TenantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tenant = Tenant::orderBy('id', 'asc')->get();
        $site = ['Select Site']+Site::orderBy('name','ASC')->pluck('name', 'id')->toArray();
        $category = ['Select House Type']+HouseType::orderBy('name','ASC')->pluck('name', 'id')->toArray();

        $house = ['Select House Number']+House::where('available', '=', 0)->orderBy('house_no','ASC')->pluck('house_no', 'id')->toArray();
        // $house = ['Select House Number']+House::selectRaw("CONCAT (house_no, '-' ,site_id) as columns, id")->orderBy('house_no','ASC')->pluck('columns', 'id')->toArray();
        //Load the view and pass the house
        return view('tenant.index')
        ->with('tenant',$tenant)
        ->with('site',$site)
        ->with('category',$category)
        ->with('house',$house);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('tenant.create');
    }

    public function subCat(Request $request)
    {
         
        $parent_id = $request->cat_id;
         
        $site_id = House::where('id',$parent_id)
                              ->with('site')
                              ->get();
        
        return response()->json([
            'site_id' => $site_id
        ]);
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
            'firstname' => 'required',
            'lastname' => 'required',
            'contact' => 'required'

        ], [
            'firstname.required' => 'First Name required',
            'lastname.required' => 'Last Name required',
            'contact.required' => 'contact required'
        ]);

            //store
            $tenant = new Tenant;
            $tenant->firstname = $request->get('firstname');
            $tenant->middlename = $request->get('middlename');
            $tenant->lastname = $request->get('lastname');
            $tenant->email = $request->get('email');
            $tenant->contact = $request->get('contact');
            $tenant->house_id = $request->get('house_id');
            $tenant->category_id = $request->get('category_id');
            $tenant->site_id = $request->get('site_id');
            $tenant->date_in = $request->get('date_in');
            $tenant->created_by = Auth::user()->id;
            $tenant->save();

            $house_id = $request->get('house_id');
            $update_sql = "update house set available=1 where id=$house_id";
            DB::update($update_sql);
            // todo: put option to redirect to page to add antibiotic with zone diameters, save and add antibiotic
            return redirect('tenant')
                ->with('message', trans('messages.success-creating-tenant'))->with('activetenant', $tenant->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tenant = Tenant::find($id);
        $house = House::orderBy('house_no','ASC')->pluck('house_no', 'id')->toArray();
        
        return view('tenant.show')
        ->with('tenant',$tenant)
        ->with('house',$house);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tenant = Tenant::find($id);
        $house = ['Select House Number']+House::orderBy('house_no','ASC')->pluck('house_no', 'id')->toArray();

        return view('tenant.edit')
        ->with('tenant', $tenant)
        ->with('house', $house);
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
            $tenant = Tenant::find($id);
            $tenant->firstname = $request->get('firstname');
            $tenant->middlename = $request->get('middlename');
            $tenant->lastname = $request->get('lastname');
            $tenant->email = $request->get('email');
            $tenant->contact = $request->get('contact');
            $tenant->house_id = $request->get('house_id');
            $tenant->date_in = $request->get('date_in');
            $tenant->date_out = $request->get('date_out');
            $tenant->status = $request->get('status');
            //dd($tenant->status);
            $tenant->updated_by = Auth::user()->id;
            $tenant->save();

            $house_id = $request->get('house_id');
            if($tenant->status = 1){
            $update_sql = "update house set available= '0' where id=$house_id";
            DB::update($update_sql);
            }

            return redirect('tenant')
                ->with('message', trans('messages.success-updating-tenant')) ->with('activetenant', $tenant->id);
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

<?php
namespace App\Http\Controllers;
// require 'vendor/autoload.php';
use App\Models\POCResult;
use App\Models\UnhlsPatient;
use Illuminate\Http\Request;
//use App\Models\UnhlsVisit as POC;
use App\Models\POC;
use App\Models\Facility;
use App\User as User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Psr\Http\Message\RequestInterface;
use Illuminate\Http\Response;

/**
 *Contains functions for managing patient records
 *
 */
class PocController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
	public function index(Request $request)
		{
		$search = $request->search;

		//$patients = POC::all();

		$patients = POC::leftjoin('poc_results as pr', 'pr.patient_id', '=', 'poc_tables.id')
						->select('poc_tables.*','pr.results', 'pr.test_date')
						->from('poc_tables')
						->get();
		// ->paginate(Config::get('kblis.page-items'))->appends($request->except('_token'));

		if (count($patients) == 0) {
            $request->session()->flash('message', trans('messages.no-match'));
		}

		// Load the view and pass the patients
		$antenatal = array('1'=>'Lifelong ART', '2' => 'No ART', '3' => 'UNKNOWN');
		return view('poc.index')
		->with('antenatal',$antenatal)
		// ->with('facility',$facility)
		// ->with('district',$district)
		->with('patients', $patients)->withInput($request->all());
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function create()
	{
		//Create patients
		$hiv_status = array('0' => 'Positive', '1' => 'Negative', '2' => 'Unknown');
		$antenatal= array('0'=>'Select---','Lifelong ART'=>'Lifelong ART', 'No ART' => 'No ART', 'UNKNOWN' => 'UNKNOWN');
		$referral_reasons= array('0'=>'Select---','Stock Out'=>'Stock Out', 'Equipment breakdown' => 'Equipment breakdown', 'Service not avalable at facility' => 'Service not avalable at facility');
		$facilities = ['Select facility']+Facility::where('active', '=', 0)->pluck('name', 'id')->toArray();
		// $district = District::orderBy('name','ASC')
		// ->lists('name', 'id');

		return view('poc.create')
		->with('hiv_status', $hiv_status)
		->with('facilities',$facilities)
		->with('referral_reasons',$referral_reasons)
		->with('antenatal', $antenatal);
	}

	public function oldForm()
	{
		//Create patients
		$hiv_status = array('1' => 'Positive', '2' => 'Negative', '3' => 'Unknown');
		$antenatal= array('1'=>'Lifelong ART', '2' => 'No ART', '3' => 'UNKNOWN');

		return view('poc.oldRequestForm')
		->with('hiv_status', $hiv_status)
			->with('antenatal', $antenatal);
	}

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
	public function store(Request $request)
	{
        $request->validate([
            'infant_name' => 'required',
            'age' => 'required|numeric',
            'entry_point' => 'required',
            'pcr_level' => 'required',
            'collection_date' => 'required',
            'sample_id' => 'required'

        ], [
            'infant_name.required' => 'Infant name required',
            'age.required' => 'Age required',
            'entry_point.required' => 'Entry point required',
            'pcr_level.required' => 'Type of PCR required',
            'collection_date.required' => 'Collection date required',
            'sample_id.required' => 'Unique Sample ID required'
        ]);

			$patient = new POC;

			$patient->infant_name	= $request->get('infant_name');
			$patient->exp_no = $request->get('exp_no');
			$patient->age	= $request->get('age');
			$patient->gender	= $request->get('gender');
			$patient->caretaker_number	= $request->get('caretaker_number');
			$patient->given_contrimazole	= $request->get('given_contrimazole');
			$patient->delivered_at	= $request->get('delivered_at');
			$patient->infant_pmtctarv	= $request->get('infant_pmtctarv');
			$patient->entry_point	= $request->get('entry_point');
			$patient->other_entry_point	= $request->get('other_entry_point');
			$patient->collection_date	= $request->get('collection_date');
			$patient->sample_id	= $request->get('sample_id');
			$patient->pcr_level	= $request->get('pcr_level');
			$patient->feeding_status	= $request->get('feeding_status');
			$patient->breastfeeding_status	= $request->get('feeding_status');
			$patient->mother_hts	= $request->get('mother_hts');
			$patient->mother_art = $request->get('mother_art');
			$patient->nin = $request->get('nin');
			$patient->pmtct_antenatal	= $request->get('pmtct_antenatal');
			$patient->pmtct_delivery	= $request->get('pmtct_delivery');
			$patient->pmtct_postnatal	= $request->get('pmtct_postnatal');
			$patient->admission_date	= $request->get('admission_date');
			$patient->mother_name	= $request->get('mother_name');
			$patient->provisional_diagnosis	= $request->get('provisional_diagnosis');
			$patient->infant_pmtctarv	= $request->get('infant_pmtctarv');
			$patient->mother_pmtctarv	= $request->get('pmtct_delivery'); //Mother_pmtctarv
			$patient->mother_hiv_status	= $request->get('mother_hiv_status');

			 $patient->district_id = config('constants.DISTRICT_ID');
			 if(!empty($request->get('facility_id'))){
			 	$patient->facility_id = $request->get('facility_id');
			 }
			 else{
			 $patient->facility_id = config('constants.FACILITY_ID');
			 }
			$patient->testing_facility	= config('constants.FACILITY_ID');
			$patient->referral_reason	= $request->get('referral_reason');
			$patient->created_by = Auth::user()->name;

				$patient->save();

				return redirect()->route('poc.index')
				->with('message', 'Successfully saved patient information:!');

	}
    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
	// public function show($id)
	// {
	// 	//Show a patient
	// 	$patient = POC::find($id);
	//
	// 	//Show the view and pass the $patient to it
	// 	return View('poc.show')->with('patient', $patient);
	// }



	public function show(Request $request, $id)
		{
		$search = $request->get('search');

		//$patients = POC::all();

		$patient = POC::leftjoin('poc_results as pr', 'pr.patient_id', '=', 'poc_tables.id')
						->select('poc_tables.*','pr.results', 'pr.test_date', 'pr.equipment_used', 'tested_by')
						->from('poc_tables')->find($id);
//		$patient = DB::table('poc_tables')
//                    ->where('id', '=', $id)
//                    ->leftJoin('poc_results as pr', function ($join){
//                        $join->on('pr.patient_id', '=', 'poc_tables.id');
//                    })
//                    ->select('poc_tables.*','pr.results', 'pr.test_date', 'pr.equipment_used', 'tested_by');
		// ->paginate(Config::get('kblis.page-items'))->appends($request->except('_token'));
		if (count($patient->get()) == 0) {
            $request->session()->flash('message', trans('messages.no-match'));
		}

		// Load the view and pass the patients
		$antenatal = array('1'=>'Lifelong ART', '2' => 'No ART', '3' => 'UNKNOWN');
		return view('poc.show')
		->with('antenatal',$antenatal)
		->with('patient', $patient)->withInput($request->all());
	}





	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */


	public function edit($id)
	{
		//Get the patient
		$patient = POC::find($id);

		$hiv_status = array('0' => 'Positive', '1' => 'Negative', '2' => 'Unknown');
		$antenatal= array('0'=>'Select---','Lifelong ART'=>'Lifelong ART', 'No ART' => 'No ART', 'UNKNOWN' => 'UNKNOWN');
		$referral_reasons= array('0'=>'Select---','Stock Out'=>'Stock Out', 'Equipment breakdown' => 'Equipment breakdown', 'Service not avalable at facility' => 'Service not avalable at facility');
		$facilities = ['Select facility']+Facility::where('active', '=', 0)->pluck('name', 'id')->toArray();
		//Open the Edit View and pass to it the $patient
		return view('poc.edit')
		->with('hiv_status', $hiv_status)
		->with('facilities',$facilities)
		->with('referral_reasons',$referral_reasons)
		->with('antenatal', $antenatal)
		->with('patient', $patient);
		// $district = District::orderBy('name','ASC')
		// ->lists('name', 'id');

	}

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
	public function update(Request $request, $id)
	{
		//
		$rules = array(
			'infant_name' => 'required',
			'age'       => 'required',
			'gender' => 'required',
			'mother_name' => 'required'
		);
		$validator = Validator::make($request->all(), $rules);

		// process the login
		if ($validator->fails()) {
			return redirect('poc/' . $id . '/edit')
				->withErrors($validator)
				->withInput($request->except('password'));
		}

		 else {
			// Update
			$patient = POC::find($id);

			$patient->infant_name	= $request->get('infant_name');
			$patient->exp_no = $request->get('exp_no');
			$patient->age	= $request->get('age');
			$patient->gender	= $request->get('gender');
			$patient->caretaker_number	= $request->get('caretaker_number');
			$patient->given_contrimazole	= $request->get('given_contrimazole');
			$patient->delivered_at	= $request->get('delivered_at');
			$patient->infant_pmtctarv	= $request->get('infant_pmtctarv');
			$patient->entry_point	= $request->get('entry_point');
			$patient->other_entry_point	= $request->get('other_entry_point');
			$patient->collection_date	= $request->get('collection_date');
			$patient->sample_id	= $request->get('sample_id');
			$patient->pcr_level	= $request->get('pcr_level');
			$patient->feeding_status	= $request->get('feeding_status');
			$patient->breastfeeding_status	= $request->get('feeding_status');
			$patient->mother_hts	= $request->get('mother_hts');
			$patient->mother_art = $request->get('mother_art');
			$patient->nin = $request->get('nin');
			$patient->pmtct_antenatal	= $request->get('pmtct_antenatal');
			$patient->pmtct_delivery	= $request->get('pmtct_delivery');
			$patient->pmtct_postnatal	= $request->get('pmtct_postnatal');
			$patient->admission_date	= $request->get('admission_date');
			$patient->mother_name	= $request->get('mother_name');
			$patient->provisional_diagnosis	= $request->get('provisional_diagnosis');
			$patient->infant_pmtctarv	= $request->get('infant_pmtctarv');
			$patient->mother_pmtctarv	= $request->get('pmtct_delivery'); //Mother_pmtctarv
			$patient->mother_hiv_status	= $request->get('mother_hiv_status');
			$patient->created_by = Auth::user()->name;
			$patient->save();

			// redirect
			return redirect()->route('poc.index')
			->with('message', 'The patient details were successfully updated!') ->with('activepatient',$patient ->id);

		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

    /**
     * Remove the specified resource from storage (soft delete).
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
	public function delete(Request $request, $id)
	{
		//Soft delete the patient
		$patient = UnhlsPatient::find($id);

		$patient->delete();

		// redirect
			$url = $request->session()->get('SOURCE_URL');
			return redirect($url)
			->with('message', 'The commodity was successfully deleted!');
	}

    /**
     * Return a Patients collection that meets the searched criteria as JSON.
     *
     * @param Request $request
     * @return Response
     */
	public function search(Request $request)
	{
        return UnhlsPatient::search($request->get('text'))->take(config('kblis.limit-items'))->get()->toJson();
	}

	public function enter_results($patient_id){
		$patient = POC::find($patient_id);
		return view('poc.enter_results')
		->with('patient', $patient);
	}

	public function save_results(Request $request, $patient_id)
	{
		$rules = array(
			'results' => 'required',
			'test_date' => 'required',
			'dispatched_by' => 'required',
			'equipment_used' => 'required'
		);
		$validator = Validator::make($request->all(), $rules);

		if ($validator->fails()) {
			return redirect()->back()->withErrors($validator)->withInput($request->all());
		} else {
			// store
			$result = new POCResult;
			$result->patient_id = $patient_id;
			$result->results = $request->get('results');
			$result->test_date = $request->get('test_date');
			$result->error_code = $request->get('error_code');
			$result->tested_by = $request->get('tested_by');
			$result->dispatched_by = $request->get('dispatched_by');
            $result->equipment_used = $request->get('equipment_used');
			$result->dispatched_date = $request->get('dispatched_date');
			try{
				$result->save();
				return redirect()->route('poc.index')
				->with('message', 'Successfully saved results information!');

			}catch(QueryException $e){
				Log::error($e);
				echo $e->getMessage();
			}
		}
	}

	public function edit_results($patient_id){
		$patient = POC::find($patient_id);
		$result = POCResult::where('patient_id', $patient_id)->limit(1)->first();
		return view('poc.edit_results')
		->with('patient', $patient)->with('result', $result);
	}

	public function update_results(Request $request, $patient_id)
	{
		$rules = array(
			'results' => 'required',
			'test_date' => 'required',
		);
		$validator = Validator::make($request->all(), $rules);

		if ($validator->fails()) {
			return redirect()->back()->withErrors($validator)->withInput($request->all());
		} else {
			// store
			$result = POCResult::find($request->get('result_id'));
			$result->results = $request->get('results');
			$result->test_date = $request->get('test_date');
			$result->error_code = $request->get('error_code');
			try{
				$result->save();
				return redirect()->route('poc.index')
				->with('message', 'Successfully updated esults information:!');

			}catch(QueryException $e){
				Log::error($e);
				echo $e->getMessage();
			}
		}
	}

	public function download(Request $request){
		$test_date_fro = $request->get('test_date_fro');
		$test_date_to = $request->get('test_date_to');
		if(!empty($test_date_fro) and !empty($test_date_to)){
			$this->csv_download($test_date_fro, $test_date_to);
		}else{
			return view('poc.download');
		}
	}

	private function csv_download($fro, $to){
		$patients = POC::leftjoin('poc_results as pr', 'pr.patient_id', '=', 'poc_tables.id')
						->select('poc_tables.*','pr.results', 'pr.test_date')
						->from('poc_tables')
						->where('test_date','>=',$fro)
						->where('test_date','<=',$to)
						->get();
		header('Content-Type: text/csv; charset=utf-8');
		header("Content-Disposition: attachment; filename=eid_poc_date_$fro"."_$to.csv");
		$output = fopen('php://output', 'w');
		$headers = array(
				'Infant Name',
				'Gender',
				'Age',

				'EXP No',
				'Caretaker Number',
				'Admission Date',
				'Breastfeeding?',
				'Entry Point',
				'Mother Name',

				'Provisional Diagnosis',
				'Infant PMTCT ARV',
				'Mother HIV Status',
				'Collection Date',
				'PRC Level',
				'PMTCT Antenatal',
				'PMTCT Delivery',
				'PMTCT Post Natal',
				'Sample ID',
				'Results',
				'Test Date'
				);

		fputcsv($output, $headers);
		foreach ($patients as $patient) {
			$row=array(
				$patient->infant_name,
				$patient->gender,
				$patient->age,
				$patient->exp_no,
				$patient->caretaker_number,
				$patient->admission_date,
				$patient->breastfeeding_status,
				$patient->entry_point,
				$patient->mother_name,
				$patient->provisional_diagnosis,
				$patient->infant_pmtctarv,
				$patient->mother_hiv_status,
				$patient->collection_date,
				$patient->pcr_level,
				$patient->pmtct_antenatal,
				$patient->pmtct_delivery,
				$patient->pmtct_postnatal,
				$patient->sample_id,
				$patient->results,
				$patient->test_date
				);
			fputcsv($output, $row);
		}
		fclose($output);

	}

	public function hpv_upload(){

		$sql = "select hp.id as result_id, patient_number, p.name as patient_name, dob, gender, tt.name as test_type, hp.updated_at as test_date, genotype_16, genotype_18,genotype_hr from hpv_patient hp
		left join unhls_test_results r on hp.test_id=r.test_id
		left join unhls_tests t on hp.test_id=t.id
		left join test_types tt on t.test_type_id=tt.id
		left join unhls_visits v on t.visit_id=v.id
		left join unhls_patients p on v.patient_id=p.id where tt.name = 'HPV' && hp.uploaded=0
		GROUP BY hp.id, result_id,patient_number,patient_name,dob,gender,test_type,test_date";
		$records = DB::select($sql);
		// $records = json_encode($data);

	return view('unhls_test.hpv_upload')->with('records', $records);
	}

	public function upload(){
		$sql = "select hp.facility_id, hp.id as result_id, dob, hiv_status, p.gender, art_number, clinic_id, screened_status, nok_name,nok_relationship, u.name as created_by, previous_diagnostic_method, other_method, previous_screening_result, specimen_type, previous_screening_date, sample_collection_date, date_received_by_hw, date_received_by_lab, hp.updated_at as test_date, genotype_16, genotype_18,genotype_hr from hpv_patient hp
		join unhls_patients p on hp.patient_id=p.id
		join users u on hp.created_by = u.id
		 where hp.genotype_16 != '' && hp.uploaded=0 LIMIT 50";

// dd(\DB::select($sql));
	 if(!$sock = @fsockopen('www.google.com', 80))
	{
		return response()->json('No internet connection');
	}
	else
	{

		$data = DB::select($sql);
		
			$url = 'https://www.cphluganda.org/alis_api/';
			// $url = 'http://45.56.79.87:8080/alis_api/';
			$client = new \GuzzleHttp\Client(['base_uri'=>$url, 'verify' => false]);
			
			$res = $client->post('/alis_api',[
				'json' => [
					$data
				]
			
			]);
			// $records = DB::select($sql);
		foreach ($data as $key => $r) {
			$update_sql = "update hpv_patient set uploaded=1 where id=$r->result_id";
			DB::update($update_sql);
		}
		
	}
		return view('user.thanks');
	
}
    
    public function poc_data_upload_view(Request $request){

		$sql = "select facility_id, infant_name, exp_no, gender, age, caretaker_number, admission_date, breastfeeding_status, entry_point, mother_name, provisional_diagnosis, infant_pmtctarv, mother_hiv_status, collection_date, pcr_level, pmtct_antenatal, pmtct_delivery, pmtct_postnatal, sample_id, results, test_date from poc_tables pt
		left join poc_results pr on pr.patient_id=pt.id
		where pr.uploaded=0";
		$records = DB::select($sql);
		

	return view('poc.poc_upload_view')->with('records', $records);
	}

	public function poc_upload(){

		$sql = "select facility_id, referral_reason, testing_facility, pr.id as infant_id, infant_name, exp_no, gender, age, caretaker_number, admission_date, breastfeeding_status, entry_point, mother_name, provisional_diagnosis, infant_pmtctarv, mother_hiv_status, collection_date, pcr_level, pmtct_antenatal, pmtct_delivery, pmtct_postnatal, sample_id, results, test_date, created_by from poc_tables pt
		inner join poc_results pr on pr.patient_id=pt.id
		where pr.uploaded=0 LIMIT 30";

// dd(\DB::select($sql));
	 if(!$sock = @fsockopen('www.google.com', 80))
	{
		return response()->json('No internet connection');
	}
	else
	{

		$data = DB::select($sql);
		// $recordss = json_encode($data);
		// $records = json_decode($recordss, true);
		// // dd($records);
		// try{
			// $client = new GuzzleHttp\Client();
			// $url = 'http://45.56.79.87:8080/poc_data_pull/';
			$url = 'https://www.cphluganda.org/poc_data_pull/';
			$client = new \GuzzleHttp\Client(['base_uri'=>$url, 'verify' => false]);
			
			$res = $client->post('/poc_data_pull',[
				'json' => [
					$data
				]
			
			]);
			// $records = DB::select($sql);
		foreach ($data as $key => $r) {
			$update_sql = "update poc_results set uploaded=1 where id=$r->infant_id";
			DB::update($update_sql);
		}
		
	}
		return view('user.poc_success');
	
}

	/**
	 *Return a unique Lab Number
	 *
	 * @return string of current age concatenated with incremental Number.
	 */
	// Private function generateUniqueLabID(){

	// 	//Get Year, Month and day of today. If Jan O1 then reset last insert ID to 1 to start a new cycle of IDs
	// 	$year = date('Y');
	// 	$month = date('m');
	// 	$day = date('d');

	// 	if($month == '01' && $day == '01'){
	// 		$lastInsertId = 1;
	// 	}
	// 	else{
	// 		$lastInsertId = DB::table('unhls_patients')->max('id')+1;
	// 	}
	// 	$fcode = config('constants.FACILITY_CODE');
	// 	$num = $year.str_pad($lastInsertId, 6, '0', STR_PAD_LEFT);
	// 	return $fcode.'-'.$num;
	// }


}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\LabRow;
use App\Models\Course;
use App\Models\UuidGenerator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $student = Student::orderBy('id', 'desc')->get();
        $row = ['Select Lab Row']+LabRow::orderBy('name','ASC')->pluck('name', 'id')->toArray();
        $course = ['Select Course']+Course::orderBy('name','ASC')->pluck('name', 'id')->toArray();
        //Load the view and pass the house
        return view('student.index')
        ->with('student',$student)
        ->with('course', $course)
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
            $student = new Student;
            $student->name = $request->get('name');
            $student->student_number = $request->get('student_number');
            $student->gender = $request->get('gender');
            $student->row_line = $request->get('row_line');
            $student->course_id = $request->get('course_id');
            $student->time_in = now();
            $student->time_out = now()->addHours($request->get('duration'));
            $student->created_by = Auth::user()->id;
            $student->status = 1;
            try{
                $student->save();
                if ($request->get('auto_number')!= '') {
                    $student->auto_number = $request->get('auto_number');
                }else{
                    $student->auto_number = $student->getStudentNo();
                }
                $student->save();
                $uuid = new UuidGenerator;
                $uuid->counter = 0;     // TODO Get default value as 0 from migration
                $uuid->save();
            // todo: put option to redirect to page to add antibiotic with zone diameters, save and add antibiotic
            return redirect('student')
                ->with('message', trans('messages.success-creating-record'))->with('activestudent', $student->id);
            }catch(QueryException $e){
                Log::error($e);
                echo $e->getMessage();
            }
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
        $student = Student::find($id);
        $row = ['Select Lab Row']+LabRow::orderBy('name','ASC')->pluck('name', 'id')->toArray();

        return view('student.edit')
        ->with('student', $student)
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
        $rules = array();
        $validator = Validator::make($request->all(), $rules);

        // process the login
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        } else {
            // Update
            $student = Student::find($id);
            $student->time_out = now()->addHours($request->get('duration'));
            $student->row_line = $request->get('row_line');
            $student->updated_by = Auth::user()->id;
            $student->save();
            return redirect('student')
                ->with('message', trans('messages.success-updating-record')) ->with('activestudent', $student->id);
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

    public function labreport(Request $request)
    {
        $from = $request->get('start');
        $to = $request->get('end');
        $today = date('Y-m-d H:i:s');
        $year = date('Y');

        //  Apply filters if any
        if($request->has('filter')){
            if(!$to) $to=$today;

            if(strtotime($from)>strtotime($to)||strtotime($from)>strtotime($today)||strtotime($to)>strtotime($today)){
                Session::flash('message', trans('messages.check-date-range'));
            }

            $data = Student::report($from, $to);
        }
        else
        {
            // Get all tests for the current year
            $records = Student::where('created_at', 'LIKE', date('Y').'%');
            $periodStart = $records->min('created_at'); //Get the minimum date
            $periodEnd = $records->max('created_at'); //Get the maximum date
            $data = Student::report($periodStart, $periodEnd);
        }
        if($request->has('excel')){
            $date = date("Ymdhi");
            $fileName = "testtype_tat_".$date.".xls";
            $headers = array(
                "Content-type"=>"text/csv",
                "Content-Disposition"=>"attachment;Filename=".$fileName
            );
            $content = view('student.exportTAT')
                ->with('data', $data)
                ->withInput($request->all());
            return Response::make($content,200, $headers);
        }
        else{
            //dd($chart);
            return view('student.report')
                ->with('data', $data)
                ->withInput($request->all());
        }
    }

}

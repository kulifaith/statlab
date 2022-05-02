<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Payment extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'payment';

    public function tenant()
    {
        return $this->belongsTo('App\Models\Tenant', 'tenant_id');
    }

    public function getFacilityCode()
    {
        $facilityCode = config('constants.FACILITY_CODE');
        return $facilityCode;

    }

    /**
     * Get patients Unique Identification Number (ULIN)
     *
     * @return string
     */
    public function getautonumber(){

        $format = AdhocConfig::where('name','ULIN')->first()->getULINFormat();
        $facilityCode ='';
        $facilityCode = $this->getFacilityCode();
        $registrationDate = strtotime($this->created_at);
        if ($format == 'Jinja_SOP') {
            $lastPatientRegistration = Payment::orderBy('id','DESC')->first()->created_at;
            $monthOfLastEntry = date('m',strtotime($lastPatientRegistration));
            $monthNow = date('m');

            if ($monthOfLastEntry != $monthNow) {
                Artisan::call('reset:ulin');
            }

            $year = date('y', $registrationDate);
            $month = date('m', $registrationDate);
            $autoNum = DB::table('uuids')->max('id')+1;
            return $autoNum.'/'.$month.'/'.$year;

        }elseif ($format == 'Mityana_SOP') {
            $lastPatientRegistration = Payment::orderBy('id','DESC')->first()->created_at;
            $monthOfLastEntry = date('m',strtotime($lastPatientRegistration));
            $monthNow = date('m');

            if ($monthOfLastEntry != $monthNow) {
                Artisan::call('reset:ulin');
            }

            $year = date('y', $registrationDate);
            $month = date('m', $registrationDate);
            $autoNum = DB::table('uuids')->max('id')+1;


            $name = preg_split("/\s+/", trim($this->name));
            $initials = null;

            foreach ($name as $n){
                $initials .= $n[0];

            }
            return $initials.'/'.$month.'/'.$autoNum.'/'.$year;
            // MG/12/220/17
        }elseif($format == 'Rukunyu_SOP'){
            $yearMonth = date('m/y', $registrationDate);
            $autoNum = DB::table('uuids')->max('id')+1;
            return $autoNum.'/'.$yearMonth;
        }
        else{
            $yearMonth = date('ym', $registrationDate);
            $auto = DB::table('uuids')->max('id')+1;
            $autoNum = str_pad($auto, 5, '0', STR_PAD_LEFT); 
            $name = preg_split("/\s+/", trim($this->name));
            $initials = null;

            foreach ($name as $n){
                $initials .= $n[0];

            }
            return $autoNum.'-'.$initials;
        }
    }
}

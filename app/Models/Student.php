<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Student extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'students';

    public function records()
    {
        return $this->belongsTo('App\Models\LabRow', 'row_line');
    }

    public function getStudentNo(){

        $registrationDate = strtotime($this->created_at);
    
            $yearMonth = date('ym', $registrationDate);
            $auto = DB::table('uuids')->max('id')+1;
            $autoNum = str_pad($auto, 4, '0', STR_PAD_LEFT); 
            $name = preg_split("/\s+/", trim($this->name));
            $initials = null;

            foreach ($name as $n){
                $initials .= $n[0];

            }
            return $yearMonth.'-'.$auto.'-'.$initials;
    }

    public static function report($from, $to){

                $sql = "SELECT c.id, c.name, sum(case when gender=0 then 1 else 0 end) as male, sum(case when gender=1 then 1 else 0 end) as female from students s
                        join course c on(s.course_id=c.id)
                        where s.created_at between '".$from."' and '".$to."' group by c.id, c.name";
                        $data = DB::select($sql);
                        return $data;
    }
}

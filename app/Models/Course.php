<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Course extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'course';

    public function coursestudied()
    {
        return $this->belongsTo('App\Models\Student', 'course_id');
    }
}

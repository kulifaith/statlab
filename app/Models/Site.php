<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Site extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'site';
}

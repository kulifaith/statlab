<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class House extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'house';

    public function houseType()
    {
        return $this->belongsTo('App\Models\HouseType', 'category_id');
    }
    public function site()
    {
        return $this->belongsTo('App\Models\Site', 'site_id');
    }
    public static function listhouses()
    {
        $sql = "SELECT h.house_no, s.name from house h LEFT JOIN site s ON(h.site_id = s.id) GROUP BY h.id";
        $house = DB::select($sql);

        return $house;
        
    }
}

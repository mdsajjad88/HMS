<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeoUpazillas extends Model
{
    use HasFactory;
    protected $table = 'geo_upazilas';
    protected $fillable = [
        'id',
        'geo_division_id ',
        'geo_district_id ',
        'division_bbs_code',
        'district_bbs_code',
        'upazila_name_eng',
        'upazila_name_bng',
        'bbs_code',
        'status',
        'created_by',
        'modified_by ',
    ];
    public function  district(){

        return $this->belongsTo(GeoDistricts::class, 'geo_district_id');

    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeoDistricts extends Model
{
    use HasFactory;
    protected $table = 'geo_districts';
    protected $fillable = [
        'id',
        'geo_division_id',
        'district_name_eng',
        'district_name_bng',
        'status',
        'created_by',
        'modified_by',
    ];
    public function  division(){

        return $this->belongsTo(GeoDivisions::class, 'geo_division_id');

    }
}

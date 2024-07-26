<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeoUnions extends Model
{
    use HasFactory;
    protected $table = 'geo_unions';
    protected $fillable=[
        'id',
        'geo_upazila_id ',
        'upazila_bbs_code ',
        'union_name_eng ',
        'union_name_bng ',
        'bbs_code ',
        'status ',
        'created_by  ',
        'modified_by  ',
    ];
}

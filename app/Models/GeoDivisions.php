<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeoDivisions extends Model
{
    use HasFactory;
    protected $table = 'geo_divisions';
    protected $fillable = [
        'division_name_eng',
        'division_name_bng',
        'bbs_code',
        'status',
        'created_by ',
        'modified_by ',
    ];
}

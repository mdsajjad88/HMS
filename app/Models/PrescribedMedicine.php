<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrescribedMedicine extends Model
{
    protected $table ='prescribed_medicines';
    protected $fillable= [
        
    ];
    use HasFactory;
}

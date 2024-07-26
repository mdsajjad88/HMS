<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicalTest extends Model
{
    use SoftDeletes, HasFactory;
    protected $table = 'medical_tests';

    protected $fillable = [
        'organization_profile_id', 'name', 'types', 'description', 'price',
        'sample_collection_room_number', 'lab_location_id', 'status',
        'discount_type', 'discount', 'created_by', 'modified_by'
    ];

    protected $dates = ['deleted_at'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorProfile extends Model
{
    protected $table = 'doctor_profiles';
    protected $fillable=[
        'first_name', 'last_name', 'email', 'mobile',
        'gender', 'bmdc_number', 'blood_group', 'token_name',
        'address', 'date_of_birth', 'nid', 'description',
        'designation', 'medical_academic_summary', 'specialist', 'is_active',
        'is_natural_certified', 'is_allopathic_certified', 'created_by', 'created',
        'modified_by', 'modified', 'photo', 'fee', 'consultant_type',
    ];
    use HasFactory;
}

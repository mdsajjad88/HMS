<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientProfile extends Model
{
    use HasFactory;
    protected $table = 'patient_profiles';
    protected $fillable=[
        'patient_user_id', 'first_name', 'last_name', 'email', 'mobile',
        'gender', 'date_of_birth', 'nid','age','profession', 'referral', 'disease_id', 'created_by',
        'created', 'modified_by', 'is_regular', 'is_subscriptions_3_months',
        'is_subscriptions_6_months', 'modified', 'photo', 'photo_dir',
        'blood_group', 'address', 'marital_status', 'height_cm', 'weight_kg',
        'body_fat_percentage', 'home_phone', 'work_phone', 'city', 'state',
        'post_code', 'country', 'emergency_contact_person', 'emergency_phone', 'emergency_relation',
        'has_text_consent', 'text_reminder', 'email_reminder', 'insurance_payer_name', 'insurance_payer_id',
        'insurance_plan', 'insurance_group', 'discount', 'referral', 'is_active',
        'is_deceased', 'remarks', 'address2', 'nick_name', 'address_alt',
        'address2_alt', 'city_alt', 'state_alt', 'post_code_alt', 'patient_type_id',
        'internal_comments', 'profession', 'marketing_source_by', 'marketing_source', 'agent_code_number','geo_district_id', 'geo_upazila_id',
    ];
    public function district(){

        return $this->belongsTo(GeoDistricts::class, 'geo_district_id');

    }
    public function upozilla(){

        return $this->belongsTo(GeoUpazillas::class, 'geo_upazila_id');

    }
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function patientUser()
    {
        return $this->belongsTo(PatientUser::class, 'patient_user_id');
    }

}

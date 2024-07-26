<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MedicalTest;
class PatientMedicalTest extends Model
{
    use HasFactory;
    protected $table='patient_medical_tests';
    protected $fillable = [
        'patient_user_id ','doctor_profile_id ','medical_test','status','types','collection_charge',
        'others_discount','amount','discount','final_total','paid_amount','payment_status',
        'remarks','created_by ','modified_by '
    ];
    public function doctor()
    {
        return $this->belongsTo(DoctorProfile::class, 'doctor_profile_id');
   }
   public function patient()
   {
       return $this->belongsTo(PatientUser::class, 'patient_user_id');
   }
   public function medicalTests()
   {
       return $this->belongsToMany(MedicalTest::class, 'patient_medical_test_medical_test', 'patient_medical_test_id', 'medical_test_id');
   }
}

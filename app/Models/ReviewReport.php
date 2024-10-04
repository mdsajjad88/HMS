<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewReport extends Model
{
    use HasFactory;
    protected $table = 'review_reports';
    protected $fillable = [
        'patient_user_id', 'doctor_user_id', 'patient_medical_test_id ', 'prescribed_medicine_id ', 'prescription_therapie_id ',
        'created_by ', 'physical_improvement','comment', 'problem_id', 'is_session_visite', 'session_visite_count','created_by', 'modified_by'
    ];
    protected $dates = ['deleted_at'];
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_user_id');
    }
    public function patient()
    {
        return $this->belongsTo(PatientUser::class, 'patient_user_id');
    }
    public function problems()
    {
        return $this->belongsToMany(Problem::class, 'report_and_problems', 'review_report_id', 'problem_id')
                    ->withTimestamps();
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function editor(){
        return $this->belongsTo(User::class, 'modified_by');
    }

}

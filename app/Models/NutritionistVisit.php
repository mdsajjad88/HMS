<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NutritionistVisit extends Model
{
    use HasFactory;
    protected $table = 'nutritionist_visits';
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
       'id', 'patient_user_id', 'review_report_id', 'nutritionist_user_id', 'type_of_consultant', 'diet_plan_status', 'challanced_faced', 'diet_plan_satisfaction', 'suggetion_for_improvement', 'visit_duration', 'created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_at', 'treatment_satisfaction'
    ];
    use SoftDeletes;
    public function patient()
    {
        return $this->belongsTo(PatientUser::class, 'patient_user_id');
    }
    public function report()
    {
        return $this->belongsTo(ReviewReport::class, 'review_report_id');
    }
    public function nutritionist()
    {
        return $this->belongsTo(User::class, 'nutritionist_user_id');
    }
    public function editor()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function problems()
    {
        return $this->belongsToMany(Problem::class, 'report_and_problems', 'nutritionist_visit_id', 'problem_id')
                    ->withTimestamps();
    }
    public function challenges()
    {
        return $this->belongsToMany(Challenges::class, 'visit_and_challenges', 'nutritionist_visit_id', 'challenge_id')
                    ->withTimestamps();
    }

}

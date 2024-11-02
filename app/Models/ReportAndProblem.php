<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportAndProblem extends Model
{
    use HasFactory;
    protected $table = 'report_and_problems';
    protected $fillable = [
        'review_report_id','problem_id', 'created_at', 'updated_at', 'doctor_user_id', 'last_visited_date','patient_user_id', 'nutritionist_visit_id'
    ];
    public function problem(){
        return $this->belongsTo(Problem::class, 'problem_id')->withTimestamps();;
    }

    public function reviewReport()
    {
        return $this->belongsTo(ReviewReport::class, 'review_report_id');
    }

}

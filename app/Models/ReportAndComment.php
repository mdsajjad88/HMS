<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportAndComment extends Model
{
    use HasFactory;
    protected $table ='report_and_comments';
    protected $fillable= [
        'review_report_id', 'comment_id', 'patient_user_id', 'doctor_user_id',
    ];
}

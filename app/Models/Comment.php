<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table = 'comments';
    protected $fillable = [
        'patient_user_id',
        'doctor_user_id',
        'review_report_id',
        'name',
        'description'
    ];
    public function reports()
    {
        return $this->belongsToMany(ReviewReport::class, 'report_and_comments');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitAndChallenge extends Model
{
    use HasFactory;
    protected $table = 'visit_and_challenges';
    protected $fillable = [
        'id', 'nutritionist_visit_id', 'challenge_id', 'nutritionist_user_id', 'patient_user_id', 'created_at', 'updated_at'
        ];
        public function challenge(){
            return $this->belongsTo(Challenges::class, 'challenge_id')->withTimestamps();;
        }

}

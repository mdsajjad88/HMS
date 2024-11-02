<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientUser extends Model
{
    use HasFactory;
    protected $table = 'patient_users';
    protected $fillable = [
        'username', 'password', 'change_password', 'active', 'user_body',
        'created_by', 'modified_by','id'
    ];
    public function profile()
    {
        return $this->hasOne(PatientProfile::class, 'patient_user_id');
    }
    public function reports() {
        return $this->hasMany(ReportAndProblem::class);
    }
}

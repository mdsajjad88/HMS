<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientSubscription extends Model
{
    use HasFactory;
    protected $table = 'patient_subscriptions';
    protected $fillable = ['patient_user_id', 'subscript_date', 'expiry_date', 'created_by', 'modified_by'];
}

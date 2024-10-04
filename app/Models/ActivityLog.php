<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;
    protected $table = 'activity_log';
    protected $fillable = [
    'id', 'organization_profile_id', 'patient_profile_id', 'subject', 'description', 'note', 'created_by', 'modified_by', 'helped_by', 'created', 'modified', 'created_at', 'updated_at'
    ];
}

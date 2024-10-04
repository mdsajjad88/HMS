<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nutritionist extends Model
{
    use HasFactory;
    protected $table = 'nutritionists';
    protected $fillable = [
        'name',
        'email',
        'mobile',
        'gender',
        'blood_group',
        'date_of_birth',
        'nid',
        'specialist',
        'fee',
        'designation',
        'consultant_type',
        'address',
        'description',
        'user_id',
        'created_by',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}

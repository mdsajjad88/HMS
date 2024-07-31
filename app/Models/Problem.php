<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Problem extends Model
{
    use HasFactory;
    protected $table = 'problems';
    protected $fillable = [
        'name', 'description',
    ];
    public function reports()
    {
        return $this->belongsToMany(ReviewReport::class, 'report_and_problems')->withTimestamps();;
    }
}

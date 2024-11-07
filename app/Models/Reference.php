<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    use HasFactory;
    protected $table = 'references';
    protected $fillable = [
        'name'
    ];
    public function reviewReports()
    {
        return $this->hasMany(ReviewReport::class, 'reference_id'); // Foreign key in review_reports table
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationGrade extends Model
{
    use HasFactory;

    protected $fillable = ['registration_id', 'course_id', 'grade'];
    
    public function regristration()
    {
        return $this->belongsTo(Registration::class, 'registration_id', 'id');
    }
    
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
}

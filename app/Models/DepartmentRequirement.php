<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentRequirement extends Model
{
    use HasFactory;

    protected $fillable = ['department_id', 'course_id', 'minimum_grade'];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }
    
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
}

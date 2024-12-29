<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'quota'];

    public function departmentRequirements()
    {
        return $this->hasMany(DepartmentRequirement::class, 'department_id', 'id');
    }
    
    public function registrations()
    {
        return $this->hasMany(Registration::class, 'department_id', 'id');
    }
}

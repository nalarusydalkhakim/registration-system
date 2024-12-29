<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'phone', 'zip_code', 'address', 'date_of_brith', 'place_of_birth'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function registration()
    {
        return $this->hasOne(Registration::class, 'student_id', 'id');
    }
}

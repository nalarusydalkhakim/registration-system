<?php

namespace App\Repositories;

use App\Interfaces\RegistrationGradeRepositoryInterface;
use Illuminate\Support\Facades\DB;

class RegistrationGradeRepository implements RegistrationGradeRepositoryInterface
{
    protected $registrationGrade;

    public function __construct()
    {
        $this->registrationGrade = DB::table('registration_grades');
    }

    public function getAll()
    {
        return $this->registrationGrade->all();
    }

    public function bulkInsert(array $data)
    {
        $this->registrationGrade->insert($data);
    }

    public function delete($id)
    {
        $query = $this->registrationGrade->find($id);
        if (!$query) {
            return null;
        }
        $query->delete();
        return $query;
    }
}


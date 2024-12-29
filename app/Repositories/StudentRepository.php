<?php

namespace App\Repositories;

use App\Interfaces\StudentRepositoryInterface;
use App\Models\Student;

class StudentRepository implements StudentRepositoryInterface
{
    protected $student;

    public function __construct()
    {
        $this->student = Student::query();
    }

    public function getAll()
    {
        return $this->student->all();
    }

    public function getPaginate(array $request)
    {
        $query = $this->student
            ->with(['department', 'student', 'regristrationGrades'])
            ->when(isset($request['department_id']), function ($q) use ($request) {
                $q->where('department_id', $request['department_id']);
            });

        return $query->paginate($request['per_page'] ?? 10);
    }

    public function getById($id)
    {
        return $this->student->with(['department', 'course'])->find($id);
    }

    public function create(array $data)
    {
        return $this->student->create($data);
    }

    public function update($id, array $data)
    {
        $query = $this->student->find($id);
        if (!$query) {
            return null;
        }
        $query->update($data);
        return $query;
    }

    public function delete($id)
    {
        $query = $this->student->find($id);
        if (!$query) {
            return null;
        }
        $query->delete();
        return $query;
    }
}


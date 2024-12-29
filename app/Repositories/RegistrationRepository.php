<?php

namespace App\Repositories;

use App\Interfaces\RegistrationRepositoryInterface;
use App\Models\Registration;

class RegistrationRepository implements RegistrationRepositoryInterface
{
    protected $registration;

    public function __construct()
    {
        $this->registration = Registration::query();
    }

    public function getAll()
    {
        return $this->registration->all();
    }

    public function getPaginate(array $request)
    {
        $query = $this->registration
            ->with(['department', 'student', 'registrationGrades.course'])
            ->when(isset($request['department_id']), function ($q) use ($request) {
                $q->where('department_id', $request['department_id']);
            });

        return $query->paginate($request['per_page'] ?? 10);
    }

    public function getById($id)
    {
        return $this->registration->with(['department', 'student', 'registrationGrades.course'])->find($id);
    }

    public function create(array $data)
    {
        return $this->registration->create($data);
    }

    public function update($id, array $data)
    {
        $query = $this->registration->find($id);
        if (!$query) {
            return null;
        }
        $query->update($data);
        return $query;
    }

    public function delete($id)
    {
        $query = $this->registration->find($id);
        if (!$query) {
            return null;
        }
        $query->delete();
        return $query;
    }
}


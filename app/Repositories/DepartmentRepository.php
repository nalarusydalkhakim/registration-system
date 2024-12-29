<?php

namespace App\Repositories;

use App\Interfaces\DepartmentRepositoryInterface;
use App\Models\Department;

class DepartmentRepository implements DepartmentRepositoryInterface
{
    protected $department;

    public function __construct()
    {
        $this->department = Department::query();
    }

    public function getAll()
    {
        return $this->department->all();
    }
    
    public function getPaginate(array $request)
    {
        return $this->department->with(['departmentRequirements.course'])->paginate($request['per_page'] ?? 10);
    }

    public function getById($id)
    {
        return $this->department->with(['departmentRequirements.course'])->find($id);
    }

    public function create(array $data)
    {
        return $this->department->create($data);
    }

    public function update($id, array $data)
    {
        $query = $this->department->find($id);
        if(!$query){
            return null;
        }
        $query->update($data);
        return $query;
    }

    public function delete($id)
    {
        $query = $this->department->find($id);
        if(!$query){
            return null;
        }
        $query->delete();
        return $query;
    }

    public function isRegistrationQuotaFull($id): bool
    {
        $department = $this->department->find($id);
        return $department->registrations()->count() >= $department->quota;
    }
}
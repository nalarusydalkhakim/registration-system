<?php

namespace App\Repositories;

use App\Interfaces\DepartmentRequirementRepositoryInterface;
use App\Models\DepartmentRequirement;

class DepartmentRequirementRepository implements DepartmentRequirementRepositoryInterface
{
    protected $departmentRequirement;

    public function __construct()
    {
        $this->departmentRequirement = DepartmentRequirement::query();
    }

    public function getAll()
    {
        return $this->departmentRequirement->all();
    }

    public function getPaginate(array $request)
    {
        $query = $this->departmentRequirement
            ->with(['department', 'course'])
            ->when(isset($request['department_id']), function ($q) use ($request) {
                $q->where('department_id', $request['department_id']);
            })
            ->when(isset($request['course_id']), function ($q) use ($request) {
                $q->where('course_id', $request['course_id']);
            });

        return $query->paginate($request['per_page'] ?? 10);
    }

    public function getById($id)
    {
        return $this->departmentRequirement->with(['department', 'course'])->find($id);
    }
    
    public function getByDepartmentId($id)
    {
        return $this->departmentRequirement->with(['department', 'course'])->where('department_id', $id)->get();
    }

    public function create(array $data)
    {
        return $this->departmentRequirement->create($data);
    }

    public function update($id, array $data)
    {
        $query = $this->departmentRequirement->find($id);
        if (!$query) {
            return null;
        }
        $query->update($data);
        return $query;
    }

    public function delete($id)
    {
        $query = $this->departmentRequirement->find($id);
        if (!$query) {
            return null;
        }
        $query->delete();
        return $query;
    }
}

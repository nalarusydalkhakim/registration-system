<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    protected $user;

    public function __construct()
    {
        $this->user = User::query();
    }

    public function getAll()
    {
        return $this->user->all();
    }

    public function getPaginate(array $request)
    {
        $query = $this->user
            ->with(['department', 'user', 'regristrationGrades'])
            ->when(isset($request['department_id']), function ($q) use ($request) {
                $q->where('department_id', $request['department_id']);
            });

        return $query->paginate($request['per_page'] ?? 10);
    }

    public function getById($id)
    {
        return $this->user->with(['department', 'course'])->find($id);
    }

    public function create(array $data)
    {
        return $this->user->create($data);
    }

    public function update($id, array $data)
    {
        $query = $this->user->find($id);
        if (!$query) {
            return null;
        }
        $query->update($data);
        return $query;
    }

    public function delete($id)
    {
        $query = $this->user->find($id);
        if (!$query) {
            return null;
        }
        $query->delete();
        return $query;
    }
}


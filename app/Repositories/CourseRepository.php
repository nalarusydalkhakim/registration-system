<?php

namespace App\Repositories;

use App\Interfaces\CourseRepositoryInterface;
use App\Models\Course;

class CourseRepository implements CourseRepositoryInterface
{
    protected $course;

    public function __construct()
    {
        $this->course = Course::query();
    }

    public function getAll()
    {
        return $this->course->all();
    }
    
    public function getPaginate(array $request)
    {
        return $this->course->paginate($request['per_page'] ?? 10);
    }

    public function getById($id)
    {
        return $this->course->find($id);
    }

    public function create(array $data)
    {
        return $this->course->create($data);
    }

    public function update($id, array $data)
    {
        $query = $this->course->find($id);
        if(!$query){
            return null;
        }
        $query->update($data);
        return $query;
    }

    public function delete($id)
    {
        $query = $this->course->find($id);
        if(!$query){
            return null;
        }
        $query->delete();
        return $query;
    }
}
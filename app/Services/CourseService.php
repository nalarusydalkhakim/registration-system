<?php

namespace App\Services;

use App\Interfaces\CourseRepositoryInterface;
use Illuminate\Http\Request;

class CourseService
{
    protected $courseRepository;

    public function __construct(CourseRepositoryInterface $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    public function getAll()
    {
        return $this->courseRepository->getAll();
    }

    public function getPaginate(Request $request)
    {
        return $this->courseRepository->getPaginate($request->all());
    }

    public function getById($id)
    {
        return $this->courseRepository->getById($id);
    }

    public function create(Request $request)
    {
        try {
            $input = $request->validated();
            return $this->courseRepository->create($input);
        } catch (\Exception $th) {
            throw $th;
        }
    }

    public function update($id, Request $request)
    {
        try {
            $input = $request->validated();
            return $this->courseRepository->update($id, $input);
        } catch (\Exception $th) {
            return $th;
        }
    }

    public function delete($id)
    {
        return $this->courseRepository->delete($id);
    }
}

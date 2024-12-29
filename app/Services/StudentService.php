<?php

namespace App\Services;

use App\Interfaces\StudentRepositoryInterface;
use Illuminate\Http\Request;

class StudentService
{
    protected $studentRepository;

    public function __construct(StudentRepositoryInterface $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    public function getAll()
    {
        return $this->studentRepository->getAll();
    }

    public function getPaginate(Request $request)
    {
        return $this->studentRepository->getPaginate($request->all());
    }

    public function getById($id)
    {
        return $this->studentRepository->getById($id);
    }

    public function create(array $data)
    {
        return $this->studentRepository->create($data);
    }

    public function update($id, array $data)
    {

        return $this->studentRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->studentRepository->delete($id);
    }
}

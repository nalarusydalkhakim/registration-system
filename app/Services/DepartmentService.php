<?php

namespace App\Services;

use App\Exceptions\CustomException;
use App\Interfaces\DepartmentRepositoryInterface;
use Illuminate\Http\Request;

class DepartmentService
{
    protected $departmentRepository;

    public function __construct(DepartmentRepositoryInterface $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
    }

    public function getAll()
    {
        return $this->departmentRepository->getAll();
    }

    public function getPaginate(Request $request)
    {
        return $this->departmentRepository->getPaginate($request->all());
    }

    public function getById($id)
    {
        return $this->departmentRepository->getById($id);
    }

    public function create(Request $request)
    {
        try {
            $input = $request->validated();
            return $this->departmentRepository->create($input);
        } catch (\Exception $th) {
            throw $th;
        }
    }

    public function update($id, Request $request)
    {

        try {
            $input = $request->validated();
            return $this->departmentRepository->update($id, $input);
        } catch (\Exception $th) {
            throw $th;
        }
    }

    public function delete($id)
    {
        return $this->departmentRepository->delete($id);
    }

    public function checkRegistrationQuoat(string $id)
    {
        $data = $this->departmentRepository->isRegistrationQuotaFull($id);
        if($this->departmentRepository->isRegistrationQuotaFull($id)){
            throw new CustomException('Kuota Pendaftaran Penuh', 422);
        }
        
    }
}

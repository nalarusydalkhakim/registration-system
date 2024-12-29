<?php

namespace App\Interfaces;

interface DepartmentRepositoryInterface
{
    public function getAll();

    public function getPaginate(array $request);

    public function getById($id);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);
    
    public function isRegistrationQuotaFull($id);
}

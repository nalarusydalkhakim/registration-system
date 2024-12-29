<?php

namespace App\Interfaces;

interface RegistrationGradeRepositoryInterface
{
    public function getAll();

    public function bulkInsert(array $data);

    public function delete($id);
}
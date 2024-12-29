<?php

namespace App\Interfaces;

interface RegistrationRepositoryInterface
{
    public function getAll();

    public function getPaginate(array $request);

    public function getById($id);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);
}
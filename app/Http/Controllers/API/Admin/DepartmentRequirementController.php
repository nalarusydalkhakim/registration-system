<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\Admin\CreateDepartmentRequirementRequest;
use App\Http\Requests\Admin\UpdateDepartmentRequirementRequest;
use App\Services\DepartmentRequirementService;
use Illuminate\Http\Request;

class DepartmentRequirementController extends Controller
{
    protected $departmentRequirementService;

    public function __construct(DepartmentRequirementService $departmentRequirementService)
    {
        $this->departmentRequirementService = $departmentRequirementService;
        $this->middleware(['permission:View Department Requirement'])->only(['index', 'show']);
        $this->middleware(['permission:Add Department Requirement'])->only('store');
        $this->middleware(['permission:Update Department Requirement'])->only('update');
        $this->middleware(['permission:Delete Department Requirement'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->ok($this->departmentRequirementService->getPaginate($request), 'List Persyaratan Departemen');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateDepartmentRequirementRequest $request)
    {
        return $this->created($this->departmentRequirementService->create($request), 'Persyaratan Departemen Berhasil Disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = $this->departmentRequirementService->getById($id);
        if ($data)
            return $this->ok($data, 'Detail Persyaratan Departemen');
        return $this->error('Data tidak ditemukan', 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartmentRequirementRequest $request, string $id)
    {
        $data = $this->departmentRequirementService->update($id, $request);
        if ($data)
            return $this->created($data, 'Persyaratan Departemen Berhasil Diubah');
        return $this->error('Data tidak ditemukan', 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = $this->departmentRequirementService->delete($id);
        if ($data)
            return $this->ok($data, 'Persyaratan Departemen Berhasil Dihapus');
        return $this->error('Data tidak ditemukan', 404);
    }
}

<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\Admin\CreateDepartmentRequest;
use App\Http\Requests\Admin\UpdateDepartmentRequest;
use App\Services\DepartmentService;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{

    protected $departmentService;

    public function __construct(DepartmentService $departmentService)
    {
        $this->departmentService = $departmentService;
        $this->middleware(['permission:View Department'])->only(['index', 'show']);
        $this->middleware(['permission:Add Department'])->only('store');
        $this->middleware(['permission:Update Department'])->only('update');
        $this->middleware(['permission:Delete Department'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->ok($this->departmentService->getPaginate($request), 'List Departemen');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateDepartmentRequest $request)
    {
        return $this->created($this->departmentService->create($request), 'Departemen Berhasil Disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = $this->departmentService->getById($id);
        // if ($data)
        //     return $this->ok($data, 'Detail Departemen');
        // return $this->error('Data tidak ditemukan', 404);
        return $data;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartmentRequest $request, string $id)
    {
        $data = $this->departmentService->update($id, $request);
        if ($data)
            return $this->created($data, 'Departemen Berhasil Diubah');
        return $this->error('Data tidak ditemukan', 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = $this->departmentService->delete($id);
        if ($data)
            return $this->ok($data, 'Departemen Berhasil Dihapus');
        return $this->error('Data tidak ditemukan', 404);
    }
}

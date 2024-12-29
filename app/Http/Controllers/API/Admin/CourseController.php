<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\Admin\CreateCourseRequest;
use App\Http\Requests\Admin\UpdateCourseRequest;
use App\Services\CourseService;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    protected $courseService;

    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;
        $this->middleware(['permission:View Course'])->only(['index', 'show']);
        $this->middleware(['permission:Add Course'])->only('store');
        $this->middleware(['permission:Update Course'])->only('update');
        $this->middleware(['permission:Delete Course'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->ok($this->courseService->getPaginate($request), 'List Mata Pelajaran');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCourseRequest $request)
    {
        return $this->created($this->courseService->create($request), 'Mata Pelajaran Berhasil Disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = $this->courseService->getById($id);
        if ($data)
            return $this->ok($data, 'Detail Mata Pelajaran');
        return $this->error('Data tidak ditemukan', 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, string $id)
    {
        $data = $this->courseService->update($id, $request);
        if ($data)
            return $this->created($data, 'Mata Pelajaran Berhasil Diubah');
        return $this->error('Data tidak ditemukan', 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = $this->courseService->delete($id);
        if ($data)
            return $this->ok($data, 'Mata Pelajaran Berhasil Dihapus');
        return $this->error('Data tidak ditemukan', 404);
    }
}

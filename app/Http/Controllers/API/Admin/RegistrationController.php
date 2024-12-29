<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\Admin\CreateRegistrationRequest;
use App\Http\Requests\Admin\UpdateRegistrationRequest;
use App\Services\RegistrationService;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    protected $registrationService;

    public function __construct(RegistrationService $registrationService)
    {
        $this->registrationService = $registrationService;
        $this->middleware(['permission:View Registration'])->only(['index', 'show']);
        $this->middleware(['permission:Add Registration'])->only('store');
        $this->middleware(['permission:Update Registration'])->only('update');
        $this->middleware(['permission:Delete Registration'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->ok($this->registrationService->getPaginate($request), 'List Pendaftaran Peserta Didik');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRegistrationRequest $request)
    {
        return $this->created($this->registrationService->create($request), 'Pendaftaran Peserta Didik Berhasil Disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = $this->registrationService->getById($id);
        if ($data)
            return $this->ok($data, 'Detail Pendaftaran Peserta Didik');
        return $this->error('Data tidak ditemukan', 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRegistrationRequest $request, string $id)
    {
        $data = $this->registrationService->update($id, $request);
        if ($data)
            return $this->created($data, 'Pendaftaran Peserta Didik Berhasil Diubah');
        return $this->error('Data tidak ditemukan', 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = $this->registrationService->delete($id);
        if ($data)
            return $this->ok($data, 'Pendaftaran Peserta Didik Berhasil Dihapus');
        return $this->error('Data tidak ditemukan', 404);
    }
}

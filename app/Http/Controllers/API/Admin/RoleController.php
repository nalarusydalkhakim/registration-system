<?php
namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\CreateRoleRequest;
use App\Http\Requests\Admin\UpdateRoleRequest;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $data = Role::query()
            ->paginate($request->get('per_page', 10));
        return $this->ok($data);
    }

    public function getPermission(Request $request)
    {
        $data = Permission::query()
            ->paginate($request->get('per_page', 10));
        return $this->ok($data);
    }

    public function store(CreateRoleRequest $request)
    {
        $role = Role::create($request->validated());
        $role->syncPermissions($request->permissions);
        return $this->ok($role);
    }

    public function show(Role $role)
    {
        return $this->ok($role->load('permissions'));
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role->update($request->validated());
        $role->syncPermissions($request->permissions);
        return $this->ok([], 'Berhasil mengubah data');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return $this->ok([], 'Berhasil menghapus data');
    }
}
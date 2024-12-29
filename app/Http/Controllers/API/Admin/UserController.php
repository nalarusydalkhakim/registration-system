<?php
namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\CreateUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;
use App\Events\RequestEmailVerification;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $data = User::query()
            ->user('User')
            ->paginate($request->get('per_page', 10));
        return $this->ok($data);
    }

    public function store(CreateUserRequest $request)
    {
        $input = $request->validated();
        if ($request->has('avatar')) {
            $input['avatar'] = $request->file('avatar')->store('avatars');
        }
        $input['password'] = Hash::make($request->password);
        $user = User::create($input);
        $user->syncRoles($request->roles);
        event(new RequestEmailVerification($user));
        return $this->ok($user);
    }

    public function show(User $user)
    {
        return $this->ok($user->load('roles.permissions'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $input = $request->validated();
        if ($request->has('avatar')) {
            $input['avatar'] = $request->file('avatar')->store('avatars');
        }
        if ($request->has('password')) {
            $input['password'] = Hash::make($request->password);
        }
        $user->update($input);
        $user->syncRoles($request->roles);
        return $this->ok([], 'Berhasil mengubah data');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return $this->ok([], 'Berhasil menghapus data');
    }
}
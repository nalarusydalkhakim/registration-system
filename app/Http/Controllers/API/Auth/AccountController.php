<?php
namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\UpdateAccountRequest;
use App\Http\Requests\Auth\UpdatePasswordRequest;
use App\Http\Requests\Auth\VerificationTokenCheckRequest;
use App\Events\RequestEmailVerification;
use App\Events\EmailVerified;
use App\Events\PasswordChanged;

class AccountController extends Controller
{
    public function me(Request $request)
    {
        return $this->ok($request->user()->load('roles.permissions'), 'Berhasil mengambil data user');
    }

    public function updateAccount(UpdateAccountRequest $request)
    {
        $input = $request->validated();

        if ($request->has('avatar')) {
            $input['avatar'] = $request->file('avatar')->store('avatars');
        }

        $user = $request->user()->update($input);

        return $this->ok($user, 'Berhasil mengubah profil');
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $request->user()->update([
            'password' => Hash::make($request->new_password)
        ]);
        event(new PasswordChanged($request->user()));

        return $this->ok([], 'Berhasil mengubah password');
    }

    public function requestNewVerifyEmail(Request $request)
    {
        try {
            event(new RequestEmailVerification($request->user()));
            return $this->ok([], 'Kode aktivasi telah dikirim ke email Anda');
        } catch (\Throwable $th) {
            return $this->error('Gagal mengirim token', 500);
        }
    }

    public function verifyEmail(VerificationTokenCheckRequest $request)
    {
        try {
            if(($request->user()->activationToken->token ?? null) == $request->activation_token){
                event(new EmailVerified($request->user()));
                return $this->ok([], 'Berhasil memverifikasi email Anda');
            }
            return $this->error('Kode aktivasi tidak valid', 422);
        } catch (\Throwable $th) {
            return $this->error('Terjadi masalah pada server', 500);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return $this->ok([], 'Berhasil logout');
    }
}
<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\EmailCheckRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Models\User;
use Illuminate\Support\Facades\RateLimiter;
use App\Events\RequestPasswordReset;
use App\Events\PasswordReset;
use App\Events\RequestEmailVerification;
use App\Http\Requests\Auth\LoginRequest;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $input = $request->validated();
        $user = User::where('email', $input['email'])->first();

        if (!$user || !Hash::check($input['password'], $user->password)) {
            return response()->json([
                'success'   => false,
                'code'      => 422,
                'message'   => 'Email atau password salah',
            ], 422);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success'   => true,
            'code'      => 200,
            'message'   => 'Berhasil login',
            'data'      => [
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user->load('roles.permissions'),
            ],
        ], 200);
    }

    // public function requestPasswordReset(EmailCheckRequest $request)
    // {
    //     try {
    //         $executed = RateLimiter::attempt(
    //             'send-email-reset:' . $request->get('email'),
    //             2,
    //             function () use ($request) {
    //                 $user = User::where('email', $request->get('email'))->first();
    //                 event(new RequestPasswordReset($user));
    //             }
    //         );

    //         if (! $executed) {
    //             return $this->error('Percobaan terlalu banyak', 422, ['email' => ['Percobaan terlalu banyak, silahkan coba kembali 1 menit kemudian']]);
    //         }
    //         return $this->ok([], 'Berhasil mengirim kode, Silahkan cek email Anda.');
    //     } catch (\Throwable $th) {
    //         return $this->error('Gagal mengirim token', 500);
    //     }
    // }

    // public function passwordReset(ResetPasswordRequest $request)
    // {
    //     $user = User::where('email', $request->get('email'))->first();
    //     $user->password = Hash::make($request->password);
    //     $user->save();
    //     event(new PasswordReset($user));
    //     return $this->ok([], 'Password anda berhasil direset. Silahkan login kembali');
    // }
}

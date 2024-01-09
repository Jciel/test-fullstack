<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class AuthService
{
    public function loginUser(string $email, string $password)
    {
        $user = User::where('email',$email)->first();

        if (!$user) {
            throw new BadRequestException('User not found');
        }

        if (app('hash')->check($password, $user->password)) {
            return Auth::attempt(['email' => $email, 'password' => $password]);
        }

        throw new BadRequestException('Wrong password');
    }

    public function registerUser(string $name, string $email, string $password)
    {
        $password = app('hash')->make($password);

        $user = User::create([
            'name'  => $name,
            'email'     => $email,
            'password'  => $password
        ]);

        if ($user) {
            return $user;
        }

        throw new UnprocessableEntityHttpException('Error when trying to register user');
    }

    public function verifyToken(Request $req)
    {
        return Auth::userOrFail();
    }
}

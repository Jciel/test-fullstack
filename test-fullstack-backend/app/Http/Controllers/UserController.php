<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct(private AuthService $authService)
    {
    }

    public function login(Request $req): JsonResponse
    {
        try {
            $this->validate($req, [
                'email'     =>  'required|email',
                'password'  =>  'required',
            ]);

            Auth::check();

            $email = $req->input('email');
            $password = $req->input('password');

            $token = $this->authService->loginUser($email, $password);

            return response()->json(['token' => $token, 'message' => 'Login success'], Response::HTTP_OK);
        } catch (BadRequestException $e) {
            return $this->error($e->getMessage(), [], Response::HTTP_BAD_REQUEST);
        } catch (UnprocessableEntityHttpException $e) {
            return $this->error($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function register(Request $req): JsonResponse
    {
        $messages = [
            'email.unique' => 'This email is already registered',
        ];

        $validator = Validator::make($req->all(), [
            'name'  =>  'required',
            'email'     =>  'required|email|unique:users',
            'password'     =>  'required'
        ], $messages);

        if ($validator->fails()) {
            $message = $validator->errors()->first('email') . ", " . $validator->errors()->first('username');
            return response()->json([
                'message'   => $message
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $name = $req->input('name');
            $email = $req->input('email');
            $password = $req->input('password');

            $user = $this->authService->registerUser($name, $email, $password);

            return response()->json(['user' => $user, 'message' => 'User created successfully'], Response::HTTP_OK);
        } catch (UnprocessableEntityHttpException $e) {
            return $this->error($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function verify(Request $req)
    {
        try {
            $user = $this->authService->verifyToken($req);
            return response()->json(['user' => $user, 'message' => 'Token is valid'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}

<?php

namespace App\Domains\Auth\Controllers;

use App\Domains\Auth\Requests\RegisterRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        if (! auth()->check()) {
            $request->authenticate();

            $request->session()->regenerate();
        }

        return response()->json(auth()->user());
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $payload = $request->validated();
        $payload['password'] = Hash::make($payload['password']);

        $user = User::create($payload);

        event(new Registered($user));

        return response()
            ->json($user, 201);
    }
}

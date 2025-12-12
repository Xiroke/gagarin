<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\CreateUserRequest;
use App\Http\Requests\Auth\LoginUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

/**
 *
 */
class AuthController extends Controller
{
    /**
     * Регистрация
     * @param  CreateUserRequest  $request
     * @return JsonResponse
     */
    public function registration(CreateUserRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $name = $validated['first_name'].' '.$validated['last_name'];

        if (isset($validated['patronymic'])) {
            $name = $name.' '.$validated['patronymic'];
        }

        $user = User::create([
            'name' => $name,
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'birth_date' => $validated['birth_date']
        ]);

        $data = [
            'user' => $user->only('name', 'email'),
            'code' => 201,
            'message' => 'Пользователь создан'
        ];

        return response()->json(['data' => $data]);
    }


    /**
     * Вход в профиль
     * @param  LoginUserRequest  $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function authorization(LoginUserRequest $request): JsonResponse
    {
        $validated = $request->validated();

        if (!auth()->attempt($validated)) {
            throw ValidationException::withMessages([
                'email' => ['Credentials is invalid'],
            ]);
        }

        $user = auth()->user();
        $token = $user->createToken('token')->plainTextToken;

        $data = [
            'user' => $user->only('id', 'name', 'birth_date', 'email'),
            'token' => $token
        ];
        return response()->json(['data' => $data]);
    }

    /**
     * Выход из профиля
     * @param  Request  $request
     * @return Response
     */
    public function logout(Request $request): Response
    {
        auth()->user()->currentAccessToken()->delete();
        return response()->noContent();
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\CreateUserRequest;
use App\Http\Requests\Auth\LoginUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Nette\Schema\ValidationException;

class AuthController extends Controller
{
    public function registration(CreateUserRequest $request) {
        $validated = $request->validated();

        $name = $validated['first_name'] . ' ' . $validated['last_name'];

        if (isset($validated['patronymic'])) {
            $name = $name . ' ' . $validated['patronymic'];
        }

        $user = User::create([
            'name' =>  $name,
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

    public function authorization(LoginUserRequest $request) {
        $validated = $request->validated();

        if (!auth()->attempt($validated)) {
            throw ValidationException::withMessages([
                'email' => ['Неверный логин или пароль'],
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

    public function logout(Request $request) {
        auth()->user()->currentAccessToken()->delete();
        return response()->noContent();
    }
}

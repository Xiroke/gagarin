<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\CreateUserRequest;
use App\Http\Requests\Auth\LoginUserRequest;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function registration(CreateUserRequest $request) {

    }

    public function login(LoginUserRequest $request) {

    }

    public function logout(Request $request) {

    }
}

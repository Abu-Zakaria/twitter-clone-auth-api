<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $request->login();
    }

    public function register(RegisterRequest $request)
    {
        $request->register();
    }
}

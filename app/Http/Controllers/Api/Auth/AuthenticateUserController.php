<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthenticateUserRequest;

class AuthenticateUserController extends Controller
{
    public function __invoke(AuthenticateUserRequest $request)
    {
        return $request->authenticate();
    }
}

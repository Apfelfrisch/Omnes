<?php

namespace App\Http\Controllers\Auth;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RedirectsUsers;
use App\ServiceBus\RegisterUser\RegisterUserCommand;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $response = $this->commandBus->handle(new RegisterUserCommand($request));

        return $response;
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $response = $this->commandBus->handle(new \App\Service\Bus\Command\AddRoleToUserCommand(2, 1, 1));
        return view('home');
    }
}

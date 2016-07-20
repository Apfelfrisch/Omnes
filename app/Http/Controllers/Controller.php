<?php

namespace App\Http\Controllers;

use League\Tactician\CommandBus;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, ValidatesRequests;

    protected $commandBus;

    public function __construct()
    {
        $this->commandBus = app(CommandBus::class);
    }
}

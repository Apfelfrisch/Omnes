<?php

use Mockery as m;
use Illuminate\Contracts\Auth\Access\Gate;

abstract class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    protected function makeGateWichAllowsPermission()
    {
        return $this->makeGate($allow = true);
    }

    protected function makeGateWichDeniesPermission()
    {
        return $this->makeGate($allow = false);
    }

    protected function makeGate($allow)
    {
        return m::spy(Gate::class)
            ->shouldReceive('denies')->andReturn($allow == false)
            ->shouldReceive('allows')->andReturn($allow)
            ->getMock();
    }
}

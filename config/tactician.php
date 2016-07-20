<?php

use League\Tactician\Plugins\LockingMiddleware;
use League\Tactician\Handler\CommandHandlerMiddleware;
use Madewithlove\Tactician\Middlewares\TransactionMiddleware;

return [
    'middlewares' => [
        LockingMiddleware::class,
        TransactionMiddleware::class,
        CommandHandlerMiddleware::class,
    ],

    'replacements' => [
        'origin' => 'Command',
        'target' => 'Handler',
    ]
];

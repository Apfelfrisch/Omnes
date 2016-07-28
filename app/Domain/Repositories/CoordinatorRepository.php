<?php

namespace App\Domain\Repositories;

use App\Domain\Coordinator;

class CoordinatorRepository
{
    public function find($id)
    {
        return Coordinator::find($id);
    }
}

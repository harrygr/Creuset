<?php

namespace App\Repositories\User;

use App\Repositories\DbRepository;
use App\User;

class DbUserRepository extends DbRepository
{
    /**
     * Create a new DbUserRepository instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }
}

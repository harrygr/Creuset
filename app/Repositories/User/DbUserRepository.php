<?php

namespace Creuset\Repositories\User;

use Creuset\Repositories\DbRepository;
use Creuset\User;
use Illuminate\Support\Collection;

class DbUserRepository extends DbRepository
{
    /**
     * Create a new DbUserRepository instance
     * 
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }
}

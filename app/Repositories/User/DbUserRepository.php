<?php

namespace Creuset\Repositories\User;

use Creuset\User;
use Illuminate\Support\Collection;

class DbUserRepository
{
    public function create(Collection $data, $role = 'subscriber')
    {
        return User::create([
            'name'         => $data['name'],
            'email'        => $data['email'],
            'username'     => $data->get('username', $data['email']),
            'password'     => bcrypt($data->get('password', mt_rand())),
            'auto_created' => !$data->has('password'),
        ]);
    }
}

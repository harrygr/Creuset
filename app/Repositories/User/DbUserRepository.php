<?php

namespace Creuset\Repositories\User;

use Creuset\User;

class DbUserRepository {
    public function create($data)
    {
        return User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'username' => $data['username'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function fetchOrCreate($input)
    {
        if (!$user = User::where('email', $input['email'])->first())
        {
            $data = collect([
            'password'  => bcrypt(mt_rand()),
            'email'     => $input['email'],
            'name'      => $input['name'],
            'username'  => str_slug($input['name']),
            ]);
            
            return $this->create($data);
        }
        return $user;
    }
}
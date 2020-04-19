<?php

namespace App\Repositories\User;
use App\User;

class UserRepository implements UserRepositoryInterface
{
    function __construct() {
    }

    public function getAll() {
        return User::all();
    }

    public function update($id, $firstname, $lastname, $timezone) {
        $user = User::findOrFail($id);
        $user->setFirstname($firstname);
        $user->setLastname($lastname);
        $user->setTimezone($timezone);
        $user->update();
    }
}

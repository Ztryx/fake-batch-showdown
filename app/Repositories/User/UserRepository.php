<?php

namespace App\Repositories\User;
use App\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserRepositoryInterface
{
    function __construct() {
    }

    public function getAll(): Collection{
        return User::all();
    }

    public function get(int $id): User{
        return User::findOrFail($id);
    }

    public function update(int $id, string $firstname, string $lastname, string $timezone): void{
        $user = User::findOrFail($id);
        $user->setFirstName($firstname);
        $user->setLastName($lastname);
        $user->setTimezone($timezone);
        $user->update();
    }
}

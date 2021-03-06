<?php

namespace App\Repositories\User;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface
{
    function __construct() {
    }

    public function getAll(): Collection{
        return User::all();
    }

    public function getAllUpdatable($date): \Illuminate\Support\Collection {
        return Db::table('users')->where('updated_at', '>', $date)->get();
    }

    public function get(int $id): User{
        return User::findOrFail($id);
    }

    public function getByEmail($email): User{
        return User::where('email', '=', $email)->first();
    }

    public function update(int $id, string $firstname, string $lastname, string $timezone): void{
        $user = User::findOrFail($id);
        $user->setFirstName($firstname);
        $user->setLastName($lastname);
        $user->setTimezone($timezone);
        $user->update();
    }
}

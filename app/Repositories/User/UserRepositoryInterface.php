<?php

namespace App\Repositories\User;

use App\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface {

    public function getAll(): Collection;

    public function getAllUpdateable($date): \Illuminate\Support\Collection;

    public function get(int $id): User;

    public function update(int $id, string $firstname, string $lastname, string $timezone): void;

}

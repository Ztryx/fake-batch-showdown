<?php

namespace Tests\Unit;

use App\Repositories\User\UserRepository;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    public function setUp(): void {
        parent::setUp();
        $this->user = factory(User::class)->create();
        $this->user = factory(User::class)->create();
        $this->user = factory(User::class)->create();
        $this->user = factory(User::class)->create();
        $this->user = factory(User::class)->create();
    }

    public function tearDown(): void {
        parent::tearDown();
    }

    /**
     * Test GetAll Repository
     *
     * @return void
     */
    public function testGetAllRepository()
    {
        $userRepository = new UserRepository();
        $this->assertEquals($userRepository->getAll()->count(), 5);
    }

    /**
     * Test Update User
     *
     * @return void
     */
    public function testUpdateRepository()
    {
        $userRepository = new UserRepository();
        $userRepository->update(1, 'random firstname', 'random lastname', 'CET');
        $user = $userRepository->get(1);
        $this->assertEquals([
            'id' => 1,
            'firstname' => 'random firstname',
            'lastname' => 'random lastname',
            'timezone' => 'CET',
        ], [
            'id' => $user->id,
            'firstname' => $user->firstname,
            'lastname' => $user->lastname,
            'timezone' => $user->timezone,
        ]);
    }
}

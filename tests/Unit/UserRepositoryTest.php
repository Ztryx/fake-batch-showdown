<?php

namespace Tests\Unit;

use App\Repositories\User\UserRepository;
use App\User;
use Carbon\Carbon;
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
     * Test Get Repository
     *
     * @return void
     */
    public function testGetRepository()
    {
        $userRepository = new UserRepository();
        foreach($userRepository->getAll() as $user) {
            $this->assertEquals($user->id, $userRepository->get($user->id)->id);
        }
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

    /**
     * Test Get Updatable Users
     *
     * @return void
     */
    public function testGetAllUpdateableUsersRepository()
    {
        $userRepository = new UserRepository();
        //Fake realtime based system
        sleep(5);
        //Update an user
        $userRepository->update(1, 'random firstname', 'random lastname', 'CET');
        //Fake realtime based system
        sleep(5);
        //Get All updateable Users with previous date, in order to fake a previous completed batch
        $date = Carbon::now()->subSeconds(6);
        $updateable_users_list = $userRepository->getAllUpdatable($date);
        $this->assertEquals(1, $updateable_users_list->count());
    }

    /**
     * Test Get By Email User
     *
     * @return void
     */
    public function testGetByEmailRepository()
    {
        $userRepository = new UserRepository();
        foreach($userRepository->getAll() as $user) {
            $this->assertEquals($user->id, $userRepository->getByEmail($user->email)->id);
        }
    }
}

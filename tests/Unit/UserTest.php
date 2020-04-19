<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    public function setUp(): void {
        parent::setUp();
        $this->user = factory(User::class)->create();
    }

    public function tearDown(): void {
        parent::tearDown();
    }

    /**
     * Create User from Factory
     *
     * @return void
     */
    public function testCreateUser()
    {
        $user = factory(User::class)->create();
        $this->assertEquals(2, $user->id);
    }

    /**
     * Test setFirstName method
     *
     * @return void
     */
    public function testSetFirstName()
    {
        $this->user->setFirstName('random name');
        $this->assertEquals('random name', $this->user->firstname);
    }

    /**
     * Test setLastName method
     *
     * @return void
     */
    public function testSetLastName()
    {
        $this->user->setLastName('random last name');
        $this->assertEquals('random last name', $this->user->lastname);
    }

    /**
     * Test setTimezone method
     *
     * @return void
     */
    public function testTimezone()
    {
        $this->user->setTimezone('CET');
        $this->assertEquals('CET', $this->user->timezone);
    }
}

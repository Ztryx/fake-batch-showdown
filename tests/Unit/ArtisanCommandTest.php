<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArtisanCommandTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    public function setUp(): void {
        parent::setUp();
        $this->artisan('migrate:fresh --seed');
    }

    public function tearDown(): void {
        parent::tearDown();
    }

    /**
     * Test Migrate and Seed
     *
     * @return void
     */
    public function testMigrateAndSeed()
    {
        $this->artisan('migrate:fresh --seed')
            ->expectsOutput('Dropped all tables successfully.')
            ->expectsOutput('Migration table created successfully.')
            ->expectsOutput('Migrating: 2014_10_12_000000_create_users_table')
            ->expectsOutput('Migrating: 2019_08_19_000000_create_failed_jobs_table')
            ->expectsOutput('Migrating: 2020_04_19_000000_create_last_batch_updated_user')
            ->expectsOutput('Migrating: 2020_04_19_000001_create_batch_counter')
            ->expectsOutput('Seeding: UserSeeder')
            ->expectsOutput('Seeding: LastBatchUpdatedUserSeeder')
            ->expectsOutput('Seeding: BatchCounterSeeder')
            ->expectsOutput('Database seeding completed successfully.')
            ->assertExitCode(0);
    }

    /**
     * Test Update Randomly Users
     *
     * @return void
     */
    public function testUpdateRandomlyUsers()
    {
        $this->artisan('command:update-users-randomly')
            ->assertExitCode(0);
    }

    /**
     * Test Update Randomly User By Email
     *
     * @return void
     */
    public function testUpdateRandomlyUserByEmail()
    {
        $this->user = factory(User::class)->create([
            'email' => 'test@example.com'
        ]);
        $this->artisan('command:update-user-randomly --email=test@example.com')
            ->assertExitCode(0);
    }

    /**
     * Test Update Randomly User By Email non provided
     *
     * @return void
     */
    public function testUpdateRandomlyUserByEmailNonProvided()
    {
        $this->artisan('command:update-user-randomly --email=')
            ->assertExitCode(0);
    }

    /**
     * Test Update Randomly User By Email non provided
     *
     * @return void
     */
    public function testUpdateRandomlyUserByEmailNonExistent()
    {
        $this->artisan('command:update-user-randomly --email=asdasdasdasd@asdasdasd.com')
            ->assertExitCode(0);
    }

    /**
     * Test Clear Batch Command
     *
     * @return void
     */
    public function testClearBatch()
    {
        $this->artisan('command:clear-batch-counter')
            ->assertExitCode(0);
    }
}

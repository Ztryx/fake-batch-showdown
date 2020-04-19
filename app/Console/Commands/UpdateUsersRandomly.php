<?php

namespace App\Console\Commands;

use App\Repositories\User\UserRepositoryInterface;
use Faker\Factory as Faker;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdateUsersRandomly extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * The name and signature of the console command.
     *
     * @var Faker
     */
    private $faker;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:update-users-randomly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Randomly updates all users in database with random values for fields';

    /**
     * Create a new command instance.
     *
     * @param UserRepositoryInterface $userRepository
     * @return void
     */
    public function __construct(UserRepositoryInterface $userRepository) {
        parent::__construct();
        $this->userRepository = $userRepository;
        $this->faker = Faker::create();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        foreach ($this->userRepository->getAll() as $user) {
            $this->userRepository->update($user->id, $this->faker->firstName, $this->faker->lastName, $this->faker->timezone);
        }
        Log::info("Success");
    }
}

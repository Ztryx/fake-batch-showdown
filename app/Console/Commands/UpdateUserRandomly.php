<?php

namespace App\Console\Commands;

use App\Repositories\User\UserRepositoryInterface;
use Faker\Factory as Faker;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdateUserRandomly extends Command
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
    protected $signature = 'command:update-user-randomly {--email=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update randomly a user by an email as parameter';

    /**
     * Create a new command instance.
     *
     * @param UserRepositoryInterface $userRepository
     * @return void
     */
    public function __construct(UserRepositoryInterface $userRepository) {
        parent::__construct();
        $this->userRepository =$userRepository;
        $this->faker = Faker::create();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        if(!empty($this->option('email'))) {
            $user = $this->userRepository->getByEmail($this->option('email'));
            if(!empty($user)) {
                $this->userRepository->update($user->id, $this->faker->firstName, $this->faker->lastName, $this->faker->timezone);
            } else
                Log::error("Provided 'email' does not exist");
        } else
            Log::error("No argument 'email' provided");
    }
}

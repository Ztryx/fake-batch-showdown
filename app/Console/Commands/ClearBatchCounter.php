<?php

namespace App\Console\Commands;

use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\FakeBatchAPI;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ClearBatchCounter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:clear-batch-counter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear Batch Counter';

    /**
     * Create a new command instance.
     *
     * @param UserRepositoryInterface $userRepository
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        $fakeBatchAPIService = new FakeBatchAPI(new UserRepository());
        $fakeBatchAPIService->fakeUpdateLeftUsers();
        DB::table('batch_counter')->latest('id')->update([
            'requests_number' => 0
        ]);
        Log::info("Batch counter successfully cleaned");
    }
}

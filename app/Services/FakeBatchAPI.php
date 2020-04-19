<?php

namespace App\Services;

use App\Repositories\User\UserRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FakeBatchAPI
{
    const PAYLOAD_SIZE = 5;
    const REQUEST_LIMIT = 4;
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function fakeUpdateUser() {
        $last_batch_updated_user = DB::table('last_batch_updated_user')->latest('id')->first()->updated_at;
        $users_updatable_list = $this->userRepository->getAllUpdatable($last_batch_updated_user);
        $requests_number = DB::table('batch_counter')->latest('id')->first()->requests_number;
        if($users_updatable_list->count() == env('PAYLOAD_SIZE', self::PAYLOAD_SIZE) && $requests_number < env('REQUEST_LIMIT', self::REQUEST_LIMIT))
            $this->fakeLogUpdatedUsers($requests_number, $users_updatable_list);
        //Fake realtime delay in order to check If is actually printing that messages as how should be
        sleep(1);
    }

    public function fakeUpdateLeftUsers() {
        $last_batch_updated_user = DB::table('last_batch_updated_user')->latest('id')->first()->updated_at;
        $users_updatable_list = $this->userRepository->getAllUpdatable($last_batch_updated_user);
        $requests_number = DB::table('batch_counter')->latest('id')->first()->requests_number;
        if($users_updatable_list->count() > 0 && $requests_number < env('REQUEST_LIMIT', self::REQUEST_LIMIT))
            $this->fakeLogUpdatedUsers($requests_number, $users_updatable_list);
        //Fake realtime delay in order to check If is actually printing that messages as how should be
        sleep(1);
    }

    private function fakeLogUpdatedUsers(int $requests_number, Collection $users_updatable_list) {
        $requests_number = $requests_number + 1;
        Log::info('Batch number: '.$requests_number);
        DB::table('batch_counter')->latest('id')->update(['requests_number' => $requests_number]);
        DB::table('last_batch_updated_user')->insert([
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        foreach ($users_updatable_list as $updateable_user) {
            Log::info('['.$updateable_user->id.']'.'firstname: '.$updateable_user->firstname.' '.'timezone: '.$updateable_user->timezone);
        }
    }

}

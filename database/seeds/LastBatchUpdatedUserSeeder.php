<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LastBatchUpdatedUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('last_batch_updated_user')->insert([
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}

<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BatchCounterSeeder extends Seeder
{
    /**
     * Run Batch Counter Seeder.
     *
     * @return void
     */
    public function run()
    {
        DB::table('batch_counter')->insert([
            'requests_number' => 0
        ]);
    }
}

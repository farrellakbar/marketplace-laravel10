<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('job_historys')->insert([
            'roles_id' => 1,
            'users_id' => 1,
            'is_active' => true,
            'valid_from' => now()
        ]);
        // DB::table('job_historys')->insert([
        //     'roles_id' => 2,
        //     'users_id' => 2,
        //     'is_active' => true,
        //     'valid_from' => now()
        // ]);
    }
}

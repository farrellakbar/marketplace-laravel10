<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permissions')->insert([
            'roles_id' => 1,
            'menus_id' => 2,
            'can_create' => true,
            'can_view' => true,
            'can_edit' => true,
            'can_delete' => true,
            'can_export' => true,
        ]);
        DB::table('permissions')->insert([
            'roles_id' => 1,
            'menus_id' => 3,
            'can_create' => true,
            'can_view' => true,
            'can_edit' => true,
            'can_delete' => true,
            'can_export' => true,
        ]);
        DB::table('permissions')->insert([
            'roles_id' => 1,
            'menus_id' => 4,
            'can_create' => true,
            'can_view' => true,
            'can_edit' => true,
            'can_delete' => true,
            'can_export' => true,
        ]);
        DB::table('permissions')->insert([
            'roles_id' => 1,
            'menus_id' => 5,
            'can_create' => true,
            'can_view' => true,
            'can_edit' => true,
            'can_delete' => true,
            'can_export' => true,
        ]);
        DB::table('permissions')->insert([
            'roles_id' => 1,
            'menus_id' => 6,
            'can_create' => true,
            'can_view' => true,
            'can_edit' => true,
            'can_delete' => true,
            'can_export' => true,
        ]);
        // DB::table('permissions')->insert([
        //     'roles_id' => 2,
        //     'menus_id' => 9,
        //     'can_create' => true,
        //     'can_view' => true,
        //     'can_edit' => true,
        //     'can_delete' => true,
        //     'can_export' => true,
        // ]);
        // DB::table('permissions')->insert([
        //     'roles_id' => 2,
        //     'menus_id' => 10,
        //     'can_create' => true,
        //     'can_view' => true,
        //     'can_edit' => true,
        //     'can_delete' => true,
        //     'can_export' => true,
        // ]);
    }
}

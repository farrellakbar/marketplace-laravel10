<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('menus')->insert([
            'parent_menus_id' => null,
            'name' => 'Management',
            'key_name' => 'management',
            'route' => 'management.index',
            'url' => '/management',
            'icon' => 'fa fa-server',
            'ordinal_number' => 1,
            'is_active' => true,
        ]);
        DB::table('menus')->insert([
            'parent_menus_id' => 1,
            'name' => 'User',
            'key_name' => 'user',
            'route' => 'user.index',
            'url' => '/user',
            'icon' => null,
            'ordinal_number' => 1,
            'is_active' => true,
        ]);
        // DB::table('menus')->insert([
        //     'parent_menus_id' => 1,
        //     'name' => 'Opd',
        //     'key_name' => 'opd',
        //     'route' => 'opd.index',
        //     'url' => '/opd',
        //     'icon' => null,
        //     'ordinal_number' => 2,
        //     'is_active' => true,
        // ]);
        DB::table('menus')->insert([
            'parent_menus_id' => 1,
            'name' => 'Role',
            'key_name' => 'role',
            'route' => 'role.index',
            'url' => '/role',
            'icon' => null,
            'ordinal_number' => 3,
            'is_active' => true,
        ]);
        DB::table('menus')->insert([
            'parent_menus_id' => 1,
            'name' => 'Job User',
            'key_name' => 'job_user',
            'route' => 'jobuser.index',
            'url' => '/job-user',
            'icon' => null,
            'ordinal_number' => 4,
            'is_active' => true,
        ]);
        DB::table('menus')->insert([
            'parent_menus_id' => 1,
            'name' => 'Menu',
            'key_name' => 'menu',
            'route' => 'menu.index',
            'url' => '/menu',
            'icon' => null,
            'ordinal_number' => 5,
            'is_active' => true,
        ]);
        DB::table('menus')->insert([
            'parent_menus_id' => 1,
            'name' => 'Permission',
            'key_name' => 'permission',
            'route' => 'permission.index',
            'url' => '/permission',
            'icon' => null,
            'ordinal_number' => 6,
            'is_active' => true,
        ]);
        DB::table('menus')->insert([
            'parent_menus_id' => null,
            'name' => 'Menu',
            'key_name' => 'menu',
            'route' => 'menu.index',
            'url' => '/menu',
            'icon' => 'fa fa-list-alt',
            'ordinal_number' => 2,
            'is_active' => true,
        ]);
        // DB::table('menus')->insert([
        //     'parent_menus_id' => 8,
        //     'name' => 'Pertanyaan Umum',
        //     'key_name' => 'pertanyaan_umum',
        //     'route' => 'pertanyaanumum.index',
        //     'url' => '/pertanyaan-umum',
        //     'icon' => null,
        //     'ordinal_number' => 1,
        //     'is_active' => true,
        // ]);
        // DB::table('menus')->insert([
        //     'parent_menus_id' => 8,
        //     'name' => 'Layanan',
        //     'key_name' => 'layanan',
        //     'route' => 'layanan.index',
        //     'url' => '/layanan',
        //     'icon' => null,
        //     'ordinal_number' => 2,
        //     'is_active' => true,
        // ]);
        // DB::table('menus')->insert([
        //     'parent_menus_id' => null,
        //     'name' => 'Form Survey',
        //     'key_name' => 'form_survey',
        //     'route' => 'formsurvey.index',
        //     'url' => '/form-survey',
        //     'icon' => 'fa fa-list-alt',
        //     'ordinal_number' => 2,
        //     'is_active' => true,
        // ]);
        // DB::table('menus')->insert([
        //     'parent_menus_id' => 8,
        //     'name' => 'Pertanyaan Umum',
        //     'key_name' => 'pertanyaan_umum',
        //     'route' => 'pertanyaanumum.index',
        //     'url' => '/pertanyaan-umum',
        //     'icon' => null,
        //     'ordinal_number' => 1,
        //     'is_active' => true,
        // ]);
        // DB::table('menus')->insert([
        //     'parent_menus_id' => 8,
        //     'name' => 'Layanan',
        //     'key_name' => 'layanan',
        //     'route' => 'layanan.index',
        //     'url' => '/layanan',
        //     'icon' => null,
        //     'ordinal_number' => 2,
        //     'is_active' => true,
        // ]);
    }
}

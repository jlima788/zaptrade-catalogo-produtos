<?php

use Illuminate\Database\Seeder;

class RoleHasPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('role_has_permissions')->insert([
            'permission_id' => 1,
            'role_id' => 1
        ]);
        \Illuminate\Support\Facades\DB::table('role_has_permissions')->insert([
            'permission_id' => 1,
            'role_id' => 2
        ]);
        \Illuminate\Support\Facades\DB::table('role_has_permissions')->insert([
            'permission_id' => 2,
            'role_id' => 1
        ]);
        \Illuminate\Support\Facades\DB::table('role_has_permissions')->insert([
            'permission_id' => 2,
            'role_id' => 2
        ]);
        \Illuminate\Support\Facades\DB::table('role_has_permissions')->insert([
            'permission_id' => 3,
            'role_id' => 1
        ]);
        \Illuminate\Support\Facades\DB::table('role_has_permissions')->insert([
            'permission_id' => 3,
            'role_id' => 2
        ]);
        \Illuminate\Support\Facades\DB::table('role_has_permissions')->insert([
            'permission_id' => 4,
            'role_id' => 1
        ]);
        \Illuminate\Support\Facades\DB::table('role_has_permissions')->insert([
            'permission_id' => 4,
            'role_id' => 2
        ]);
        \Illuminate\Support\Facades\DB::table('role_has_permissions')->insert([
            'permission_id' => 5,
            'role_id' => 1
        ]);
        \Illuminate\Support\Facades\DB::table('role_has_permissions')->insert([
            'permission_id' => 6,
            'role_id' => 1
        ]);
        \Illuminate\Support\Facades\DB::table('role_has_permissions')->insert([
            'permission_id' => 7,
            'role_id' => 1
        ]);
    }
}

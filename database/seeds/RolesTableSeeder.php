<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('roles')->insert([
            'name'=> 'Gerente',
            'guard_name' => 'web'
        ]);

        \Illuminate\Support\Facades\DB::table('roles')->insert([
            'name'=> 'Vendedor',
            'guard_name' => 'web'
        ]);
    }
}

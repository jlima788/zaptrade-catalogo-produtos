<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('users')->insert([
            'name'=> 'Gerente 1',
            'email'=> 'gerente1@empresa.com',
            'password' => bcrypt('12345678'),
            'manager' => 1
        ]);

        \Illuminate\Support\Facades\DB::table('users')->insert([
            'name'=> 'Vendedor 1',
            'email'=> 'vendedor1@empresa.com',
            'password' => bcrypt('12345678'),
            'seller' => 1
        ]);

        \Illuminate\Support\Facades\DB::table('users')->insert([
            'name'=> 'Vendedor 2',
            'email'=> 'vendedor2@empresa.com',
            'password' => bcrypt('12345678'),
            'seller' => 1
        ]);
    }
}

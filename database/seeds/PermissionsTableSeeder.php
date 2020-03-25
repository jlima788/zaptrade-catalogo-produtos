<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('permissions')->insert([
            'name' => 'Listar Produtos',
            'guard_name' => 'web'
        ]);

        \Illuminate\Support\Facades\DB::table('permissions')->insert([
            'name' => 'Cadastrar Produto',
            'guard_name' => 'web'
        ]);

        \Illuminate\Support\Facades\DB::table('permissions')->insert([
            'name' => 'Editar Produto',
            'guard_name' => 'web'
        ]);

        \Illuminate\Support\Facades\DB::table('permissions')->insert([
            'name' => 'Remover Produto',
            'guard_name' => 'web'
        ]);

        \Illuminate\Support\Facades\DB::table('permissions')->insert([
            'name' => 'Ver Configurações',
            'guard_name' => 'web'
        ]);

        \Illuminate\Support\Facades\DB::table('permissions')->insert([
            'name' => 'Alterar Status',
            'guard_name' => 'web'
        ]);

        \Illuminate\Support\Facades\DB::table('permissions')->insert([
            'name' => 'Remover Usuário',
            'guard_name' => 'web'
        ]);

    }
}

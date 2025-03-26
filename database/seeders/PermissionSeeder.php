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
        $permissions = [
            ['name' => 'permission_view', 'label' => 'Visualizar permissões',],
            ['name' => 'permission_create', 'label' => 'Criar permissão',],
            ['name' => 'permission_edit', 'label' => 'Editar permissão'],

            ['name' => 'product_view', 'label' => 'Visualizar produtos',],
            ['name' => 'product_create', 'label' => 'Criar produtos',],
            ['name' => 'product_edit', 'label' => 'Editar produtos'],
            ['name' => 'product_delete', 'label' => 'Deletar produtos'],

            ['name' => 'user_view', 'label' => 'Visualizar usuários'],
            ['name' => 'user_create', 'label' => 'Criar usuários'],
            ['name' => 'user_edit', 'label' => 'Editar usuários'],
            ['name' => 'user_delete', 'label' => 'Deletar usuários'],

            ['name' => 'category_view', 'label' => 'Visualizar categorias'],
            ['name' => 'category_create', 'label' => 'Criar categorias'],
            ['name' => 'category_edit', 'label' => 'Editar categorias'],
            ['name' => 'category_delete', 'label' => 'Deletar categorias'],

            ['name' => 'brand_view', 'label' => 'Visualizar marcas'],
            ['name' => 'brand_create', 'label' => 'Criar marcas'],
            ['name' => 'brand_edit', 'label' => 'Editar marcas'],
            ['name' => 'brand_delete', 'label' => 'Deletar marcas'],
        ];

        DB::table('permissions')->insert($permissions);
    }
}

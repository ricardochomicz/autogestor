<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Administrador',
            'email' => 'admin@email.com',
            'password' => bcrypt('password'),
        ]);

        $user = User::factory()->create([
            'name' => 'Usuario',
            'email' => 'user@email.com',
            'password' => bcrypt('password'),
            'admin_id' => 1,
        ]);

        $this->call([
            BrandSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            RoleSeeder::class,
            PermissionSeeder::class,
        ]);



        // Buscar a role "Administrador"
        $adminRole = Role::where('name', 'admin')->first();

        $userRole = Role::where('name', 'user')->first();

        // Buscar as permissões necessárias
        $permissions = Permission::whereIn('name', [
            'user_view',
            'user_create',
            'user_edit',
            'user_delete'
        ])->get();

        // Atribuir a role ao Admin
        if ($adminRole) {
            $admin->roles()->attach($adminRole->id);
        }

        if ($userRole) {
            $user->roles()->attach($userRole->id);
        }

        // Atribuir as permissões ao Admin
        if ($permissions->isNotEmpty()) {
            $admin->permissions()->attach($permissions->pluck('id'));
        }
    }
}

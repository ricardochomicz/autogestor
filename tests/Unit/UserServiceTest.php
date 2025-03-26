<?php

namespace Tests\Unit;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;
    protected $regularUser;
    protected $userService;

    protected function setUp(): void
    {
        parent::setUp();

        // Cria usuários para teste
        $this->adminUser = User::factory()->create(['admin_id' => null]); // Admin
        $this->regularUser = User::factory()->create(['admin_id' => $this->adminUser->id]); // Subordinado

        // Autentica como administrador
        $this->actingAs($this->adminUser);

        // Instancia o serviço
        $this->userService = new UserService();
    }

    public function test_index_returns_users_for_admin()
    {
        User::factory()->count(5)->create(['admin_id' => $this->adminUser->id]);

        $users = $this->userService->index();

        $this->assertCount(6, $users->items()); // Inclui o próprio admin
    }

    public function test_index_returns_only_self_for_regular_user()
    {
        $this->actingAs($this->regularUser);

        $users = $this->userService->index();

        $this->assertCount(1, $users->items()); // Apenas o próprio usuário
        $this->assertEquals($this->regularUser->id, $users->items()[0]->id);
    }

    public function test_get_returns_a_specific_user_for_admin()
    {
        $subordinate = User::factory()->create(['admin_id' => $this->adminUser->id]);

        $retrievedUser = $this->userService->get($subordinate->id);

        $this->assertNotNull($retrievedUser);
        $this->assertEquals($subordinate->id, $retrievedUser->id);
    }

    public function test_store_creates_a_new_user()
    {
        $data = [
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'password' => 'password',
        ];

        $user = $this->userService->store($data);

        $this->assertDatabaseHas('users', [
            'name' => 'New User',
            'email' => 'newuser@example.com',
        ]);
        $this->assertEquals($this->adminUser->id, $user->admin_id); // Confirma o vínculo com o admin
    }

    public function test_update_modifies_an_existing_user()
    {
        $subordinate = User::factory()->create(['admin_id' => $this->adminUser->id]);

        $data = ['name' => 'Updated User'];

        $updatedUser = $this->userService->update($data, $subordinate->id);

        $this->assertEquals('Updated User', $updatedUser->name);
        $this->assertDatabaseHas('users', ['name' => 'Updated User']);
    }

    public function test_count_users_returns_correct_count_for_admin()
    {
        User::factory()->count(4)->create(['admin_id' => $this->adminUser->id]);

        $count = $this->userService->countUsers();

        $this->assertEquals(6, $count); // Inclui o próprio admin
    }

    public function test_count_users_returns_correct_count_for_regular_user()
    {
        $this->actingAs($this->regularUser);

        $count = $this->userService->countUsers();

        $this->assertEquals(1, $count); // Apenas o próprio usuário
    }
}

<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\User;
use App\Services\CategoryService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $categoryService;

    protected function setUp(): void
    {
        parent::setUp();

        // Cria um usuário para autenticação
        $this->user = User::factory()->create();

        // Autentica o usuário
        $this->actingAs($this->user);

        // Instancia o serviço
        $this->categoryService = new CategoryService();
    }

    public function test_to_select_returns_correct_data()
    {
        Category::factory()->create(['user_id' => $this->user->id, 'name' => 'Category 1']);
        Category::factory()->create(['user_id' => $this->user->id, 'name' => 'Category 2']);

        $categories = $this->categoryService->toSelect();

        $this->assertCount(2, $categories);
        $this->assertEquals('Category 1', $categories->first()->name);
    }

    public function test_index_returns_paginated_categories()
    {
        Category::factory()->count(15)->create(['user_id' => $this->user->id]);

        $categories = $this->categoryService->index();

        $this->assertCount(10, $categories->items()); // Paginação padrão é 10 itens por página
    }

    public function test_store_creates_a_new_category()
    {
        $data = ['name' => 'New Category'];

        $category = $this->categoryService->store($data);

        $this->assertDatabaseHas('categories', ['name' => 'New Category', 'user_id' => $this->user->id]);
        $this->assertEquals('New Category', $category->name);
    }

    public function test_update_modifies_an_existing_category()
    {
        $category = Category::factory()->create(['user_id' => $this->user->id, 'name' => 'Original Category']);

        $data = ['name' => 'Updated Category'];

        $updatedCategory = $this->categoryService->update($data, $category->id);

        $this->assertEquals('Updated Category', $updatedCategory->name);
        $this->assertDatabaseHas('categories', ['name' => 'Updated Category']);
    }

    public function test_destroy_deletes_a_category()
    {
        $category = Category::factory()->create(['user_id' => $this->user->id, 'name' => 'Category to delete']);

        $result = $this->categoryService->destroy($category->id);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('categories', ['name' => 'Category to delete']);
    }

    public function test_count_categories_returns_correct_count()
    {
        Category::factory()->count(5)->create(['user_id' => $this->user->id]);

        $count = $this->categoryService->countCategories();

        $this->assertEquals(5, $count);
    }
}

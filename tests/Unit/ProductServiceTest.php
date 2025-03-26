<?php

namespace Tests\Unit;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Services\ProductService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $productService;

    protected function setUp(): void
    {
        parent::setUp();

        // Cria um usuário e autentica
        $this->user = User::factory()->create();
        $this->actingAs($this->user);

        // Instancia o serviço de produtos
        $this->productService = new ProductService();
    }

    public function test_index_returns_paginated_products()
    {
        $category = Category::factory()->create(['user_id' => $this->user->id, 'name' => 'Category 1']);
        $brand = Brand::factory()->create(['user_id' => $this->user->id, 'name' => 'Brand 1']);
        Product::factory()->count(15)->create([
            'user_id' => $this->user->id,
            'category_id' => $category->id,
            'brand_id' => $brand->id

        ]);

        $products = $this->productService->index();

        $this->assertCount(10, $products->items()); // Paginação padrão é 10 itens por página
    }

    public function test_get_returns_a_specific_product()
    {
        $category = Category::factory()->create(['user_id' => $this->user->id, 'name' => 'Category 1']);
        $brand = Brand::factory()->create(['user_id' => $this->user->id, 'name' => 'Brand 1']);
        $product = Product::factory()->create([
            'user_id' => $this->user->id,
            'category_id' => $category->id,
            'brand_id' => $brand->id
        ]);

        $retrievedProduct = $this->productService->get($product->id);

        $this->assertNotNull($retrievedProduct);
        $this->assertEquals($product->id, $retrievedProduct->id);
    }

    public function test_store_creates_a_new_product()
    {
        $category = Category::factory()->create(['user_id' => $this->user->id, 'name' => 'Category 1']);
        $brand = Brand::factory()->create(['user_id' => $this->user->id, 'name' => 'Brand 1']);

        $data = [
            'name' => 'New Product',
            'price' => 50.00,
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'stock' => 10,
            'description' => 'Product description'
        ];

        $product = $this->productService->store($data);

        $this->assertDatabaseHas('products', [
            'name' => 'New Product',
            'price' => 50.00,
            'user_id' => $this->user->id,
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'stock' => 10,
            'description' => 'Product description'
        ]);
    }

    public function test_update_modifies_an_existing_product()
    {
        $category = Category::factory()->create(['user_id' => $this->user->id, 'name' => 'Category 1']);
        $brand = Brand::factory()->create(['user_id' => $this->user->id, 'name' => 'Brand 1']);
        $product = Product::factory()->create(['user_id' => $this->user->id, 'name' => 'Original Name']);

        $data = [
            'name' => 'Updated Product',
            'price' => 50.00,
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'stock' => 10,
            'description' => 'Product description'
        ];

        $updatedProduct = $this->productService->update($data, $product->id);

        $this->assertEquals('Updated Product', $updatedProduct->name);
        $this->assertDatabaseHas('products', [
            'name' => 'Updated Product',
            'price' => 50.00,
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'stock' => 10,
            'description' => 'Product description'
        ]);
    }

    public function test_destroy_deletes_a_product()
    {
        $category = Category::factory()->create(['user_id' => $this->user->id, 'name' => 'Category 1']);
        $brand = Brand::factory()->create(['user_id' => $this->user->id, 'name' => 'Brand 1']);
        $product = Product::factory()->create([
            'user_id' => $this->user->id,
            'category_id' => $category->id,
            'brand_id' => $brand->id
        ]);

        $result = $this->productService->destroy($product->id);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    public function test_count_products_returns_correct_count()
    {
        $category = Category::factory()->create(['user_id' => $this->user->id, 'name' => 'Category 1']);
        $brand = Brand::factory()->create(['user_id' => $this->user->id, 'name' => 'Brand 1']);
        Product::factory()->count(5)->create([
            'user_id' => $this->user->id,
            'category_id' => $category->id,
            'brand_id' => $brand->id
        ]);

        $count = $this->productService->countProducts();

        $this->assertEquals(5, $count);
    }
}

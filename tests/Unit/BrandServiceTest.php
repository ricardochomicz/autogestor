<?php

namespace Tests\Unit;

use App\Models\Brand;
use App\Models\User;
use App\Services\BrandService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BrandServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $brandService;

    protected function setUp(): void
    {
        parent::setUp();

        // Cria um usuário para autenticação nos testes
        $this->user = User::factory()->create();

        // Autentica o usuário
        $this->actingAs($this->user);

        // Instancia o serviço
        $this->brandService = new BrandService();
    }

    public function test_to_select_returns_correct_data()
    {
        Brand::factory()->create([
            'user_id' => $this->user->id,
            'name' => 'Teste Marca 1',
        ]);
        Brand::factory()->create([
            'user_id' => $this->user->id,
            'name' => 'Teste Marca 2',
        ]);

        $brands = $this->brandService->toSelect();

        $this->assertCount(2, $brands);
        $this->assertEquals('Teste Marca 1', $brands->first()->name);
    }

    public function test_index_returns_paginated_brands()
    {
        Brand::factory()->count(15)->create(['user_id' => $this->user->id]);

        $brands = $this->brandService->index();

        $this->assertCount(10, $brands); // Padrão de paginação é 10
    }

    public function test_store_creates_a_new_brand()
    {
        $data = [
            'name' => 'Nova Marca',
        ];

        $brand = $this->brandService->store($data);

        $this->assertDatabaseHas('brands', [
            'name' => 'Nova Marca',
            'user_id' => $this->user->id,
        ]);
        $this->assertEquals('Nova Marca', $brand->name);
    }

    public function test_update_modifies_an_existing_brand()
    {
        $brand = Brand::factory()->create([
            'user_id' => $this->user->id,
            'name' => 'Marca Original',
        ]);

        $data = ['name' => 'Marca Atualizada'];

        $updatedBrand = $this->brandService->update($data, $brand->id);

        $this->assertEquals('Marca Atualizada', $updatedBrand->name);
        $this->assertDatabaseHas('brands', [
            'name' => 'Marca Atualizada',
        ]);
    }

    public function test_destroy_deletes_a_brand()
    {
        $brand = Brand::factory()->create([
            'user_id' => $this->user->id,
            'name' => 'Marca para Excluir',
        ]);

        $result = $this->brandService->destroy($brand->id);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('brands', [
            'name' => 'Marca para Excluir',
        ]);
    }

    public function test_count_brands_returns_correct_count()
    {
        Brand::factory()->count(5)->create(['user_id' => $this->user->id]);

        $count = $this->brandService->countBrands();

        $this->assertEquals(5, $count);
    }
}

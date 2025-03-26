<?php

namespace App\Livewire\Products;

use App\Services\ProductService;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    protected $queryString = ['search' => ['except' => '']];

    public function render()
    {
        $service = new ProductService();
        $filters = ['search' => $this->search];
        return view('livewire.products.index', [
            'products' => $service->index($filters)
        ]);
    }

    public function clearFilter(): void
    {
        $this->search = '';
    }
}

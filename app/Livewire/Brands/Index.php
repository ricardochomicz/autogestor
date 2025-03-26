<?php

namespace App\Livewire\Brands;

use App\Services\BrandService;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    protected $queryString = ['search' => ['except' => '']];

    public function render()
    {
        $service = new BrandService();
        $filters = ['search' => $this->search];
        return view('livewire.brands.index', [
            'brands' => $service->index($filters)
        ]);
    }

    public function clearFilter(): void
    {
        $this->search = '';
    }
}

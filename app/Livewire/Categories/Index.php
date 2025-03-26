<?php

namespace App\Livewire\Categories;

use App\Services\CategoryService;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    protected $queryString = ['search' => ['except' => '']];

    public function render()
    {
        $service = new CategoryService();
        $filters = ['search' => $this->search];
        return view('livewire.categories.index', [
            'categories' => $service->index($filters)
        ]);
    }

    public function clearFilter(): void
    {
        $this->search = '';
    }
}

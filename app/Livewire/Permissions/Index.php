<?php

namespace App\Livewire\Permissions;

use App\Services\PermissionService;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    protected $queryString = ['search' => ['except' => '']];

    public function render()
    {
        $service = new PermissionService();
        $filters = ['search' => $this->search];
        return view('livewire.permissions.index', [
            'permissions' => $service->index($filters)
        ]);
    }

    public function clearFilter(): void
    {
        $this->search = '';
    }
}

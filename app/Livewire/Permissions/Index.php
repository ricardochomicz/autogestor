<?php

namespace App\Livewire\Permissions;

use App\Services\PermissionService;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public $selectedPermissions = [];

    protected $queryString = ['search' => ['except' => ''], 'page' => ['except' => 1]];

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

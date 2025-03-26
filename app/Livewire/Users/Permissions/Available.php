<?php

namespace App\Livewire\Users\Permissions;

use Livewire\Component;
use Livewire\WithPagination;

class Available extends Component
{
    use WithPagination;

    public $user;
    public string $search = '';

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function mount($user): void
    {
        $this->user = $user;
    }


    public function render()
    {
        $filters = [
            'search' => $this->search,
        ];
        return view('livewire.users.permissions.available', [
            'permissions' => $this->user->permissionsAvailable($filters),
        ]);
    }

    public function clearFilter(): void
    {
        $this->search = '';
    }
}

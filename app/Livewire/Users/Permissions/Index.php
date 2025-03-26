<?php

namespace App\Livewire\Users\Permissions;

use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected string $paginationTheme = 'bootstrap';

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


        return view('livewire.users.permissions.index', [
            'permissions' => $this->user->permissions()->filter($filters)->paginate(10),
        ]);
    }

    public function clearFilter(): void
    {
        $this->search = '';
    }
}

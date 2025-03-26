<?php

namespace App\Livewire\Users;

use App\Services\UserService;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function render()
    {
        $service = new UserService();
        $filters = [
            'search' => $this->search,
        ];
        return view('livewire.users.index', [
            'users' => $service->index($filters),
        ]);
    }
}

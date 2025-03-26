<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserService extends BaseService
{
    public function index(array $filters = [])
    {
        $user = Auth::user();

        return User::filter($filters)
            ->where(function ($query) use ($user) {
                if ($user->admin_id === null) {
                    // Se for admin, pode ver os subordinados
                    $query->where('admin_id', $user->id)
                        ->orWhere('id', $user->id); // Adiciona a verificação para o próprio admin
                } else {
                    // Se não for admin, só pode ver ele mesmo
                    $query->where('id', $user->id);
                }
            })
            ->paginate();
    }

    public function get(int $id)
    {
        $user = Auth::user();

        return User::where(function ($query) use ($user, $id) {
            if ($user->admin_id === null) {
                $query->where('admin_id', $user->id)
                    ->orWhere('id', $user->id);
            } else {
                $query->where('id', $user->id);
            }
        })
            ->where('id', $id)
            ->first();
    }

    public function store(array $data)
    {
        return $this->executeTransaction(function () use ($data) {
            $data['password'] = bcrypt($data['password']);
            $data['admin_id'] = Auth::id();
            $user = User::create($data);
            $user->roles()->attach('user');
            return $user;
        });
    }

    public function update(array $data, int $id)
    {
        return $this->executeTransaction(function () use ($data, $id) {
            $user = $this->get($id);
            $user->update($data);
            return $user;
        });
    }

    public function countUsers(): int
    {
        $user = Auth::user();

        return User::where(function ($query) use ($user) {
            if ($user->admin_id === null) {
                $query->where('admin_id', $user->id)
                    ->orWhere('id', $user->id);
            } else {
                $query->where('id', $user->id);
            }
        })
            ->count();
    }
}

<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserService extends BaseService
{
    public function index()
    {
        return User::paginate();
    }

    public function get(int $id)
    {
        return User::where(function ($query) {
            $query->where('admin_id', Auth::id())
                ->orWhereNull('admin_id'); // Permite usuários sem admin_id
        })
            ->where('id', $id)
            ->firstOrFail();
    }

    public function store(array $data)
    {
        return $this->executeTransaction(function () use ($data) {
            $data['password'] = bcrypt($data['password']);
            $data['admin_id'] = Auth::id();
            $user = User::create($data);
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
}

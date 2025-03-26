<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductService extends BaseService
{
    public function index(array $filters = [])
    {
        return Product::where('user_id', Auth::id())
            ->filter($filters)
            ->paginate();
    }

    public function get(int $id)
    {
        return Product::where('user_id', Auth::id())->find($id);
    }

    public function store(array $data)
    {
        return $this->executeTransaction(function () use ($data) {
            $data['user_id'] = Auth::id();
            $product = Product::create($data);
            return $product;
        });
    }

    public function update(array $data, int $id)
    {
        return $this->executeTransaction(function () use ($data, $id) {
            $product = $this->get($id);
            $product->update($data);
            return $product;
        });
    }

    public function destroy(int $id)
    {
        return $this->executeTransaction(function () use ($id) {
            $product = $this->get($id);
            $product->delete();
            return true;
        });
    }

    public function countProducts(): int
    {
        $user = Auth::user();

        return Product::where(function ($query) use ($user) {
            if ($user->admin_id === null) {
                // Se for administrador, exibe os registros dos subordinados e os próprios
                $query->where('user_id', $user->id)
                    ->orWhereIn('user_id', $user->users()->pluck('id'));
            } else {
                // Se não for administrador, exibe apenas os próprios registros
                $query->where('user_id', $user->id);
            }
        })->count();
    }
}

<?php

namespace App\Services;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Role;
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
            ->paginate(6);
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
            $role = Role::where('name', 'user')->first();
            if ($role) {
                $user->roles()->attach($role->id);
            }
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

    public function destroy(int $id)
    {
        return $this->executeTransaction(function () use ($id) {
            $user = $this->get($id);
            $user->delete();
            return true;
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

    public function showTransferPage(int $id)
    {
        return $this->executeTransaction(function () use ($id) {
            $user = $this->get($id);

            // Filtrar usuários que NÃO são administradores
            $users = User::where('id', '!=', $id)
                ->whereNotNull('admin_id')
                ->get();

            $brands = Brand::where('user_id', $id)->get();
            $categories = Category::where('user_id', $id)->get();
            $products = Product::where('user_id', $id)->get();

            return compact('user', 'users', 'brands', 'categories', 'products');
        });
    }

    public function transferDataAndDelete(int $id, array $brandTransfers, array $categoryTransfers, array $productTransfers)
    {
        return $this->executeTransaction(function () use ($id, $brandTransfers, $categoryTransfers, $productTransfers) {
            $user = User::findOrFail($id);

            // Transferir Brands
            foreach ($brandTransfers as $brandId => $newUserId) {
                $brand = Brand::where('user_id', $id)->find($brandId);
                if ($brand) {
                    $brand->update(['user_id' => $newUserId]);
                }
            }

            // Transferir Categories
            foreach ($categoryTransfers as $categoryId => $newUserId) {
                $category = Category::where('user_id', $id)->find($categoryId);
                if ($category) {
                    $category->update(['user_id' => $newUserId]);
                }
            }

            // Transferir Products
            foreach ($productTransfers as $productId => $newUserId) {
                $product = Product::where('user_id', $id)->find($productId);
                if ($product) {
                    $product->update(['user_id' => $newUserId]);
                }
            }

            // Excluir o usuário após a transferência
            $user->delete();
        });
    }
}

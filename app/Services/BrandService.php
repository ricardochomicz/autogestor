<?php

namespace App\Services;

use App\Models\Brand;
use Illuminate\Support\Facades\Auth;

class BrandService extends BaseService
{

    public function toSelect()
    {
        return Brand::where('user_id', Auth::id())
            ->orderBy('name')
            ->get(['id', 'name']);
    }

    public function index(array $filters = [])
    {
        return Brand::where('user_id', Auth::id())
            ->filter($filters)
            ->paginate(10);
    }

    public function get(int $id)
    {
        return Brand::where('user_id', Auth::id())->find($id);
    }

    public function store(array $data)
    {
        return $this->executeTransaction(function () use ($data) {
            $data['user_id'] = Auth::id();
            $brand = Brand::create($data);
            return $brand;
        });
    }

    public function update(array $data, int $id)
    {
        return $this->executeTransaction(function () use ($data, $id) {
            $brand = $this->get($id);
            $brand->update($data);
            return $brand;
        });
    }

    public function destroy(int $id)
    {
        return $this->executeTransaction(function () use ($id) {
            $brand = $this->get($id);
            $brand->delete();
            return true;
        });
    }

    public function countBrands(): int
    {
        $user = Auth::user();

        return Brand::where(function ($query) use ($user) {
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

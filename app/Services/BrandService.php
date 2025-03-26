<?php

namespace App\Services;

use App\Models\Brand;
use Illuminate\Support\Facades\Auth;

class BrandService extends BaseService
{

    public function index(array $filters = [])
    {
        return Brand::where('user_id', Auth::id())
            ->filter($filters)
            ->paginate();
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
}

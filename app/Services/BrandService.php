<?php

namespace App\Services;

use App\Models\Brand;

class BrandService extends BaseService
{

    public function index(array $filters = [])
    {
        return Brand::filter($filters)->paginate();
    }

    public function get(int $id)
    {
        return Brand::findOrFail($id);
    }

    public function store(array $data)
    {
        return $this->executeTransaction(function () use ($data) {
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

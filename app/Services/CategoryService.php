<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class CategoryService extends BaseService
{
    public function index(array $filters = [])
    {
        return Category::where('user_id', Auth::id())
            ->filter($filters)
            ->paginate();
    }

    public function get(int $id)
    {
        return Category::where('user_id', Auth::id())->find($id);
    }

    public function store(array $data)
    {
        return $this->executeTransaction(function () use ($data) {
            $data['user_id'] = Auth::id();
            $category = Category::create($data);
            return $category;
        });
    }

    public function update(array $data, int $id)
    {
        return $this->executeTransaction(function () use ($data, $id) {
            $category = $this->get($id);
            $category->update($data);
            return $category;
        });
    }

    public function destroy(int $id)
    {
        return $this->executeTransaction(function () use ($id) {
            $category = $this->get($id);
            $category->delete();
            return true;
        });
    }
}

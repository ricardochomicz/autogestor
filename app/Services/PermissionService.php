<?php

namespace App\Services;

use App\Models\Permission;

class PermissionService extends BaseService
{

    public function index(array $filters = [])
    {
        return Permission::filter($filters)
            ->paginate();
    }

    public function get(int $id)
    {
        return Permission::find($id);
    }

    public function store(array $data)
    {
        return $this->executeTransaction(function () use ($data) {
            $permission = Permission::create($data);
            return $permission;
        });
    }

    public function update(array $data, int $id)
    {
        return $this->executeTransaction(function () use ($data, $id) {
            $permission = $this->get($id);
            $permission->update($data);
            return $permission;
        });
    }
}

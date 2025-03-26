<?php

namespace App\Services;

use App\Models\Permission;

class PermissionService
{

    public function get(int $id)
    {
        return Permission::find($id);
    }
}

<?php

namespace App\Http\Controllers;

use App\Services\PermissionService;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserPermissionController
{
    public function __construct(
        protected UserService $userService,
        protected PermissionService $permissionService
    ) {}

    public function permissions($idUser)
    {
        if (!$user = $this->userService->get($idUser)) {
            flash()->option('position', 'bottom-center')->error('Usuário não encontrado.');
            return back();
        }

        $permissions = $user->permissions()->paginate();

        return view('pages.users.permissions.permissions', [
            'user' => $user,
            'permissions' => $permissions,
        ]);
    }

    public function create($idUser)
    {
        if (!$user = $this->userService->get($idUser)) {
            flash()->option('position', 'bottom-center')->warning('Usuário não encontrado.');
            return back();
        }
        return view('pages.users.permissions.create', compact('user'));
    }


    public function permissionsAvailable($idUser)
    {
        if (!$user = $this->userService->get($idUser)) {
            flash()->option('position', 'bottom-center')->warning('Usuário não encontrado.');
            return back();
        }

        $permissions = $user->permissionsAvailable();

        return view('pages.users.permissions.available', compact('user', 'permissions'));
    }


    public function attachUserPermission(Request $request, $idUser)
    {
        if (!$user = $this->userService->get($idUser)) {
            flash()->option('position', 'bottom-center')->warning('Usuário não encontrado.');
            return back();
        }

        if (!$request->permissions || count($request->permissions) == 0) {
            flash()->option('position', 'bottom-center')->warning('Você precisa selecionar ao menos uma permissão para concluir.');
            return back();
        }

        $user->permissions()->attach($request->permissions);

        flash()->option('position', 'bottom-center')->success('Permissão vinculada com sucesso.');

        return redirect()->route('user.permissions', ['id' => $idUser]);
    }



    public function detachUserPermission($idUser, $idPermission)
    {
        $user = $this->userService->get($idUser);
        $permission = $this->permissionService->get($idPermission);

        if (!$user || !$permission) {
            flash()->option('position', 'bottom-center')->warning('Nenhum registro encontrado.');
            return back();
        }

        $detach = $user->permissions()->detach($permission);

        flash()->option('position', 'bottom-center')->success('Permissão desvinculada com sucesso.');

        return redirect()->route('user.permissions', ['id' => $idUser]);
    }
}

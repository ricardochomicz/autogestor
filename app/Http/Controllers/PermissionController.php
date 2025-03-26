<?php

namespace App\Http\Controllers;

use App\Services\PermissionService;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function __construct(
        protected PermissionService $permissionService
    ) {}

    public function index()
    {
        $view = [];
        return view('pages.permissions.index', $view);
    }

    public function create()
    {
        return view('pages.permissions.create');
    }

    public function edit(int $id)
    {
        try {
            if (!$permission = $this->permissionService->get($id)) {
                flash()->option('position', 'bottom-center')->error('Permissão não encontrada');
                return redirect()->route('permissions.index');
            }

            return view('pages.permissions.edit', compact('permission'));
        } catch (\Throwable $th) {
            //throw $th;
            flash()->option('position', 'bottom-center')->error('Erro ao buscar permissão' . $th->getMessage());
        }
    }

    public function store(Request $request)
    {
        $data = $request->except(['_token', '_method']);
        try {
            $this->permissionService->store($data);
            flash()->option('position', 'bottom-center')->success('Permissão criada com sucesso');
            return redirect()->route('permissions.index');
        } catch (\Throwable $th) {
            //throw $th;
            flash()->option('position', 'bottom-center')->error('Erro ao criar permissão' . $th->getMessage());
            return back();
        }
    }

    public function update(Request $request, int $id)
    {
        $data = $request->except(['_token', '_method']);
        try {
            $this->permissionService->update($data, $id);
            flash()->option('position', 'bottom-center')->success('Permissão atualizada com sucesso');
            return redirect()->route('permissions.index');
        } catch (\Throwable $th) {
            //throw $th;
            flash()->option('position', 'bottom-center')->error('Erro ao atualizar permissão' . $th->getMessage());
            return back();
        }
    }
}

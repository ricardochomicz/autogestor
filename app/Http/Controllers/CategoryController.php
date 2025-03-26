<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(
        protected CategoryService $categoryService
    ) {}

    public function index()
    {
        $view = [];
        return view('pages.categories.index', $view);
    }

    public function create()
    {
        return view('pages.categories.create');
    }

    public function edit(int $id)
    {
        try {
            if (!$category = $this->categoryService->get($id)) {
                flash()->option('position', 'bottom-center')->error('Categoria não encontrada');
                return redirect()->route('categories.index');
            }

            return view('pages.categories.edit', compact('category'));
        } catch (\Throwable $th) {
            //throw $th;
            flash()->option('position', 'bottom-center')->error('Erro ao buscar categoria' . $th->getMessage());
        }
    }

    public function store(Request $request)
    {
        $data = $request->except(['_token', '_method']);
        try {
            $this->categoryService->store($data);
            flash()->option('position', 'bottom-center')->success('Categoria criada com sucesso');
            return redirect()->route('categories.index');
        } catch (\Throwable $th) {
            //throw $th;
            flash()->option('position', 'bottom-center')->error('Erro ao criar categoria' . $th->getMessage());
            return back();
        }
    }

    public function update(Request $request, int $id)
    {
        $data = $request->except(['_token', '_method']);
        try {
            $this->categoryService->update($data, $id);
            flash()->option('position', 'bottom-center')->success('Categoria atualizada com sucesso');
            return redirect()->route('categories.index');
        } catch (\Throwable $th) {
            //throw $th;
            flash()->option('position', 'bottom-center')->error('Erro ao atualizar categoria' . $th->getMessage());
            return back();
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->categoryService->destroy($id);
            flash()->option('position', 'bottom-center')->success('Categoria excluida com sucesso');
            return redirect()->route('categories.index');
        } catch (\Throwable $th) {
            //throw $th;
            flash()->option('position', 'bottom-center')->error('Erro ao excluir categoria' . $th->getMessage());
            return back();
        }
    }
}

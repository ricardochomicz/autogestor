<?php

namespace App\Http\Controllers;

use App\Services\BrandService;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function __construct(
        protected BrandService $brandService
    ) {}

    public function index()
    {
        $view = [];
        return view('pages.brands.index', $view);
    }

    public function create()
    {
        return view('pages.brands.create');
    }

    public function edit(int $id)
    {
        try {
            $brand = $this->brandService->get($id);
            return view('pages.brands.edit', compact('brand'));
        } catch (\Throwable $th) {
            //throw $th;
            flash()->option('position', 'bottom-center')->error('Erro ao buscar marca' . $th->getMessage());
        }
    }

    public function store(Request $request)
    {
        $data = $request->except(['_token', '_method']);
        try {
            $this->brandService->store($data);
            flash()->option('position', 'bottom-center')->success('Marca criada com sucesso');
            return redirect()->route('brands.index');
        } catch (\Throwable $th) {
            //throw $th;
            flash()->option('position', 'bottom-center')->error('Erro ao criar marca' . $th->getMessage());
            return back();
        }
    }

    public function update(Request $request, int $id)
    {
        $data = $request->except(['_token', '_method']);
        try {
            $this->brandService->update($data, $id);
            flash()->option('position', 'bottom-center')->success('Marca atualizada com sucesso');
            return redirect()->route('brands.index');
        } catch (\Throwable $th) {
            //throw $th;
            flash()->option('position', 'bottom-center')->error('Erro ao atualizar marca' . $th->getMessage());
            return back();
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->brandService->destroy($id);
            flash()->option('position', 'bottom-center')->success('Marca excluida com sucesso');
            return redirect()->route('brands.index');
        } catch (\Throwable $th) {
            //throw $th;
            flash()->option('position', 'bottom-center')->error('Erro ao excluir marca' . $th->getMessage());
            return back();
        }
    }
}

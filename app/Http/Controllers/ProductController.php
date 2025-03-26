<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $productService
    ) {}

    public function index()
    {
        $view = [];
        return view('pages.products.index', $view);
    }

    public function create()
    {
        return view('pages.products.create');
    }

    public function edit(int $id)
    {
        try {
            if (!$product = $this->productService->get($id)) {
                flash()->option('position', 'bottom-center')->error('Produto não encontrado.');
                return redirect()->route('products.index');
            }

            return view('pages.products.edit', compact('product'));
        } catch (\Throwable $th) {
            //throw $th;
            flash()->option('position', 'bottom-center')->error('Erro ao buscar produto' . $th->getMessage());
        }
    }

    public function store(Request $request)
    {
        $data = $request->except(['_token', '_method']);
        try {
            $this->productService->store($data);
            flash()->option('position', 'bottom-center')->success('Produto criado com sucesso');
            return redirect()->route('products.index');
        } catch (\Throwable $th) {
            //throw $th;
            flash()->option('position', 'bottom-center')->error('Erro ao criar produto' . $th->getMessage());
            return back();
        }
    }

    public function update(Request $request, int $id)
    {
        $data = $request->except(['_token', '_method']);
        try {
            $this->productService->update($data, $id);
            flash()->option('position', 'bottom-center')->success('Produto atualizado com sucesso');
            return redirect()->route('products.index');
        } catch (\Throwable $th) {
            //throw $th;
            flash()->option('position', 'bottom-center')->error('Erro ao atualizar produto' . $th->getMessage());
            return back();
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->productService->destroy($id);
            flash()->option('position', 'bottom-center')->success('Produto excluido com sucesso');
            return redirect()->route('products.index');
        } catch (\Throwable $th) {
            //throw $th;
            flash()->option('position', 'bottom-center')->error('Erro ao excluir produto' . $th->getMessage());
            return back();
        }
    }
}

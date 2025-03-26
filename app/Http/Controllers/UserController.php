<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        protected UserService $userService
    ) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = $this->userService->index();
        return view('pages.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.users.create', [
            'isEdit' => false,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        try {
            $this->userService->store($request->validated());
            flash()->option('position', 'bottom-center')->success('Usuário criado com sucesso');
            return redirect()->route('users.index');
        } catch (\Throwable $th) {
            //throw $th;
            flash()->option('position', 'bottom-center')->error('Erro ao criar usuário' . $th->getMessage());
            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $user = $this->userService->get($id);
        if (!$user) {
            flash()->option('position', 'bottom-center')->error('Usuário não encontrado');
            return redirect()->route('users.index');
        }
        return view('pages.users.edit', [
            'user' => $user,
            'isEdit' => true,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, int $id)
    {
        try {
            $data = $request->validated();
            $user = $this->userService->update($data, $id);
            flash()->option('position', 'bottom-center')->success('Usuário atualizado com sucesso');
            return redirect()->route('users.index');
        } catch (\Throwable $th) {
            //throw $th;
            flash()->option('position', 'bottom-center')->error('Erro ao atualizar usuário' . $th->getMessage());
            return back();
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->userService->destroy($id);
            flash()->option('position', 'bottom-center')->success('Usuário excluido com sucesso');
            return redirect()->route('users.index');
        } catch (\Throwable $th) {
            //throw $th;
            flash()->option('position', 'bottom-center')->error('Erro ao excluir usuário' . $th->getMessage());
            return back();
        }
    }

    public function showTransferPage($id)
    {
        $data = $this->userService->showTransferPage($id);
        return view('pages.users.transfer', $data);
    }

    public function transferDataAndDelete(Request $request, int $id)
    {
        $this->userService->transferDataAndDelete(
            $id,
            $request->input('brands', []),
            $request->input('categories', []),
            $request->input('products', [])
        );

        return redirect()->route('users.index')->with('success', 'Dados transferidos e usuário excluído.');
    }
}

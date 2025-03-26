@extends('adminlte::page')

@section('title', 'Transferência de Permissões')

@section('content_header')

@stop

@section('content')
    <form action="{{ route('users.transferData', @$user->id) }}" method="POST">
        @csrf
        <h3 class="mt-3">Transferir Registros de {{ @$user->name }}</h3>

        <div class="row mt-3">
            <div class="col-md-6">

                <h4>Marcas</h4>
                <ul class="list-group">
                    @foreach ($brands as $brand)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $brand->name }}
                            <span class=" text-bg-primary rounded-pill">
                                <select name="brands[{{ $brand->id }}]" class="form-control">
                                    @foreach ($users as $newUser)
                                        <option value="{{ $newUser->id }}">{{ $newUser->name }}</option>
                                    @endforeach
                                </select>
                            </span>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-6">
                <h4>Categorias</h4>
                <ul class="list-group">
                    @foreach ($categories as $category)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $category->name }}
                            <span class=" text-bg-primary rounded-pill">
                                <select name="categories[{{ $category->id }}]" class="form-control">
                                    @foreach ($users as $newUser)
                                        <option value="{{ $newUser->id }}">{{ $newUser->name }}</option>
                                    @endforeach
                                </select>
                            </span>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-6">
                <h4 class="mt-3">Produtos</h4>
                <ul class="list-group">
                    @foreach ($products as $product)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $product->name }}
                            <span class=" text-bg-primary rounded-pill">
                                <select name="products[{{ $product->id }}]" class="form-control">
                                    @foreach ($users as $newUser)
                                        <option value="{{ $newUser->id }}">{{ $newUser->name }}</option>
                                    @endforeach
                                </select>
                            </span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-5">Transferir e Excluir Usuário</button>
    </form>

@stop

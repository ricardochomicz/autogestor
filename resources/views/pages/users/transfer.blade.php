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
                            <span class=" text-bg-primary rounded-pill brand-transfer">
                                <select name="brands[{{ $brand->id }}]" class="form-control">
                                    <option value="">Selecione</option>
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
                            <span class=" text-bg-primary rounded-pill category-transfer">
                                <select name="categories[{{ $category->id }}]" class="form-control">
                                    <option value="">Selecione</option>
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
                            <span class=" text-bg-primary rounded-pill product-transfer">
                                <select name="products[{{ $product->id }}]" class="form-control">
                                    <option value="">Selecione</option>
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

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function addBulkTransferListener(section, message) {
                let firstSelect = document.querySelector(`.${section} select`);
                if (!firstSelect) return;

                firstSelect.addEventListener("change", function() {
                    let selectedUser = this.value;
                    if (!selectedUser) return;

                    if (confirm(message)) {
                        document.querySelectorAll(`.${section} select`).forEach(select => {
                            select.value = selectedUser;
                        });
                    }
                });
            }

            addBulkTransferListener("product-transfer", "Deseja transferir todos os produtos para este usuário?");
            addBulkTransferListener("brand-transfer", "Deseja transferir todas as marcas para este usuário?");
            addBulkTransferListener("category-transfer",
                "Deseja transferir todas as categorias para este usuário?");
        });
    </script>
@endpush

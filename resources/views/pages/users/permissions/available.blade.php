@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Permissões Disponíveis</h1>
@stop

@section('content')

    <div class="card">
        <div class="card-header">
            <div class="card-tools">
                Selecionar todos
                <label class="switch mr-2">
                    <input type="checkbox" class="default module-checkbox" id="select-all-checkbox">
                    <span class="slider round"></span>
                </label>
            </div>
        </div>
        <div class="card-body">
            <h6><i class="fas fa-filter"></i> Filtros</h6>
            <div class="row">
                <form action="{{ route('user.permissions.search') }}">
                    <div class="form-group col-sm-6 has-search">
                        <input class="form-control" name="search" placeholder="pesquisa por nome...">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-secondary">Buscar</button>
                    </div>
                </form>
            </div>
            <div class="small-box shadow-none">

                <div class="table-responsive rounded">

                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th width="15%"></th>
                                @if (count($permissions))
                                    <th>Permissão</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            <form action="{{ route('user.permissions.attach', $user->id) }}" method="POST">
                                @csrf
                                @forelse($permissions as $p)
                                    <tr>
                                        <td class="text-center">
                                            <label class="switch ">
                                                <input type="checkbox" class="primary module-checkbox" name="permissions[]"
                                                    value="{{ $p->id }}">
                                                <span class="slider round"></span>
                                            </label>
                                        </td>
                                        <td>{{ $p->label }}</td>


                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-danger">Nenhuma permissão
                                            disponível</td>
                                    </tr>
                                @endforelse
                                <tr>
                                    <td colspan="2">
                                        @if (count($permissions))
                                            <button class="btn btn-primary"><i class="fas fa-link mr-1"></i>
                                                Vincular</button>
                                        @endif
                                        <a href="{{ route('user.permissions', $user->id) }}" class="btn btn-secondary"><i
                                                class="fas fa-angle-left mr-1"></i> Voltar</a>
                                    </td>
                                </tr>
                            </form>
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        {{ $permissions->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Obtem o checkbox "Selecionar Todos"
            var selectAllCheckbox = document.getElementById('select-all-checkbox');

            // Obtem todos os outros checkboxes
            var moduleCheckboxes = document.querySelectorAll('.module-checkbox');

            // Adiciona um evento de clique ao checkbox "Selecionar Todos"
            selectAllCheckbox.addEventListener('click', function() {
                // Verifique se o checkbox "Selecionar Todos" está marcado
                var isChecked = selectAllCheckbox.checked;

                // Atualiza o estado de todos os outros checkboxes
                moduleCheckboxes.forEach(function(checkbox) {
                    checkbox.checked = isChecked;
                });
            });
        });
    </script>
@endpush

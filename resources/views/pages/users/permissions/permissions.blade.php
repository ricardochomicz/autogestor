@extends('adminlte::page')

@section('title', 'Lista de Permissões do Usuário')

@section('content_header')
    <h3>Lista de Permissões do Usuário - <b>{{ $user->name }}</b></h3>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('users.index') }}" class="btn btn-info">Voltar</a>
            <a href="{{ route('user.permissions.available', $user->id) }}" class="btn btn-default">Permissões Disponíveis</a>
        </div>
        <div class="card-body">
            <table class="table table-borderless">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th class="text-center">...</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($permissions as $permission)
                        <tr>
                            <td>{{ $permission->id }}</td>
                            <td>{{ $permission->label }}</td>
                            <td class="text-center">
                                <a href="{{ route('user.permissions.detach', [$user->id, $permission->id]) }}"
                                    class="btn btn-sm btn-danger"><i class="fas fa-unlink mr-2"></i> Desvincular</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

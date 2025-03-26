@extends('adminlte::page')

@section('title', 'Usuários')

@section('content_header')
    <h1>Usuários</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('users.create') }}" class="btn btn-primary">Novo Usuário</a>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Papel</th>
                        <th>Criado em</th>
                        <th class="text-center">...</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td class="align-middle">{{ $user->id }}</td>
                            <td class="align-middle">{{ $user->name }}</td>
                            <td class="align-middle">{{ $user->email }}</td>
                            <td class="align-middle">
                                @foreach ($user->roles as $role)
                                    {{ $role->name }}{{ !$loop->last ? ', ' : '' }}
                                @endforeach
                            </td>
                            <td class="align-middle">{{ $user->created_at->diffForHumans() }}</td>
                            <td class="align-middle text-center">
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-primary">Editar</a>
                                <a href="{{ route('user.permissions', $user->id) }}"
                                    class="btn btn-sm btn-info">Permissões</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">Nenhum registro encontrado</td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>
@stop

@extends('adminlte::page')

@section('title', 'Lista de Permissões do Usuário')

@section('content_header')
    <h3>Lista de Permissões do Usuário - <b>{{ $user->name }}</b></h3>
@stop

@section('content')

    <livewire:users.permissions.index :user="$user" :permissions="$permissions" />

@stop

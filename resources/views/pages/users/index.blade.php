@extends('adminlte::page')

@section('title', 'Usuários')

@section('content_header')
    <h1>Usuários</h1>
@stop

@section('content')
    <livewire:users.index />
    <x-modal-confirm title="Usuário" />
@stop

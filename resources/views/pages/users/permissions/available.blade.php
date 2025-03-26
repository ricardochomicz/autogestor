@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Permissões Disponíveis</h1>
@stop

@section('content')
    <livewire:users.permissions.available :user="$user" :permissions="$permissions" />
@stop

@extends('adminlte::page')

@section('title', 'Permissões')

@section('content_header')
    <h1>Permissões</h1>
@stop

@section('content')
    <livewire:permissions.index />
@stop

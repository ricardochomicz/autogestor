@extends('adminlte::page')

@section('title', 'Categorias')

@section('content_header')
    <h1>Categorias</h1>
@stop

@section('content')
    <livewire:categories.index />

    <x-modal-confirm title="Categoria" msg_destroy="Essa ação não pode ser desfeita." />
@stop

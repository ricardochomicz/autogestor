@extends('adminlte::page')

@section('title', 'Produtos')

@section('content_header')
    <h1>Produtos</h1>
@stop

@section('content')
    <livewire:products.index />

    <x-modal-confirm title="Produto" msg_destroy="Essa ação não pode ser desfeita." />
@stop

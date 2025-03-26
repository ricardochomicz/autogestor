@extends('adminlte::page')

@section('title', 'Marcas')

@section('content_header')
    <h1>Marcas</h1>
@stop

@section('content')
    <livewire:brands.index />

    <x-modal-confirm title="Marca" />
@stop

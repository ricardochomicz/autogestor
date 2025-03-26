@extends('adminlte::page')

@section('title', 'Editar Produto')

@section('content_header')
    <h1>Editar Produto</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('products.update', $product->id) }}" method="post">
                @csrf
                @method('PUT')
                @include('pages.products._partials.form')
            </form>
        </div>
    </div>

@stop

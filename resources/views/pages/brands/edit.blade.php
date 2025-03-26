@extends('adminlte::page')

@section('title', 'Editar Marca')

@section('content_header')
    <h1>Editar Marca</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('brands.update', $brand->id) }}" method="post">
                @csrf
                @method('PUT')
                @include('pages.brands._partials.form')
            </form>
        </div>
    </div>

@stop

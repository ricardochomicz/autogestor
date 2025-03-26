@extends('adminlte::page')

@section('title', 'Nova Marca')

@section('content_header')
    <h1>Nova Marca</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('brands.store') }}" method="post">
                @csrf
                @include('pages.brands._partials.form')
            </form>
        </div>
    </div>

@stop

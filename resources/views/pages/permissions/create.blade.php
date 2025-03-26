@extends('adminlte::page')

@section('title', 'Nova Permissão')

@section('content_header')
    <h1>Nova Permissão</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('permissions.store') }}" method="post">
                @csrf
                @include('pages.permissions._partials.form')
            </form>
        </div>
    </div>

@stop

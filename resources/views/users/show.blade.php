@extends('layouts.app')
@section('title', 'Detalhes do Usuário')
@section('content')

    <h1>{{ $user->name }}</h1>
    <p>Email: {{ $user->email }}</p>
    <p>CPF: {{ $user->cpf }}</p>

    <a href="{{ route('users.edit', $user->id) }}">Editar</a>
    <a href="{{ route('users.index') }}">Voltar</a>

@endsection
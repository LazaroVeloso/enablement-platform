@extends('layouts.app')

@section('title', 'Creation')

@section('content')

    <h1>Criação de Usuarios</h1>

    <form action="{{ route('users.store') }}" method="POST">
    @csrf

    <div>
        <label for="nome">Nome</label>
        <input type="text" id="nome" name="nome" required>
    </div>

    <div>
        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" required>
    </div>

    <div>
        <label for="password">Password</label>
        <input type="text" id="password" name="password" required>
    </div>

    <div>
        <label for="cpf">cpf</label>
        <input type="text" id="cpf" name="cpf" required>
    </div>
    <div>
        <label for="tipos_id">Tipo</label>
        <input type="number" id="tipos_id" name="tipos_id" required>
    </div>


    <button type="submit">Enviar</button>
    <a href="{{ route('users.index') }}">Cancelar</a>
    <a href="{{ route('users.index') }}">Voltar</a>
    </form>


@endsection
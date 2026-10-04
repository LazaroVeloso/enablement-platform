@extends('layouts.app')
@section('title', 'Editar Usuário')
@section('content')

<form action="{{ route('users.update', $user->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div>
        <label for="name">Nome</label>
        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required>
       
        @error('name')
            <span>{{ $message }}</span>
        @enderror
        
    </div>

    <div>
        <label for="email">E-mail</label>
        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required>
        @error('email') <span>{{ $message }}</span> @enderror
    </div>

    <div>
        <label for="cpf">CPF</label>
        <input type="text" name="cpf" id="cpf" value="{{ old('cpf', $user->cpf) }}" required>
        @error('cpf') <span>{{ $message }}</span> @enderror
    </div>


    <button type="submit">Salvar alterações</button>
    <a href="{{ route('users.index') }}">Cancelar</a>
    <a href="{{ route('users.index') }}">Voltar</a>
</form>

@endsection



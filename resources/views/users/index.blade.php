@extends('layouts.app')

@section('title', 'Listagem')

@section('content')
    <div class="flex flex-col">
        <h1>Listagem de Usuarios</h1>
        <a href="{{ route('users.create') }}">
                <button>+</button>
        </a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">nome</th>
                <th scope="col">email</th>
                <th scope="col">password</th>
                <th scope="col">cpf</th>
                <th scope="col">tipo</th>
            </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{$user->id}}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>      
                <td>{{$user->password}}</td>            
                <td>{{$user->cpf}}</td>            
                <td>{{$user->tipo}}</td>            
                <td>
                    
                    <a href="{{ route('users.show', $user->id) }}">Ver</a>
                    <a href="{{ route('users.edit', $user->id) }}">Editar</a>
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Excluir</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection
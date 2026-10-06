@extends('layouts.app')

@section('title', 'Listagem')

@section('content')
    <div class="flex flex-col">
        <h1>Listagem de Conetudos</h1>
        <a href="{{ route('conteudos.create') }}">
                <button>+</button>
        </a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">link</th>
                <th scope="col">nome</th>
                <th scope="col">sequencia</th>
                <th scope="col">descricao</th>
                <th scope="col"></th>

            </tr>
        </thead>
        <tbody>
        @foreach($conteudos as $conteudo)
            <tr>
                <td>{{$conteudo->id}}</td>
                <td>{{$conteudo->link}}</td>
                <td>{{$conteudo->nome}}</td>
                <td>{{$conteudo->sequencia}}</td>      
                <td>{{$conteudo->descricao}}</td>            
                <td>
                    
                    <a href="{{ route('conteudos.show', $conteudo->id) }}">Ver</a>
                    <a href="{{ route('conteudos.edit', $conteudo->id) }}">Editar</a>
                    <form action="{{ route('conteudos.destroy', $conteudo->id) }}" method="POST">
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
@extends('layouts.app')

@section('title', 'Listagem')

@section('content')
    <div class="flex flex-col">
        <h1>Listagem de Trilhas</h1>
        <a href="{{ route('trilhas.create') }}">
                <button>+</button>
        </a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">titulo</th>
                <th scope="col">descrição</th>
                <th scope="col">data_inicio</th>
                <th scope="col">data_fim</th>
                <th scope="col">ativo</th>
                <th scope="col">responsavel</th>
                <th scope="col"></th>

            </tr>
        </thead>
        <tbody>
        @foreach($trilhas as $trilha)
            <tr>
                <td>{{$trilha->id}}</td>
                <td>{{$trilha->titulo}}</td>
                <td>{{$trilha->description}}</td>      
                <td>{{$trilha->data_inicio}}</td>            
                <td>{{$trilha->data_fim}}</td>
                <td>
                    @if($trilha->ativo)
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="size-6" color="green">
                            <path strokeLinecap="round" strokeLinejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="size-6" color="red">
                            <path strokeLinecap="round" strokeLinejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636" />
                        </svg>
                    @endif
                </td>
                <td>{{$trilha->responsavel->name}}</td>

                <td>
                    
                    <a href="{{ route('trilhas.show', $trilha->id) }}">Ver</a>
                    <a href="{{ route('trilhas.edit', $trilha->id) }}">Editar</a>
                    <form action="{{ route('trilhas.destroy', $trilha->id) }}" method="POST">
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
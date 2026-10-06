@extends('layouts.app')

@section('title', 'Creation')

@section('content')

    <h1>Criação de Conteúdos</h1>

    <form action="{{ route('conteudos.store') }}" method="POST">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       @csrf

    <div>
        <label for="nome">Titulo</label>
        <input type="text" id="nome" name="nome" required>
    </div>

    <div>
        <label for="descricao">Descrição</label>
        <input type="text" id="descricao" name="descricao" required>
    </div>

    <div>
        <label for="link">Link</label>
        <input type="text" id="link" name="link">
    </div>

    <div>
        <label for="trilhas_id">Trilha</label>
        <select id="trilhas_id" name="trilhas_id" required>
            @foreach($trilhas as $trilha)
                <option value="{{ $trilha->id }}">{{ $trilha->titulo }}</option>
            @endforeach
        </select>
    </div>


    <div>
        <label for="sequencia">Sequencia</label>
        <input type="number" id="sequencia" name="sequencia">
    </div>

    <div>
        <label for="formato">Formato</label>
        <input type="text" id="formato" name="formato">
    </div>


    <button type="submit">Enviar</button>
    <a href="{{ route('conteudos.index') }}">Cancelar</a>
    <a href="{{ route('conteudos.index') }}">Voltar</a>
    </form>


@endsection
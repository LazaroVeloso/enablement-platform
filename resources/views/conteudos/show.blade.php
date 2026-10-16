@extends('layouts.app')
@section('title', 'Detalhes de Conteúdos')
@section('content')

    <h1>{{ $conteudo->nome }}</h1>
    <p>Descrição: {{ $conteudo->descricao }}</p>
    <iframe 
        width="560" height="315" src="{{ $conteudo->link }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
    </iframe>
    <p>Sequencia: {{ $conteudo->sequencia }}</p>
    <p>Formato: {{ $conteudo->formato }}</p>
    <p>Trilha: {{ $conteudo->trilhas_id }}</p>


    <a href="{{ route('conteudos.edit', $conteudo->id) }}">Editar</a>
    <button onclick="history.back()">Voltar</button>

@endsection
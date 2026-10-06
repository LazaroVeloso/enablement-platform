@extends('layouts.app')
@section('title', 'Detalhes de Conteúdos')
@section('content')

    <h1>{{ $conteudo->nome }}</h1>
    <p>Descrição: {{ $conteudo->descricao }}</p>
    <p>Link: {{ $conteudo->link }}</p>
    <p>Sequencia: {{ $conteudo->sequencia }}</p>
    <p>Formato: {{ $conteudo->formato }}</p>
    <p>Trilha: {{ $conteudo->trilhas_id }}</p>


    <a href="{{ route('conteudos.edit', $conteudo->id) }}">Editar</a>
    <a href="{{ route('conteudos.index') }}">Voltar</a>

@endsection
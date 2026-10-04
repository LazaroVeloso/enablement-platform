@extends('layouts.app')
@section('title', 'Detalhes de Trilhas')
@section('content')

    <h1>{{ $trilha->titulo }}</h1>
    <p>Descrição: {{ $trilha->description }}</p>
    <p>Data início: {{ $trilha->data_inicio }}</p>
    <p>Data fim: {{ $trilha->data_fim }}</p>
    <p>Ativo: 
        @if($trilha->ativo)
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="size-6" width="18" height="18" color="green">
                <path strokeLinecap="round" strokeLinejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
        @else
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="size-6" width="18" height="18" color="red">
                <path strokeLinecap="round" strokeLinejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636" />
            </svg>
        @endif
    </p>
    <p>Responsavel: {{ $trilha->responsavel->name }}</p>

    <a href="{{ route('trilhas.edit', $trilha->id) }}">Editar</a>
    <a href="{{ route('trilhas.index') }}">Voltar</a>

@endsection
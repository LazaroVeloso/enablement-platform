@extends('layouts.app')
@section('title', 'Detalhes de Conteúdos')
@section('content')


    


<div class="min-h-screen bg-slate-300">   
    <a  class="inline-block mt-10 ml-4 border-2 hover:text-white hover:bg-black" href="{{ route('trilhas.show', $trilha_id) }}">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="m18.75 4.5-7.5 7.5 7.5 7.5m-6-15L5.25 12l7.5 7.5" />
        </svg>
    </a>

    <div  class=" mt-10 mx-auto flex w-150 flex-col justify-center bg-white rounded-2xl shadow-xl shadow-slate-300/60">
            <div class="flex justify-center w-full relative">
                <iframe 
                   class="mt-13" width="560" height="315" src="{{ $conteudo->link }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
                </iframe>
                <a href="{{ route('conteudos.edit', $conteudo->id) }}" class="absolute top-2 right-2 h-8 w-8 flex items-center justify-center bg-gray-400 hover:bg-yellow-500 border-2 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                    </svg>
                </a>
            </div>
            <!-- text information -->
            <div class="p-4">
                <small class="block text-xs font-semibold text-gray-600 uppercase mt-3">{{ $conteudo->nome }}</small>
                <h1 class="text-2xl font-medium text-slate-600 pb-2">{{ $conteudo->descricao }}</h1>
                <p class="text-sm tracking-tight font-light text-slate-400 leading-6">Sequencia: {{ $conteudo->sequencia }}</p>
                <p class="text-sm tracking-tight font-light text-slate-400 leading-6">Formato: {{ $conteudo->formato }}</p>
                <p class="text-sm tracking-tight font-light text-slate-400 leading-6">Trilha: {{ $conteudo->trilhas_id }}</p>
            </div>
        </div>
    </div>

</div>

@endsection
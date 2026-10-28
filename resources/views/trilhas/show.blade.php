@extends('layouts.app')
@section('title', 'Detalhes de Trilhas')
@section('content')

<div class="bg-gray-400 h-dvh px-15">
    <button class=" mt-4 ml-4 border-2 hover:text-white hover:bg-black" onclick="history.back()">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="m18.75 4.5-7.5 7.5 7.5 7.5m-6-15L5.25 12l7.5 7.5" />
        </svg>
    </button>

    <div class="flex">
        <h1 class="text-[54px] font-extrabold">{{ $trilha->titulo }}</h1>
        <a class="border-2 bg-gray-400 hover:bg-yellow-500 w-15 h-8 rounded-3xl text-center my-8 ml-2" href="{{ route('trilhas.edit', $trilha->id) }}">Editar</a>

    </div>

    <div class="flex flex-col gap-4">

        <div class="w-3xl border-2 p-2 bg-[#87CEFA]">
            <p>{{ $trilha->description }}</p>  
        </div>

        <div class="flex gap-4">
            <div class="border-2 p-2 bg-[#87CEFA]">
                <p>Data início: {{ $trilha->data_inicio }}</p>
                <p>Data fim: {{ $trilha->data_fim }}</p>
            </div>
            
            <div class="border-2 p-2 bg-[#87CEFA]">
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
            </div>
            <div class="border-2 p-2 bg-[#87CEFA]">
                <p>Responsavel: {{ $trilha->responsavel->name }}</p>
            </div>
        </div>

        
        <div class="border-2 p-2 bg-[#87CEFA]">
            <h2 class="font-medium text-2xl text-black">Conteúdos</h2>
            @foreach ($trilha->possuiConteudos as $conteudo)
                <div class="relative flex w-96 flex-col rounded-xl bg-white bg-clip-border text-gray-700 shadow-md m-4">
                    <div class="relative mx-4 -mt-4 h-56 overflow-hidden rounded-xl bg-blue-gray-500 bg-clip-border text-white shadow-lg shadow-blue-gray-500/40">
                        <img
                        src="https://images.unsplash.com/photo-1540553016722-983e48a2cd10?ixlib=rb-1.2.1&amp;ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&amp;auto=format&amp;fit=crop&amp;w=800&amp;q=80"
                        alt="img-blur-shadow"
                        layout="fill" class="mt-8"
                        />
                    </div>
                    <div class="p-6">
                        <h5 class="mb-2 block font-sans text-xl font-semibold leading-snug tracking-normal text-blue-gray-900 antialiased">
                        {{ $conteudo->nome }}
                        </h5>
                        <p class="block font-sans text-base font-light leading-relaxed text-inherit antialiased">
                            {{ $conteudo->descricao }}
                        </p>
                    </div>
                    <div class="p-6 pt-0">
                        <a href="{{ route('conteudos.show', $conteudo->id) }}"
                        class="select-none rounded-lg bg-pink-500 py-3 px-6 text-center align-middle font-sans text-xs font-bold uppercase text-white shadow-md shadow-pink-500/20 transition-all hover:shadow-lg hover:shadow-pink-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                        type="button"
                        data-ripple-light="true"
                        >
                            Ver
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</div>


@endsection
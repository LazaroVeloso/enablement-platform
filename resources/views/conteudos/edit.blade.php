@extends('layouts.app')
@section('title', 'Editar Conteúdo')
@section('content')




<div>
    <a class="inline-block mt-10 ml-4 border-2 hover:text-white hover:bg-black" href="{{ route('trilhas.index') }}">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="m18.75 4.5-7.5 7.5 7.5 7.5m-6-15L5.25 12l7.5 7.5" />
        </svg>
    </a>

<div class="grid min-h-screen place-items-center">
    <div class="w-11/12 p-12 bg-white sm:w-8/12 md:w-1/2 lg:w-5/12">
        <h1 class="text-xl font-semibold">Editar conteúdo? <span class="font-normal">preencha os dados</span></h1>
        <form action="{{ route('conteudos.update', $conteudo->id) }}" method="POST">
        @csrf
        @method('PUT')

            <label for="nome" class="block text-xs font-semibold text-gray-600 uppercase">Título</label>
            <input id="nome" type="text" name="nome" value="{{ old('nome', $conteudo->nome) }}" class="block w-full p-3 mt-2 text-gray-700 bg-gray-200 appearance-none focus:outline-none focus:bg-gray-300 focus:shadow-inner" required />

            <label for="descricao" class="block mt-2 text-xs font-semibold text-gray-600 uppercase">Descrição</label>
            <input id="descricao" type="text" name="descricao" value="{{ old('descricao', $conteudo->descricao) }}" class="block w-full p-3 mt-2 text-gray-700 bg-gray-200 appearance-none focus:outline-none focus:bg-gray-300 focus:shadow-inner" required />

            <label for="link" class="block mt-2 text-xs font-semibold text-gray-600 uppercase">Link</label>
            <input id="link" type="text" name="link" value="{{ old('link', $conteudo->link) }}" class="block w-full p-3 mt-2 text-gray-700 bg-gray-200 appearance-none focus:outline-none focus:bg-gray-300 focus:shadow-inner" />

            <label for="trilhas_id" class="block mt-2 text-xs font-semibold text-gray-600 uppercase">Trilha</label>
            <select id="trilhas_id" name="trilhas_id" class="block w-full p-3 mt-2 text-gray-700 bg-gray-200 appearance-none focus:outline-none focus:bg-gray-300 focus:shadow-inner" required>
                <option value="">Selecione</option>
                @foreach($trilhas as $trilha)
                    <option value="{{ $trilha->id }}" {{ old('trilhas_id') == $trilha->id ? 'selected' : '' }}>
                        {{ $trilha->titulo }}
                    </option>
                @endforeach
            </select>

            <label for="sequencia" class="block mt-2 text-xs font-semibold text-gray-600 uppercase">Sequência</label>
            <input id="sequencia" type="number" name="sequencia" value="{{ old('sequencia', $conteudo->sequencia) }}" class="block w-full p-3 mt-2 text-gray-700 bg-gray-200 appearance-none focus:outline-none focus:bg-gray-300 focus:shadow-inner" />

            <label for="formato" class="block mt-2 text-xs font-semibold text-gray-600 uppercase">Formato</label>
            <input id="formato" type="text" name="formato" value="{{ old('formato', $conteudo->formato) }}" class="block w-full p-3 mt-2 text-gray-700 bg-gray-200 appearance-none focus:outline-none focus:bg-gray-300 focus:shadow-inner" />

            <button type="submit" class="w-full py-3 mt-6 font-medium tracking-widest text-white uppercase bg-black shadow-lg focus:outline-none hover:bg-gray-900 hover:shadow-none">
                Enviar
            </button>
        </form>
    </div>
</div>
</div>

@endsection

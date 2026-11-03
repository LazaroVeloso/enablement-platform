@extends('layouts.app')
@section('title', 'Editar Trilha')
@section('content')


<div class="grid min-h-screen place-items-center">
    <div class="w-11/12 p-12 bg-white sm:w-8/12 md:w-1/2 lg:w-5/12">
        <h1 class="text-xl font-semibold">Editar Trilha? <span class="font-normal">preencha os dados</span></h1>
        <form action="{{ route('trilhas.update', $trilha->id) }}" method="POST">
        @csrf
        @method('PUT')

            <label for="titulo" class="block text-xs font-semibold text-gray-600 uppercase">Título</label>
            <input id="titulo" type="text" name="titulo" value="{{ old('titulo', $trilha->titulo) }}" class="block w-full p-3 mt-2 text-gray-700 bg-gray-200 appearance-none focus:outline-none focus:bg-gray-300 focus:shadow-inner" required />
            @error('titulo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

            <label for="description" class="block mt-2 text-xs font-semibold text-gray-600 uppercase">Descrição</label>
            <input id="description" type="text" name="description" value="{{ old('description', $trilha->description) }}" class="block w-full p-3 mt-2 text-gray-700 bg-gray-200 appearance-none focus:outline-none focus:bg-gray-300 focus:shadow-inner" />
            @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

            <label for="data_inicio" class="block mt-2 text-xs font-semibold text-gray-600 uppercase">Data Início</label>
            <input id="data_inicio" type="date" name="data_inicio" value="{{ old('data_inicio', $trilha->data_inicio->format('Y-m-d')) }}" class="block w-full p-3 mt-2 text-gray-700 bg-gray-200 appearance-none focus:outline-none focus:bg-gray-300 focus:shadow-inner" required />
            @error('data_inicio') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

            <label for="data_fim" class="block mt-2 text-xs font-semibold text-gray-600 uppercase">Data Fim</label>
            <input id="data_fim" type="date" name="data_fim" value="{{ old('data_fim', $trilha->data_fim->format('Y-m-d')) }}" class="block w-full p-3 mt-2 text-gray-700 bg-gray-200 appearance-none focus:outline-none focus:bg-gray-300 focus:shadow-inner" required />
            @error('data_fim') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

            <label for="responsavel_id" class="block mt-2 text-xs font-semibold text-gray-600 uppercase">Responsável</label>
            <select id="responsavel_id" name="responsavel_id" class="block w-full p-3 mt-2 text-gray-700 bg-gray-200 appearance-none focus:outline-none focus:bg-gray-300 focus:shadow-inner" required>
                <option value="">Selecione</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('responsavel_id', $trilha->responsavel_id) == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
            @error('responsavel_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

            <label class="flex items-center gap-2 mt-4 text-xs font-semibold text-gray-600 uppercase">
                <input type="hidden" name="ativo" value="0">
                <input type="checkbox" name="ativo" value="1" @checked(old('ativo', $trilha->ativo))>
                Ativo
            </label>

            <button type="submit" class="w-full py-3 mt-6 font-medium tracking-widest text-white uppercase bg-black shadow-lg focus:outline-none hover:bg-gray-900 hover:shadow-none">
                Salvar
            </button>
        </form>
    </div>
</div>



@endsection



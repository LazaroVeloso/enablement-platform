@extends('layouts.app')
@section('title', 'Editar Usuário')
@section('content')



<div class="grid min-h-screen place-items-center">
    <div class="w-11/12 p-12 bg-white sm:w-8/12 md:w-1/2 lg:w-5/12">
        <h1 class="text-xl font-semibold">Editar usuário? <span class="font-normal">preencha os dados</span></h1>
        <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

            <label for="image" class="block text-xs font-semibold text-gray-600 uppercase">Avatar</label>  
            <input type="file" id="image" name="image" class="from-control-file">
            @error('image') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

            <label for="name" class="block text-xs font-semibold text-gray-600 uppercase">Nome</label>
            <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" class="block w-full p-3 mt-2 text-gray-700 bg-gray-200 appearance-none focus:outline-none focus:bg-gray-300 focus:shadow-inner" required />
            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

            <label for="email" class="block mt-2 text-xs font-semibold text-gray-600 uppercase">E-mail</label>
            <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" class="block w-full p-3 mt-2 text-gray-700 bg-gray-200 appearance-none focus:outline-none focus:bg-gray-300 focus:shadow-inner" required />
            @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

            <label for="cpf" class="block mt-2 text-xs font-semibold text-gray-600 uppercase">CPF</label>
            <input id="cpf" type="text" name="cpf" value="{{ old('cpf', $user->cpf) }}" class="block w-full p-3 mt-2 text-gray-700 bg-gray-200 appearance-none focus:outline-none focus:bg-gray-300 focus:shadow-inner" required />
            @error('cpf') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

            <label for="password" class="block mt-2 text-xs font-semibold text-gray-600 uppercase">Senha</label>
            <input id="password" type="password" name="password" placeholder="******" class="block w-full p-3 mt-2 text-gray-700 bg-gray-200 appearance-none focus:outline-none focus:bg-gray-300 focus:shadow-inner placeholder:text-gray-400" />

            <label for="tipos_id" class="block mt-2 text-xs font-semibold text-gray-600 uppercase">Tipo</label>
            <select id="tipos_id" name="tipos_id" class="block w-full p-3 mt-2 text-gray-700 bg-gray-200 appearance-none focus:outline-none focus:bg-gray-300 focus:shadow-inner" required>
                <option value="">Selecione</option>
                @foreach($tipos as $tipo)
                    <option value="{{ $tipo->id }}" {{ old('tipos_id', $user->tipos_id) == $tipo->id ? 'selected' : '' }}>
                        {{ $tipo->nome }}
                    </option>
                @endforeach
            </select>
            @error('tipos_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

            <button type="submit" class="w-full py-3 mt-6 font-medium tracking-widest text-white uppercase bg-black shadow-lg focus:outline-none hover:bg-gray-900 hover:shadow-none">
                Salvar
            </button>
        </form>
    </div>
</div>


@endsection



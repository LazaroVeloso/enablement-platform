@extends('layouts.app')

@section('title', 'Creation')

@section('content')



<!-- component -->


    <div class="grid min-h-screen place-items-center">
        <div class="w-11/12 p-12 bg-white sm:w-8/12 md:w-1/2 lg:w-5/12">
            <h1 class="text-xl font-semibold">Novo Usuário?, <span class="font-normal">preencha os dados</span></h1>
            <form class="mt-6" action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf  
                <label for="image" class="block text-xs font-semibold text-gray-600 uppercase">Avatar</label>  
                <input type="file" id="image" name="image" class="from-control-file">
                <label for="nome" class="block text-xs font-semibold text-gray-600 uppercase">Nome</label>
                <input id="nome" type="text" name="nome" placeholder="John" autocomplete="given-name" class="block w-full p-3 mt-2 text-gray-700 bg-gray-200 appearance-none focus:outline-none focus:bg-gray-300 focus:shadow-inner"  required />
                <label for="email" class="block mt-2 text-xs font-semibold text-gray-600 uppercase">E-mail</label>
                <input id="email" type="email" name="email" placeholder="john.doe@company.com" autocomplete="email" class="block w-full p-3 mt-2 text-gray-700 bg-gray-200 appearance-none focus:outline-none focus:bg-gray-300 focus:shadow-inner" required />
                <label for="password" class="block mt-2 text-xs font-semibold text-gray-600 uppercase">Password</label>
                <input id="password" type="password" name="password" placeholder="********" autocomplete="new-password" class="block w-full p-3 mt-2 text-gray-700 bg-gray-200 appearance-none focus:outline-none focus:bg-gray-300 focus:shadow-inner" required />
                <label for="cpf" class="block mt-2 text-xs font-semibold text-gray-600 uppercase">CPF</label>
                <input id="cpf" type="text" name="cpf" placeholder="********" autocomplete="cpf" class="block w-full p-3 mt-2 text-gray-700 bg-gray-200 appearance-none focus:outline-none focus:bg-gray-300 focus:shadow-inner" required />
                <label for="cpf" class="block mt-2 text-xs font-semibold text-gray-600 uppercase">CPF</label>
                <select name="tipos_id" id="tipos_id" class="block w-full p-3 mt-2 text-gray-700 bg-gray-200 appearance-none focus:outline-none focus:bg-gray-300 focus:shadow-inner" required>
                    <option value="">Selecione</option>    <!-- adicionar old -->
                        @foreach ($tipos as $tipo)
                            <option value="{{ $tipo->id }}" 
                                {{ old('tipos_id', $tipo->id) == $tipo->id ? 'selected' : '' }}>
                                {{ $tipo->nome }}
                            </option>
                        @endforeach
                </select>

                <button type="submit" class="w-full py-3 mt-6 font-medium tracking-widest text-white uppercase bg-black shadow-lg focus:outline-none hover:bg-gray-900 hover:shadow-none">
                    Enviar
                </button>
            </form>
        </div>
    </div>


@endsection
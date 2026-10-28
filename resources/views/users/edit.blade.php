@extends('layouts.app')
@section('title', 'Editar Usuário')
@section('content')



<div>

    <div class="bg-cover bg-center h-30" style="background-image: url('{{ asset('img/mountains.jpg') }}')">
         <a class=" mt-8 ml-4 border-2 bg-gray-400 hover:text-white hover:bg-black" onclick="history.back()">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m18.75 4.5-7.5 7.5 7.5 7.5m-6-15L5.25 12l7.5 7.5" />
                </svg>
         </a>
    </div>        
    
    <!-- background -->
    <div class="relative flex min-h-screen flex-col justify-center bg-gradient-to-r from-rose-100 to-teal-100">
        
        <!-- card -->
        <div class="mx-auto flex w-96 flex-col justify-center bg-white rounded-2xl shadow-xl shadow-slate-300/60">
            <!-- img -->
            <div class="relative w-96">
                <img class="aspect-video w-96 rounded-t-2xl object-cover object-center" src="https://images.pexels.com/photos/3311574/pexels-photo-3311574.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" />
            </div>
            <!-- text information -->
            <div class="p-4">
                <form action="{{ route('users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="ml-12">
                        <label for="name">Nome:</label>
                        <input class="border-2" type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required>
                    
                        @error('name')
                            <span>{{ $message }}</span>
                        @enderror
                        
                    </div>

                    <div class="ml-12">
                        <label for="email">E-mail:</label>
                        <input class="border-2" type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required>
                        @error('email') <span>{{ $message }}</span> @enderror
                    </div>

                    <div class="ml-12"> 
                        <label for="cpf">CPF:</label>
                        <input class="border-2" type="text" name="cpf" id="cpf" value="{{ old('cpf', $user->cpf) }}" required>
                        @error('cpf') <span>{{ $message }}</span> @enderror
                    </div>

                    <div class="ml-12"> 
                        <label for="password">Senha:</label>
                        <input class="border-2" type="text" name="password" id="password" value="{{ old('password', $user->password) }}" required>
                        @error('password') <span>{{ $message }}</span> @enderror
                    </div>
                    
                    
                    <div class="ml-12">
                        <label for="tipo">Tipo</label> 
                        <select name="tipos_id" id="tipos_id" class="border-2" required>
                            <option value="">Selecione</option>    <!-- adicionar old -->
                            @foreach ($tipos as $tipo)
                                <option value="{{ $tipo->id }}" 
                                    {{ old('tipos_id', $user->tipos_id) == $tipo->id ? 'selected' : '' }}>
                                    {{ $tipo->nome }}
                                </option>
                            @endforeach
                        </select>
                        @error('tipos_id') <span>{{ $message }}</span> @enderror
                    </div>

                    <div class="ml-12">
                        <button class="border-2 bg-gray-400 hover:bg-[#00FF00]" type="submit">Salvar</button>
                        <button class="border-2 bg-gray-400 hover:bg-red-500" href="{{ route('users.index') }}">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection



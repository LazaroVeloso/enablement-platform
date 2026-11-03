@extends('layouts.app')
@section('title', 'Listagem')

@section('content')

<div>
    <div class="flex items-center justify-between bg-black text-white">
        <a href= "{{ route('home.index') }}" class="text-[25px] font-extrabold bg-black text-white  hover:text-yellow-400">
            Voltar
        </a>
        <h1 class="text-[54px] font-extrabold bg-black text-white text-center">
            Listagem de Usuarios 
        </h1>
        <a href="{{ route('users.create') }}">
                <button class="text-[40px] bg-green-300 w-20 h-20 my-5 rounded-3xl hover:bg-yellow-300">
                    +
                </button>
        </a>
    </div>

    <table class="text-center mx-auto w-full">
        <thead>
            <tr class="bg-[#2F4F4F] text-white">
                <th scope="col" class="border-6 border-black">id</th>
                <th scope="col" class="border-6 border-black">nome</th>
                <th scope="col" class="border-6 border-black">email</th>
                <th scope="col" class="border-6 border-black">password</th>
                <th scope="col" class="border-6 border-black">cpf</th>
                <th scope="col" class="border-6 border-black">tipo</th>
            </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr class="bg-[#87CEFA]">
                <td class="border-6">{{$user->id}}</td>
                <td class="border-6">{{$user->name}}</td>
                <td class="border-6">{{$user->email}}</td>      
                <td class="border-6">{{$user->password}}</td>            
                <td class="border-6">{{$user->cpf}}</td>            
                <td class="border-6">{{$user->tipo}}</td>            
                <td class="border-2 bg-gray-400 hover:bg-[#00FF00]"> <a href="{{ route('users.show', $user->id) }}">Ver</a></td>
                <td class="border-2 bg-gray-400 hover:bg-yellow-500"> <a href="{{ route('users.edit', $user->id) }}">Editar</a></td>
                <td class="border-2 bg-gray-400 hover:bg-red-500">
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Excluir</button>
                    </form>
                </td>

            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="flex flex-row overflow-x-scroll gap-4 bg-slate-300 border-2 mt-8 p-4">
    @foreach($users as $user)
    <div class="flex w-96 flex-col justify-center bg-white rounded-2xl shadow-xl shadow-slate-300/60">
        <!-- img -->
        <div class="relative w-96">
            <img class="aspect-video w-96 rounded-t-2xl object-cover object-center" src="https://images.pexels.com/photos/3311574/pexels-photo-3311574.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" />
            <a href="{{ route('users.edit', $user->id) }}" class="absolute top-2 right-2 h-8 w-8 flex items-center justify-center bg-gray-400 hover:bg-yellow-500 border-2 rounded-md">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                </svg>
            </a>
        </div>
        <!-- text information -->
        <div class="p-4">
            <small class="text-blue-400 text-xs">Tipo: {{ $user->tipo }}</small>
            <h1 class="text-2xl font-medium text-slate-600 pb-2">{{ $user->name }}</h1>
            <p class="text-sm tracking-tight font-light text-slate-400 leading-6">Email: {{ $user->email }}</p>
            <p class="text-sm tracking-tight font-light text-slate-400 leading-6">CPF: {{ $user->cpf }}</p>
        </div>
    </div>
    @endforeach
    </div>


</div>
@endsection
@extends('layouts.app')
@section('title', 'Listagem')

@section('content')
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

@endsection
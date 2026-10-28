@extends('layouts.app')
@section('title', 'Listagem')

@section('content')
    <div class="flex items-center justify-between bg-black text-white">
        <button class="text-[25px] font-extrabold bg-black text-white  hover:text-yellow-400" onclick="history.back()">
            Voltar
        </button>
        <h1 class="text-[54px] font-extrabold bg-black text-white text-center">
            Listagem de Trilhas
        </h1>
        <a href="{{ route('trilhas.create') }}">
            <button class="text-[40px] bg-green-300 w-20 h-20 my-5 rounded-3xl hover:bg-yellow-300">+</button>
        </a>
    </div>

    <table class="text-center mx-auto w-full">
        <thead>
            <tr class="bg-[#2F4F4F] text-white">
                <th scope="col" class="border-6 border-black">id</th>
                <th scope="col" class="border-6 border-black">titulo</th>
                <th scope="col" class="border-6 border-black">descrição</th>
                <th scope="col" class="border-6 border-black">data_inicio</th>
                <th scope="col" class="border-6 border-black">data_fim</th>
                <th scope="col" class="border-6 border-black">responsável</th>
                <th scope="col" class="border-6 border-black">ativo</th>

            </tr>
        </thead>
        <tbody>
        @foreach($trilhas as $trilha)
            <tr class="bg-[#87CEFA]">
                <td class="border-6">{{$trilha->id}}</td>
                <td class="border-6">{{$trilha->titulo}}</td>
                <td class="border-6">{{$trilha->description}}</td>      
                <td class="border-6">{{$trilha->data_inicio}}</td>            
                <td class="border-6">{{$trilha->data_fim}}</td>
                <td class="border-6">{{$trilha->responsavel->name}}</td>
                <td class="border-6">
                    @if($trilha->ativo)
                        <svg class="w-10 h-10 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="size-6" color="green">
                            <path strokeLinecap="round" strokeLinejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    @else
                        <svg class="w-10 h-10 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="size-6" color="red">
                            <path strokeLinecap="round" strokeLinejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636" />
                        </svg>
                    @endif
                </td>
                <td class="border-2 bg-gray-400 hover:bg-[#00FF00]"> <a href="{{ route('trilhas.show', $trilha->id) }}">Ver</a> </td>
                <td class="border-2 bg-gray-400 hover:bg-yellow-500"> <a href="{{ route('trilhas.edit', $trilha->id) }}">Editar</a> </td>
                <td class="border-2 bg-gray-400 hover:bg-red-500">    
                    <form action="{{ route('trilhas.destroy', $trilha->id) }}" method="POST">
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
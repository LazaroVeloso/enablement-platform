@extends('layouts.app')
@section('title', 'Editar Trilha')
@section('content')

<form action="{{ route('trilhas.update', $trilha->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div>
        <label for="titulo">Título</label>
        <input type="text" name="titulo" id="titulo" value="{{ old('titulo', $trilha->titulo) }}">
       
        @error('name')
            <span>{{ $message }}</span>
        @enderror
        
    </div>

    <div>
        <label for="description">Descrição</label>
        <input type="text" name="description" id="description" value="{{ old('description', $trilha->description) }}">
        @error('description') <span>{{ $message }}</span> @enderror
    </div>

    <div>
        <label for="data_inicio">Data Início</label>
        <input type="date" name="data_inicio" id="data_inicio" value="{{ old('data_inicio', $trilha->data_inicio->format('Y-m-d')) }}">
        @error('data_inicio') <span>{{ $message }}</span> @enderror
    </div>

    <div>
        <label for="data_fim">Data Fim</label>
        <input type="date" name="data_fim" id="data_fim" value="{{ old('data_fim', $trilha->data_fim->format('Y-m-d')) }}">
        @error('data_fim') <span>{{ $message }}</span> @enderror
    </div>


    <div>
        <label for="ativo">Ativo</label>
        <input type="hidden" name="ativo" value="0">
        <input type="checkbox" id="ativo" name="ativo" value="1" @checked(old('ativo', $trilha->ativo))>
        @error('ativo') <span>{{ $message }}</span> @enderror
    </div>

    <div>
        <label for="responsavel_id">Responsável</label> <!--
        <input type="number" id="responsavel_id" name="responsavel_id" value="{{ old('responsavel_id', $trilha->responsavel_id) }}" required>
        -->
        <select name="responsavel_id" id="responsavel_id" required>
            <option value="">Selecione</option>    <!-- adicionar old -->
            @foreach ($users as $user)
                <option value= "{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>
        @error('responsavel_id') <span>{{ $message }}</span> @enderror

    </div>

    <button type="submit">Salvar alterações </button>
    <a href="{{ route('trilhas.index') }}">Cancelar</a>
    <a href="{{ route('trilhas.index') }}">Voltar</a>
</form>

@endsection



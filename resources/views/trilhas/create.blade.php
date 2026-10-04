@extends('layouts.app')

@section('title', 'Creation')

@section('content')

    <h1>Criação de Trilha</h1>

    <form action="{{ route('trilhas.store') }}" method="POST">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       @csrf

    <div>
        <label for="titulo">Titulo</label>
        <input type="text" id="titulo" name="titulo" required>
    </div>

    <div>
        <label for="description">Descrição</label>
        <input type="text" id="description" name="description" required>
    </div>

    <div>
        <label for="data_inicio">Data Início</label>
        <input type="date" id="data_inicio" name="data_inicio">
    </div>

    <div>
        <label for="data_fim">Data Fim</label>
        <input type="date" id="data_fim" name="data_fim">
    </div>

    <div>
        <label for="ativo">Ativo</label>
        <input type="hidden" name="ativo" value="0">
        <input type="checkbox" id="ativo" name="ativo" value="1" {{ old('ativo') ? 'checked' : ''}}>
    </div>

    <div>
        <label for="responsavel_id">Responsável</label>
        <select name="responsavel_id" id="responsavel_id" required>
            <option value="">Selecione</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}" @selected(old('responsavel_id') == $user->id)>
                    {{ $user->name }}
                </option>
            @endforeach
        </select>
        @error('responsavel_id') <span>{{ $message }}</span> @enderror
    </div>


    <button type="submit">Enviar</button>
    <a href="{{ route('trilhas.index') }}">Cancelar</a>
    <a href="{{ route('trilhas.index') }}">Voltar</a>
    </form>


@endsection
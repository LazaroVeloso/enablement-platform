@extends('layouts.app')
@section('title', 'Editar Conteúdo')
@section('content')

<form action="{{ route('conteudos.update', $conteudo->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div>
        <label for="nome">Nome</label>
        <input type="text" name="nome" id="nome" value="{{ old('nome', $conteudo->nome) }}" required>
       
        @error('nome')
            <span>{{ $message }}</span>
        @enderror
        
    </div>

    <div>
        <label for="descricao">Descrição</label>
        <input type="text" name="descricao" id="descricao" value="{{ old('descricao', $conteudo->descricao) }}">
        @error('descricao') <span>{{ $message }}</span> @enderror
    </div>

    <div>
        <label for="link">Link</label>
        <input type="text" name="link" id="link" value="{{ old('link', $conteudo->link) }}" required>
        @error('link') <span>{{ $message }}</span> @enderror
    </div>

    <div>
        <label for="sequencia">Sequencia</label>
        <input type="number" name="sequencia" id="sequencia" value="{{ old('sequencia', $conteudo->sequencia) }}" required>
        @error('sequencia') <span>{{ $message }}</span> @enderror
    </div>

    <div>
        <label for="formato">Formato</label>
        <input type="text" name="formato" id="formato" value="{{ old('formato', $conteudo->formato) }}" required>
        @error('formato') <span>{{ $message }}</span> @enderror
    </div>

    <div>
        <label for="trilhas_id">Trilha</label> 
        <select name="trilhas_id" id="trilhas_id" required>
            <option value="">Selecione</option>    <!-- adicionar old -->
            @foreach ($trilhas as $trilha)
                <option value= "{{ $trilha->id }}">{{ $trilha->titulo }}</option>
            @endforeach
        </select>
        @error('trilhas_id') <span>{{ $message }}</span> @enderror

    </div>


    <button type="submit">Salvar alterações</button>
    <a href="{{ route('users.index') }}">Cancelar</a>
    <a href="{{ route('users.index') }}">Voltar</a>
</form>

@endsection

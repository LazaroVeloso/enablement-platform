<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conteudos;
use App\Models\Trilhas;
use Illuminate\Support\Facades\DB;


class ConteudosController extends Controller
{

    public function index() {
        $conteudos =  Conteudos::with('trilha')->get();
        return view('conteudos.index', ['conteudos' => $conteudos]);
    }


    public function store(Request $request)
    {
        $conteudos = $request->validate([
            'link' => 'required|string|max:255',
            'nome' => 'required|string|max:255',
            'sequencia' => 'required|integer',
            'descricao' => 'string|max:255',
            'formato' => 'required|string|max:255',
            'trilhas_id' => 'required|integer'
        ]);
        //@dd($request);
        
        DB::transaction(function () use ($conteudos) {
            Conteudos::create([
                'link' => $conteudos['link'],
                'nome' => $conteudos['nome'],
                'sequencia' => $conteudos['sequencia'],
                'descricao' => $conteudos['descricao'],
                'formato' => $conteudos['formato'],  
                'trilhas_id' =>$conteudos['trilhas_id'],
            ]);
        });

        return redirect()->route('conteudos.index')->with('success', 'Usuário atualizado!');
    }

    public function create() {
        $trilhas = Trilhas::all();
        return view('conteudos.create', compact('trilhas'));
    }

    public function show(Conteudos $conteudo) { 
        return view('conteudos.show', compact('conteudo'));
    }

    public function edit(Conteudos $conteudo) {
        $trilhas = Trilhas::all();
        return view('conteudos.edit', compact('conteudo', 'trilhas'));
    }

    //UPDATE
    public function update(Request $request, Conteudos $conteudo) {
        $dados = $request->validate([
            'nome'       => 'required|string|max:255',
            'link'       => 'required|string|max:255',
            'sequencia'  => 'required|integer',
            'descricao'  => 'nullable|string',
            'formato'    => 'required|string|max:255',
            'trilhas_id' => 'required|integer|exists:trilhas,id',
        ]);

        $conteudo->update($dados);

        return redirect()->route('conteudos.index')->with('success', 'Conteúdo atualizado!');
    }

    // DELETE
    public function destroy(Conteudos $conteudo) {
        $conteudo->delete();

        return redirect()->route('conteudos.index')->with('success', 'Conteúdo removido! ');
    }

}

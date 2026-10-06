<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Models\Trilhas;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class TrilhasController extends Controller
{
    //
    public function index() {
        $trilhas = Trilhas::with('responsavel')->get();

        //@dd($trilhas);
        return view('trilhas.index', ['trilhas' => $trilhas]);
    }


    public function store(Request $request)
    {
        $trilhas = $request->validate([
            'titulo' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'ativo' => 'boolean',
            'responsavel_id' => 'required|integer',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date',

        ]);
        //@dd($request->all());
        DB::transaction(function () use ($trilhas) {
            Trilhas::create([
                'titulo' => $trilhas['titulo'],
                'description' => $trilhas['description'],
                'ativo' => $trilhas['ativo'] ?? false,
                'responsavel_id' => $trilhas['responsavel_id'], 
                'data_inicio' => $trilhas['data_inicio'],
                'data_fim' => $trilhas['data_fim'],
            ]);
        });

        return redirect()->route('trilhas.index')->with('success', 'Trilha atualizada!');
    }

    public function create() {

        $users = User::whereHas('tipo', function (Builder $query) {  
            $query->where('nome', 'gestor'); // query = pesquisa no banco
        })->get();

        return view('trilhas.create', compact('users'));
    }

    public function show(Trilhas $trilha) { 
        //@dd($user);
        return view('trilhas.show', compact('trilha'));
    }

    public function edit(Trilhas $trilha) {

        $users = User::whereHas('tipo', function (Builder $query) {
            $query->where('nome', 'gestor');
        })->get();

        return view('trilhas.edit', compact('trilha', 'users'));
    }

    //UPDATE
    public function update(Request $request, Trilhas $trilha) {
        $dados = $request->validate([
            'titulo' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'ativo' => 'boolean',
            'responsavel_id' => 'required|integer',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date',
        ]);  //testar se funciona

        $trilha->update($dados);

        return redirect()->route('trilhas.index')->with('success', 'Trilha atualizada!');
    }

    // DELETE
    public function destroy(Trilhas $trilha) {
        $trilha->delete();

        return redirect()->route('trilhas.index')->with('success', 'Trilhas removida! ');
    }

}

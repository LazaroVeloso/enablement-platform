<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    
    public function index() {
        $users =  User::join('tipos', 'tipos.id', '=','tipos_id')
        ->select('users.*', 'tipos.nome as tipo')
        ->get();
        //@dd($users);
        return view('users.index', ['users' => $users]);
    }


    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|string|max:255',
            'cpf' => 'required|string|max:255',
            'tipos_id' => 'required|int|max:255',
        ]);

        DB::transaction(function () use ($dados) {
            User::create([
                'name' => $dados['nome'],
                'email' => $dados['email'],
                'password' => $dados['password'],
                'cpf' => $dados['cpf'],
                'tipos_id' => $dados['tipos_id'],  
            ]);
        });

        return redirect()->route('users.index')->with('success', 'Usuário atualizado!');
    }

    public function create() {
        return view('users.create');
    }

    public function show(User $user) { 
        //@dd($user);
        return view('users.show', compact('user'));
    }

    public function edit(User $user) {
        return view('users.edit', compact('user'));
    }

    //UPDATE
    public function update(Request $request, User $user) {
        $dados = $request->validate([
            'name' => 'required|string|max: 225',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'cpf' => 'required|string|unique:users,cpf,' . $user->id,
        ]);

        $user->update($dados);

        return redirect()->route('users.index')->with('success', 'Usuário atualizado!');
    }

    // DELETE
    public function destroy(User $user) {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Usuário removido! ');
    }

}

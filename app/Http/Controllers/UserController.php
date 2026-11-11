<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tipos;
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

        $imageName = null;

        // image upload
        if($request->hasFile('image') && $request->file('image')->isValid()) {

            $requestImage = $request->image;

            $extension = $requestImage->extension();

            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;

            $request->image->move(public_path('img/users'), $imageName);

        }

        DB::transaction(function () use ($dados, $imageName) {
            User::create([
                'name' => $dados['nome'],
                'email' => $dados['email'],
                'password' => $dados['password'],
                'cpf' => $dados['cpf'],
                'tipos_id' => $dados['tipos_id'],  
                'image' => $imageName,
            ]);
        });

        return redirect()->route('users.index')->with('success', 'Usuário atualizado!');
    }

    public function create() {
        $tipos = Tipos::all();
        return view('users.create', compact('tipos'));
    }

    public function show(User $user) { 
        //@dd($user);
        $user->load('tipo'); 
        return view('users.show', compact('user'));
    }

    public function edit(User $user) {
        $tipos = Tipos::all(); 
        return view('users.edit', compact('user', 'tipos'));
    }

    //UPDATE
    public function update(Request $request, User $user) {
        $dados = $request->validate([
            'name' => 'required|string|max: 225',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'cpf' => 'required|string|unique:users,cpf,' . $user->id,
            'tipos_id' => 'required|integer|exists:tipos,id',
        ]);

        $imageName = $user->image; 

        // image upload
        if($request->hasFile('image') && $request->file('image')->isValid()) {

            $ultimaImagem = $user->image;

            $requestImage = $request->image;
            $extension = $requestImage->extension();
            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;
            $request->image->move(public_path('img/users'), $imageName);

            if($ultimaImagem && $ultimaImagem !== 'default-user.jpg') {
                $ultimaImagemCaminho = public_path('img/users/' . $ultimaImagem);
                if(file_exists($ultimaImagem)) {
                    unlink($ultimaImagem);
                }
            } 

        }

        $dados['image'] = $imageName;
        $user->update($dados);

        return redirect()->route('users.index')->with('success', 'Usuário atualizado!');
    }

    // DELETE
    public function destroy(User $user) {

        if($user->image && $user->image !== 'default-user.jog') {
            $ultimaImagemCaminho = public_path('img/users/' . $user->image);
            if(file_exists($ultimaImagemCaminho)) {
                unlink($ultimaImagemCaminho);
            }
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Usuário removido! ');
    }

}

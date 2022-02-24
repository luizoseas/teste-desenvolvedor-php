<?php

namespace App\Http\Controllers;

use App\Models\usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Usuarios extends Controller
{
    private $messages = [
        'required' => 'O campo :attribute é obrigatório.',
        'max' => 'O campo :attribute deve ter no máximo :max caracteres.',
        'min' => 'O campo :attribute deve ter no mínimo :min caracteres.',
        'same' => 'O campo :attribute deve ser igual ao campo :other.',
        'unique' => 'O campo :attribute já está cadastrado.',
    ];
    private $validation = [
        'nomeUsuario' => 'required|max:100|unique:usuarios',
        'senha' => 'required|same:repita_senha|max:100|min:3',
        'repita_senha' => 'required',
    ];
    public function login(Request $request){
        $this->validate($request, [
            'nomeUsuario' => 'required',
            'senha' => 'required'
        ], $this->messages);
        if(!Auth::attempt(['nomeUsuario' => $request->nomeUsuario, 'password' => $request->senha])){
            return redirect()->back()->withErrors(['msg' => 'Usuário ou senha inválidos!']);
        }
        return redirect()->route('clientes.index');
    }
    public function logout(Request $request){
        Auth::logout();
        return redirect()->route('login');
    }
    public function get($codigo){
        try{
            $usuario = usuario::find($codigo);
            if($usuario == null){
                return response()->json([
                    'status' => 'error',
                    'msg' => ['Usuário não encontrado!']
                ]);
            }
            $usuario->url_delete = route('api.usuarios.delete', ['codigo' => $usuario->codUsuario]);
            $usuario->url_edit = route('usuarios.edit', ['codigo' => $usuario->codUsuario]);
            return response()->json([
                'status' => 'success',
                'data' => $usuario
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'msg' => ['Erro ao buscar usuário!']
            ]);
        }
    }
    public function getAll(){
        try{
            $usuarios = usuario::where('nomeUsuario','ilike','%'.request('search', '').'%')->
                                paginate(request('per_page', 10));
            foreach($usuarios as $usuario){
                $usuario->url_delete = route('api.usuarios.delete', ['codigo' => $usuario->codUsuario]);
                $usuario->url_view = route('usuarios.view', ['codigo' => $usuario->codUsuario]);
            }
            return response()->json([
                'status' => 'success',
                'data' => $usuarios
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'msg' => ['Erro ao buscar usuários!']
            ]);
        }
    }
    public function store(Request $request){
        try{
            $this->validate($request, $this->validation, $this->messages);
            $usuario = new usuario();
            $usuario->nomeUsuario = $request->get('nomeUsuario');
            $usuario->senha = Hash::make($request->get('senha'));
            $usuario->save();
            return response()->json([
                'status' => 'success',
                'msg' => ['Usuário cadastrado com sucesso!']
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'msg' => ['Erro ao salvar usuário!', $e->getMessage()]
            ]);
        }
    }
    public function update(Request $request, $codigo){
        try{
            $this->validate($request, $this->validation, $this->messages);
            $usuario = usuario::find($codigo);
            if($usuario == null){
                return response()->json([
                    'status' => 'error',
                    'msg' => ['Usuário não encontrado!']
                ]);
            }
            $usuario->nomeUsuario = $request->get('nomeUsuario');
            $usuario->senha = Hash::make($request->get('senha'));
            $usuario->save();
            return response()->json([
                'status' => 'success',
                'msg' => ['Usuário atualizado com sucesso!']
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'msg' => ['Erro ao atualizar usuário!']
            ]);
        }
    }
    public function destroy($codigo){
        try{
            $usuario = usuario::find($codigo);
            if($usuario == null){
                return response()->json([
                    'status' => 'error',
                    'msg' => ['Usuário não encontrado!']
                ]);
            }
            if(Auth::user()['codUsuario'] == $codigo){
                return response()->json([
                    'status' => 'error',
                    'msg' => ['Não é possível excluir o usuário logado!']
                ]);
            }
            $usuario->delete();
            return response()->json([
                'status' => 'success',
                'msg' => ['Usuário excluído com sucesso!']
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'msg' => ['Erro ao excluir usuário!']
            ]);
        }
    }
    public function destroyMass(Request $request){
        try{
            $this->validate($request, [
                'codigos' => 'required'
            ], $this->messages);
            $codigos = $request->get('codigos');
            foreach($codigos as $codigo){
                $usuario = usuario::find($codigo);
                if($usuario == null){
                    return response()->json([
                        'status' => 'error',
                        'msg' => ['Usuário não encontrado!']
                    ]);
                }
                if(Auth::user()['codUsuario'] == $codigo){
                    return response()->json([
                        'status' => 'error',
                        'msg' => ['Não é possível excluir o usuário logado!']
                    ]);
                }
                $usuario->delete();
            }
            return response()->json([
                'status' => 'success',
                'msg' => ['Usuários excluídos com sucesso!']
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'msg' => ['Erro ao excluir usuários!']
            ]);
        }
    }
}

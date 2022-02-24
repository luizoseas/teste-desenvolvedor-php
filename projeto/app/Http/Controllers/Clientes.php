<?php

namespace App\Http\Controllers;

use App\Models\cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Clientes extends Controller
{
    private $validation = [
        'nomeCliente' => 'required|max:100',
        'CPF' => 'required|max:11',
        'email' => 'nullable|email|max:100',
    ];
    private $messages = [
        'required' => 'O campo :attribute é obrigatório.',
        'max' => 'O campo :attribute deve ter no máximo :max caracteres.',
        'email' => 'O campo :attribute deve ser um e-mail válido.',
    ];

    public function destroy($codigo){
        try{
            $cliente = cliente::find($codigo);
            if($cliente == null){
                return redirect()->json([
                    'status' => 'error',
                    'msg' => ['Cliente não encontrado!']
                ]);
            }
            $cliente->delete();
            return response()->json([
                'status' => 'success',
                'msg' => ['Cliente excluído com sucesso!']
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'msg' => ['Erro ao excluir cliente!']
            ]);
        }
    }
    public function getAll(){
        try{
            $clientes = cliente::
                where('nomeCliente','ilike','%'.request('search', '').'%')->
                orWhere('email','ilike','%'.request('search', '').'%')->
                paginate(request('per_page', 10));
            foreach($clientes as $cliente){
                $cliente->url_delete = route('api.clientes.delete', ['codigo' => $cliente->codCliente]);
                $cliente->url_view = route('clientes.view', ['codigo' => $cliente->codCliente]);
            }
            return response()->json([
                'status' => 'success',
                'data' => $clientes
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'msg' => ['Erro ao buscar clientes!']
            ]);
        }
    }
    public function get($codigo){
        try{
            $cliente = cliente::find($codigo);
            if($cliente == null){
                return response()->json([
                    'status' => 'error',
                    'msg' => ['Cliente não encontrado!']
                ]);
            }
            $cliente->url_delete = route('api.clientes.delete', ['codigo' => $cliente->codCliente]);
            $cliente->url_edit = route('clientes.edit', ['codigo' => $cliente->codCliente]);
            return response()->json([
                'status' => 'success',
                'data' => $cliente
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'msg' => ['Erro ao buscar cliente!']
            ]);
        }
    }
    public function update(Request $request, $codigo){
        try{
            $validation = Validator::make($request->all(), $this->validation, $this->messages);
            if($validation->fails()){
                return response()->json([
                    'status' => 'error',
                    'msg' => $validation->errors()->all()
                ]);
            }
            $cliente = cliente::find($codigo);
            if($cliente == null){
                return response()->json([
                    'status' => 'error',
                    'msg' => ['Cliente não encontrado!']
                ]);
            }
            $cliente->nomeCliente = $request->get('nomeCliente');
            $cliente->CPF = $request->get('CPF');
            $cliente->email = $request->get('email');
            $cliente->save();
            return response()->json([
                'status' => 'success',
                'msg' => ['Cliente atualizado com sucesso!']
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'msg' => ['Erro ao atualizar cliente!']
            ]);
        }
    }
    public function store(Request $request){
        try{
            $validation = Validator::make($request->all(), $this->validation, $this->messages);
            if($validation->fails()){
                return response()->json([
                    'status' => 'error',
                    'msg' => $validation->errors()->all()
                ]);
            }
            $cliente = new cliente();
            $cliente->nomeCliente = $request->get('nomeCliente');
            $cliente->CPF = $request->get('CPF');
            $cliente->email = $request->get('email');
            $cliente->save();
            return response()->json([
                'status' => 'success',
                'msg' => ['Cliente cadastrado com sucesso!']
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'msg' => ['Erro ao cadastrar cliente!']
            ]);
        }

    }
    public function destroyMass(Request $request){
        try{
            $this->validate($request, [
                'codigos' => 'required|array'
            ]);
            foreach($request->codigos as $codigo){
                $cliente = cliente::find($codigo);
                if($cliente == null){
                    return response()->json([
                        'status' => 'error',
                        'msg' => ['Cliente não encontrado!']
                    ]);
                }
                $cliente->delete();
            }
            return response()->json([
                'status' => 'success',
                'msg' => ['Clientes excluídos com sucesso!']
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'msg' => ['Erro ao excluir clientes!']
            ]);
        }
    }
}

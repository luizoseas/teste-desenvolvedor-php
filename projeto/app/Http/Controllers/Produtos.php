<?php

namespace App\Http\Controllers;

use App\Models\produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Produtos extends Controller
{
    private $validation = [
        'nomeProduto' => 'nullable|max:11',
        'valorUnitario' => 'required|max:11',
        'codBarras' => 'required|max:20',
    ];
    private $messages = [
        'required' => 'O campo :attribute é obrigatório.',
        'max' => 'O campo :attribute deve ter no máximo :max caracteres.',
    ];

    public function getAll(){
        try{
            $produtos = produto::where('nomeProduto','ilike','%'.request('search', '').'%')->
                                orWhere('codBarras','ilike','%'.request('search', '').'%')->
                                paginate(request('per_page', 10));
            foreach($produtos as $produto){
                $produto->valorUnitario = (Float) $produto->valorUnitario;
                $produto->url_delete = route('api.produtos.delete', ['codigo' => $produto->codProduto]);
                $produto->url_view = route('produtos.view', ['codigo' => $produto->codProduto]);
            }
            return response()->json([
                'status' => 'success',
                'data' => $produtos
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'msg' => ['Erro ao buscar produtos!']
            ]);
        }
    }
    public function get($codigo){
        try{
            $produto = produto::find($codigo);
            if($produto == null){
                return response()->json([
                    'status' => 'error',
                    'msg' => ['Produto não encontrado!']
                ]);
            }
            $produto->valorUnitario = (Float) $produto->valorUnitario;
            $produto->url_delete = route('api.produtos.delete', ['codigo' => $produto->codProduto]);
            $produto->url_edit = route('produtos.edit', ['codigo' => $produto->codProduto]);
            return response()->json([
                'status' => 'success',
                'data' => $produto
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'msg' => ['Erro ao buscar produto!']
            ]);
        }
    }
    public function update(Request $request, $codigo){
        try{
            $produto = produto::find($codigo);
            if($produto == null){
                return response()->json([
                    'status' => 'error',
                    'msg' => ['Produto não encontrado!']
                ]);
            }
            $validator = Validator::make($request->all(), $this->validation, $this->messages);
            if($validator->fails()){
                return response()->json([
                    'status' => 'error',
                    'msg' => $validator->errors()->all()
                ]);
            }
            $produto->nomeProduto = $request->get('nomeProduto');
            $produto->valorUnitario = $request->get('valorUnitario');
            $produto->codBarras = $request->get('codBarras');
            $produto->save();
            return response()->json([
                'status' => 'success',
                'msg' => ['Produto atualizado com sucesso!']
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'msg' => ['Erro ao atualizar produto!']
            ]);
        }
    }

    public function store(Request $request){
        try{
            $validator = Validator::make($request->all(), $this->validation, $this->messages);
            if($validator->fails()){
                return response()->json([
                    'status' => 'error',
                    'msg' => $validator->errors()->all()
                ]);
            }
            $produto = new produto();
            $produto->nomeProduto = $request->get('nomeProduto');
            $produto->valorUnitario = $request->get('valorUnitario');
            $produto->codBarras = $request->get('codBarras');
            $produto->save();
            return response()->json([
                'status' => 'success',
                'msg' => ['Produto criado com sucesso!']
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'msg' => ['Erro ao criar produto!']
            ]);
        }
    }

    public function destroy($codigo){
        try{
            $produto = produto::find($codigo);
            if($produto == null){
                return response()->json([
                    'status' => 'error',
                    'msg' => ['Produto não encontrado!']
                ]);
            }
            $produto->delete();
            return response()->json([
                'status' => 'success',
                'msg' => ['Produto excluído com sucesso!']
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'msg' => ['Erro ao excluir produto!']
            ]);
        }
    }
    public function destroyMass(Request $request){
        try{
            $this->validate($request, [
                'codigos' => 'required|array'
            ]);
            foreach($request->codigos as $codigo){
                $produto = produto::find($codigo);
                if($produto == null){
                    return response()->json([
                        'status' => 'error',
                        'msg' => ['Produto não encontrado!']
                    ]);
                }
                $produto->delete();
            };
            return response()->json([
                'status' => 'success',
                'msg' => ['Produtos excluídos com sucesso!']
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'msg' => ['Erro ao excluir produtos!']
            ]);
        }
    }

}

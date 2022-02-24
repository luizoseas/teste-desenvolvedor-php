<?php

namespace App\Http\Controllers;

use App\Models\pedido;
use App\Models\cliente;
use App\Models\produto;
use Illuminate\Http\Request;
use App\Models\fk_pedidos_produtos;

class Pedidos extends Controller
{
    private $statusList = [
        'Em Aberto',
        'Pago',
        'Cancelado',
    ];
    private $validation = [
        'status' => 'required',
        'codCliente' => 'required|exists:clientes,codCliente',
        'items' => 'required',
        'items.*.codProduto' => 'required|exists:produtos,codProduto',
        'items.*.quantidade' => 'required|numeric',
        'valorDesconto' => 'nullable|numeric',
    ];
    private $messages = [
        'required' => 'O campo :attribute é obrigatório.',
        'exists' => 'O campo :attribute não existe.',
        'numeric' => 'O campo :attribute deve ser um número.',
    ];
    private function verifyStatus($status){
        if(in_array($status, $this->statusList)){
            return false;
        }
        return true;
    }
    public function getAll(){
        try{
            $pedidos = pedido::
                where('status','ilike','%'.request('search', '').'%')->
                orWhere('codCliente','ilike','%'.request('search', '').'%')->
                paginate(request('per_page', 10));
            foreach($pedidos as $pedido){
                $pedido->dtPedido = date('d/m/Y', strtotime($pedido->dtPedido));
                $pedido->valorDesconto = (Float) $pedido->valorDesconto;
                $pedido->url_delete = route('api.pedidos.delete', ['codigo' => $pedido->codPedido]);
                $pedido->url_view = route('pedidos.view', ['codigo' => $pedido->codPedido]);
                $pedido->subtotal = $pedido->subTotal();
                $pedido->total = $pedido->Total();
                $pedido->nomeCliente = $pedido->cliente->nomeCliente ?? "";
                $pedido->cliente_url = route('clientes.view', ['codigo' => $pedido->codCliente]);
            }
            return response()->json([
                'status' => 'success',
                'data' => $pedidos
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'msg' => ['Erro ao buscar pedidos!']
            ]);
        }
    }
    public function get($codigo){
        try{
            $pedido = pedido::find($codigo);
            if($pedido == null){
                return response()->json([
                    'status' => 'error',
                    'msg' => ['Pedido não encontrado!']
                ]);
            }
            $pedido->dtPedido = date('d/m/Y', strtotime($pedido->dtPedido));
            $pedido->valorDesconto = (Float) $pedido->valorDesconto;
            $pedido->url_delete = route('api.pedidos.delete', ['codigo' => $pedido->codPedido]);
            $pedido->url_edit = route('pedidos.edit', ['codigo' => $pedido->codPedido]);
            $pedido->subtotal = $pedido->subTotal();
            $pedido->total = $pedido->Total();
            $pedido->nomeCliente = $pedido->cliente->nomeCliente ?? "";
            $pedido->cliente_url = route('clientes.view', ['codigo' => $pedido->codCliente]);
            return response()->json([
                'status' => 'success',
                'data' => $pedido
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'msg' => ['Erro ao buscar pedido!']
            ]);
        }
    }
    public function store(Request $request){
        try{
            $this->validate($request, $this->validation, $this->messages);
            if(self::verifyStatus($request->status)){
                return response()->json([
                    'status' => 'error',
                    'msg' => ['Status inválido!']
                ]);
            }
            $pedido = new pedido();
            $pedido->status = $request->get('status');
            $pedido->codCliente = $request->get('codCliente');
            $pedido->valorDesconto = $request->get('valorDesconto');
            $pedido->dtPedido = date('Y-m-d H:i:s');
            $pedido->save();
            foreach(json_decode($request->get('items')) as $item){
                $fk_pedidos_produtos = new fk_pedidos_produtos();
                $fk_pedidos_produtos->codPedido = $pedido->codPedido;
                $fk_pedidos_produtos->codProduto = $item->codProduto;
                $fk_pedidos_produtos->quantidade = $item->quantidade;
                $fk_pedidos_produtos->save();
            }
            return response()->json([
                'status' => 'success',
                'msg' => ['Pedido criado com sucesso!']
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'msg' => ['Erro ao criar pedido!']
            ]);
        }
    }
    public function update(Request $request, $codigo){
        try{
            $this->validate($request, $this->validation, $this->messages);
            if(self::verifyStatus($request->status)){
                return response()->json([
                    'status' => 'error',
                    'msg' => ['Status inválido!']
                ]);
            }
            $pedido = pedido::find($codigo);
            if($pedido == null){
                return response()->json([
                    'status' => 'error',
                    'msg' => ['Pedido não encontrado!']
                ]);
            }
            $pedido->status = $request->get('status');
            $pedido->codCliente = $request->get('codCliente');
            $pedido->valorDesconto = $request->get('valorDesconto');
            $pedido->dtPedido = date('Y-m-d H:i:s');
            $pedido->save();
            fk_pedidos_produtos::where('codPedido', $codigo)->delete();
            foreach(json_decode($request->get('items')) as $item){
                $fk_pedidos_produtos = new fk_pedidos_produtos();
                $fk_pedidos_produtos->codPedido = $pedido->codPedido;
                $fk_pedidos_produtos->codProduto = $item->codProduto;
                $fk_pedidos_produtos->quantidade = $item->quantidade;
                $fk_pedidos_produtos->save();
            }
            return response()->json([
                'status' => 'success',
                'msg' => ['Pedido atualizado com sucesso!']
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'msg' => ['Erro ao atualizar pedido!']
            ]);
        }
    }
    public function destroy($codigo){
       try{
              $pedido = pedido::find($codigo);
              if($pedido == null){
                return response()->json([
                     'status' => 'error',
                     'msg' => ['Pedido não encontrado!']
                ]);
              }
              $pedido->delete();
              return response()->json([
                'status' => 'success',
                'msg' => ['Pedido excluído com sucesso!']
              ]);
       }catch(\Exception $e){
           return response()->json([
               'status' => 'error',
               'msg' => ['Erro ao excluir pedido!']
           ]);
       }
   }
   public function destroyMass(Request $request){
       try{
              $this->validate($request, [
                'codigos' => 'required|array'
              ]);
              foreach($request->codigos as $codigo){
                $pedido = pedido::find($codigo);
                if($pedido == null){
                     return response()->json([
                          'status' => 'error',
                          'msg' => ['Pedido não encontrado!']
                     ]);
                }
                $pedido->delete();
              }
              return response()->json([
                'status' => 'success',
                'msg' => ['Pedidos excluídos com sucesso!']
              ]);
       }catch(\Exception $e){
           return response()->json([
               'status' => 'error',
               'msg' => ['Erro ao excluir pedidos!']
           ]);
       }
   }

}

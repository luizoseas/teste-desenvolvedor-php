<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.head')
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Visualizar Pedido</title>
    </head>
    <body>
        @include('nav')
        <div class="manual-container bg-dark">
            <div class="card col-6" style="min-height: 35vh;">
                <div class="card-header manual-card-header">
                    <h5>Pedido</h5>
                    <a class="btn btn-success" href="{{url()->previous()}}">Voltar</a>
                </div>
                <div class="card-body text-center">
                    <dt class="col-sm-12">Código do Pedido:</dt>
                    <dd class="col-sm-12" id="codPedido"></dd>
                    <dt class="col-sm-12">Data do Pedido: </dt>
                    <dd class="col-sm-12" id="dtPedido"></dd>
                    <dt class="col-sm-12">Status: </dt>
                    <dd class="col-sm-12" id="status"></dd>
                    <dt class="col-sm-12">Cliente: </dt>
                    <dd class="col-sm-12" id="nomeCliente"></dd>
                    <dt class="col-sm-12">SubTotal: </dt>
                    <dd class="col-sm-12" id="subtotal"></dd>
                    <dt class="col-sm-12">Valor de desconto: </dt>
                    <dd class="col-sm-12" id="valorDesconto"></dd>
                    <dt class="col-sm-12">Total: </dt>
                    <dd class="col-sm-12" id="total"></dd>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Produto</th>
                                <th>Quantidade</th>
                                <th>Valor Unitário</th>
                                <th>Valor Total</th>
                            </tr>
                        </thead>
                        <tbody  id="produtos">

                        </tbody>
                    </table>
                    <div id="buttons">
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<script>
    const clientID = {{request()->codigo}};
    async function get(){
        const response = await fetch(URL_BASE+`/api/pedidos/get/${clientID}`);
        if(response.ok){
            const json = await response.json();
            if(json.status == "success"){
                const data = json.data;
                $('#codPedido').text(data.codPedido);
                $('#dtPedido').text(data.dtPedido);
                $('#status').text(data.status);
                $('#nomeCliente').html(`<a href="${data.cliente_url}">${data.nomeCliente}</a>`);
                $('#subtotal').text(moeda(data.subtotal));
                $('#valorDesconto').text(moeda(data.valorDesconto));
                $('#total').text(moeda(data.total));
                $(`#buttons`).html(`
                    <a class="btn btn-warning" href="${data.url_edit}">Editar</a>
                    <a class="btn btn-danger" onClick="removeEdit('${data.url_delete}','{{url()->previous()}}')">Deletar</a>
                `);
                data.produtos_fk.forEach(produto => {
                    $(`#produtos`).append(`
                        <tr>
                            <td>${produto.produto ? produto.produto.nomeProduto: ""}</td>
                            <td>${produto.quantidade}</td>
                            <td>${moeda(produto.produto ? produto.produto.valorUnitario: 0)}</td>
                            <td>${moeda((produto.produto ? produto.produto.valorUnitario: 0) * produto.quantidade)}</td>
                        </tr>
                    `);
                });
            }
        }
    }
    get();
</script>

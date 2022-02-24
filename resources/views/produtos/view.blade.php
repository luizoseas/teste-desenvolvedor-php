<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.head')
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Visualizar Produto</title>
    </head>
    <body>
        @include('nav')
        <div class="manual-container bg-dark">
            <div class="card col-6" style="min-height: 35vh;">
                <div class="card-header manual-card-header">
                    <h5>Produto</h5>
                    <a class="btn btn-success" href="{{url()->previous()}}">Voltar</a>
                </div>
                <div class="card-body text-center">
                    <dt class="col-sm-12">Código do Produto:</dt>
                    <dd class="col-sm-12" id="codProduto"></dd>
                    <dt class="col-sm-12">Nome do Produto: </dt>
                    <dd class="col-sm-12" id="nomeProduto"></dd>
                    <dt class="col-sm-12">Código de Barras: </dt>
                    <dd class="col-sm-12" id="codBarras"></dd>
                    <dt class="col-sm-12">Valor Unitário: </dt>
                    <dd class="col-sm-12" id="valorUnitario"></dd>
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
        const response = await fetch(URL_BASE+`/api/produtos/get/${clientID}`);
        if(response.ok){
            const json = await response.json();
            if(json.status == "success"){
                const data = json.data;
                $(`#codProduto`).text(data.codProduto);
                $(`#nomeProduto`).text(data.nomeProduto);
                $(`#codBarras`).text(data.codBarras);
                $(`#valorUnitario`).text(moeda(data.valorUnitario));
                $(`#buttons`).html(`
                    <a class="btn btn-warning" href="${data.url_edit}">Editar</a>
                    <a class="btn btn-danger" onClick="removeEdit('${data.url_delete}','{{url()->previous()}}')">Deletar</a>
                `);
            }
        }
    }
    get();
</script>

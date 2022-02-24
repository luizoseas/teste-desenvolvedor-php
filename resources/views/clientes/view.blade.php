<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.head')
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Visualizar Cliente</title>
    </head>
    <body>
        @include('nav')
        <div class="manual-container bg-dark">
            <div class="card col-6" style="min-height: 35vh;">
                <div class="card-header manual-card-header">
                    <h5>Cliente</h5>
                    <a class="btn btn-success" href="{{url()->previous()}}">Voltar</a>
                </div>
                <div class="card-body text-center">
                    <dt class="col-sm-12">Código do Cliente: </dt>
                    <dd class="col-sm-12" id="codCliente"></dd>
                    <dt class="col-sm-12">Nome Completo: </dt>
                    <dd class="col-sm-12" id="nomeCliente"></dd>
                    <dt class="col-sm-12">CPF: </dt>
                    <dd class="col-sm-12" id="CPF"></dd>
                    <dt class="col-sm-12">Email: </dt>
                    <dd class="col-sm-12" id="email"></dd>
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
        const response = await fetch(URL_BASE+`/api/clientes/get/${clientID}`);
        if(response.ok){
            const json = await response.json();
            if(json.status == "success"){
                const data = json.data;
                $('#nomeCliente').text(data.nomeCliente);
                $('#CPF').text(formataCPF(data.CPF));
                $('#email').text(data.email);
                $('#codCliente').text(data.codCliente);
                $(`#buttons`).html(`
                    <a class="btn btn-warning" href="${data.url_edit}">Editar</a>
                    <a class="btn btn-danger" onClick="removeEdit('${data.url_delete}','{{url()->previous()}}')">Deletar</a>
                `);
            }
        }
    }
    get();
</script>

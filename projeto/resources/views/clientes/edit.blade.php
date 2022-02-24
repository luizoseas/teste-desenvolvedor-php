<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.head')
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Editar Cliente</title>
    </head>
    <body>
        @include('nav')
        <div class="manual-container bg-dark">
            <div class="card col-9">
                <div class="card-header manual-card-header">
                    <h5>Editar Cliente</h5>
                    <a class="btn btn-primary" href="{{url()->previous()}}">Voltar</a>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="nome_completo" class="form-label">Nome Completo *</label>
                        <input type="text" name="nomeCliente" class="form-control" autocomplete="false" id="nome_completo">
                    </div>
                    <div class="mb-3">
                        <label for="cpf" class="form-label">CPF *</label>
                        <input type="number" name="CPF" class="form-control" autocomplete="false" id="cpf">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="email" autocomplete="false">
                    </div>
                    <div class="col-auto">
                    <button onclick="update()" class="btn btn-success mb-3">Atualizar</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<script>
    const clientID = {{request()->codigo}};
    async function update(){
        const nomeCliente = $(`#nome_completo`).val();
        const CPF = $(`#cpf`).val();
        const email = $(`#email`).val();
        const data = {
            nomeCliente,
            CPF,
            email
        };
        const response = await fetch(URL_BASE+'/api/clientes/update/'+clientID, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });
        if(response.ok){
            window.location.href = '{{url()->previous()}}';
        }
    }
    async function get(){
        const response = await fetch(URL_BASE+'/api/clientes/get/'+clientID);
        if(response.ok){
            const data = await response.json();
            if(data.status == "success"){
                $(`#nome_completo`).attr('placeholder', data.data.nomeCliente);
                $(`#cpf`).attr('placeholder', data.data.CPF);
                $(`#email`).attr('placeholder', data.data.email);
                $('#nome_completo').val(data.data.nomeCliente);
                $('#cpf').val(data.data.CPF);
                $('#email').val(data.data.email);
            }
        }
    }
    get();
</script>

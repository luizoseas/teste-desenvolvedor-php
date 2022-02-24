<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.head')
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Cadastrar Cliente</title>
    </head>
    <body>
        @include('nav')
        <div class="manual-container bg-dark">
            <div class="card col-9">
                <div class="card-header manual-card-header">
                    <h5>Cadastrar Cliente</h5>
                    <a class="btn btn-primary" href="{{url()->previous()}}">Voltar</a>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="nome_completo" class="form-label">Nome Completo *</label>
                        <input type="text" name="nomeCliente" class="form-control" autocomplete="false" id="nome_completo" placeholder="João Mario" required>
                    </div>
                    <div class="mb-3">
                        <label for="cpf" class="form-label">CPF *</label>
                        <input type="number" name="CPF" class="form-control" autocomplete="false" id="cpf" placeholder="00000000000" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="email" autocomplete="false" placeholder="usuario@provedor.tld">
                    </div>
                    <div class="col-auto">
                    <button onclick="store()" class="btn btn-success mb-3">Cadastrar</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<script>
    async function store(){
        const nomeCliente = $(`#nome_completo`).val();
        const CPF = $(`#cpf`).val();
        const email = $(`#email`).val();
        const data = {
            nomeCliente,
            CPF,
            email
        };
        const response = await fetch(URL_BASE+'/api/clientes/store', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });
        if(response.ok){
            window.location.href = '{{url()->previous()}}';
        }
    }
</script>

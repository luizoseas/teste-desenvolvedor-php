<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.head')
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Cadastrar Usuário</title>
    </head>
    <body>
        @include('nav')
        <div class="manual-container bg-dark">
            <div class="card col-9">
                <div class="card-header manual-card-header">
                    <h5>Cadastrar Usuário</h5>
                    <a class="btn btn-primary" href="{{url()->previous()}}">Voltar</a>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="nomeUsuario" class="form-label">Nome de Usuário *</label>
                        <input type="text" class="form-control" autocomplete="false" id="nomeUsuario">
                    </div>
                    <div class="mb-3">
                        <label for="senha" class="form-label">Senha *</label>
                        <input type="password" class="form-control" autocomplete="false" id="senha">
                    </div>
                    <div class="mb-3">
                        <label for="repita_senha" class="form-label">Repita Senha*</label>
                        <input type="password" class="form-control" id="repita_senha" autocomplete="false">
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
        const nomeUsuario = $(`#nomeUsuario`).val();
        const senha = $(`#senha`).val();
        const repita_senha = $(`#repita_senha`).val();
        const data = {
            nomeUsuario,
            senha,
            repita_senha
        };
        const response = await fetch(URL_BASE+'/api/usuarios/store', {
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

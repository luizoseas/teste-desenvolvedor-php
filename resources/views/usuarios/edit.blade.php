<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.head')
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Editar Usuário</title>
    </head>
    <body>
        @include('nav')
        <div class="manual-container bg-dark">
            <div class="card col-9">
                <div class="card-header manual-card-header">
                    <h5>Editar Usuário</h5>
                    <a class="btn btn-primary" href="{{url()->previous()}}">Voltar</a>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="nome_completo" class="form-label">Nome de Usuário *</label>
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
        const nomeUsuario = $(`#nomeUsuario`).val();
        const senha = $(`#senha`).val();
        const repita_senha = $(`#repita_senha`).val();
        const data = {
            nomeUsuario,
            senha,
            repita_senha
        };
        const response = await fetch(URL_BASE+'/api/usuarios/update/'+clientID, {
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
        const response = await fetch(URL_BASE+'/api/usuarios/get/'+clientID);
        if(response.ok){
            const data = await response.json();
            if(data.status == "success"){
                $(`#nomeUsuario`).attr('placeholder', data.data.nomeUsuario);
                $('#nomeUsuario').val(data.data.nomeUsuario);
            }
        }
    }
    get();
</script>

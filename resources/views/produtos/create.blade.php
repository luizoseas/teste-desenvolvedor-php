<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.head')
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Cadastrar Produto</title>
    </head>
    <body>
        @include('nav')
        <div class="manual-container bg-dark">
            <div class="card col-9">
                <div class="card-header manual-card-header">
                    <h5>Cadastrar Produto</h5>
                    <a class="btn btn-primary" href="{{url()->previous()}}">Voltar</a>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="nomeProduto" class="form-label">Nome do Produto</label>
                        <input type="text" name="nomeProduto" class="form-control" autocomplete="false" id="nomeProduto" placeholder="Telefone" required>
                    </div>
                    <div class="mb-3">
                        <label for="valorUnitario" class="form-label">Valor Unitário *</label>
                        <input type="number" name="valorUnitario" class="form-control" autocomplete="false" id="valorUnitario" placeholder="0.00" required>
                    </div>
                    <div class="mb-3">
                        <label for="codBarras" class="form-label">Código de Barras</label>
                        <input type="text" name="codBarras" class="form-control" id="codBarras" autocomplete="false" placeholder="1233211123">
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
        const nomeProduto = $('#nomeProduto').val();
        const valorUnitario = $('#valorUnitario').val();
        const codBarras = $('#codBarras').val();
        const data = {
            nomeProduto,
            valorUnitario,
            codBarras
        };
        const response = await fetch(URL_BASE+'/api/produtos/store', {
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

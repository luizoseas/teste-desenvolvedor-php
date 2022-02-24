<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Cadastrar Pedido</title>
        @include('layouts.head')
    </head>
    <body>
        @include('nav')
        <div class="manual-container bg-dark">
            <div class="card col-9">
                <div class="card-header manual-card-header">
                    <h5>Cadastrar Pedido</h5>
                    <a class="btn btn-primary" href="{{url()->previous()}}">Voltar</a>
                </div>
                <div class="card-body">
                        <div class="mb-3">
                            <input type="hidden" id="codCliente">
                            <label for="status" class="form-label">Cliente *</label>
                            <input class="form-control" id="searchClient" placeholder="Digite o nome do cliente">
                            <div className="border rounded py-2" id="clientsListDiv" style="position: absolute;index:10;background:#F1F1F1;overflow:auto;max-height:200px;">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="desconto" class="form-label">Valor de Desconto</label>
                            <input type="number" name="desconto" class="form-control" value="0" autocomplete="false" id="valorDesconto" placeholder="0.00" required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status *</label>
                            <select name="status" class="form-control" id="status">
                                <option value="Em Aberto">Em Aberto</option>
                                <option value="Pago">Pago</option>
                                <option value="Cancelado">Cancelado</option>
                            </select>
                        </div>
                        <input type="hidden" name="items" id="items" />
                        <div class="mb-3 table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Produto</th>
                                        <th>Quantidade</th>
                                        <th>Valor/Uni</th>
                                        <th>Valor Total</th>
                                        <th>Ação</th>
                                    </tr>
                                </thead>
                                <tbody id="produtos">
                                </tbody>
                            </table>
                            <div class="row text-center">
                                <div class="mb-3 col-12">
                                    <input class="form-control" id="searchProduto" placeholder="Digite o nome do produto">
                                    <div className="border rounded py-2" id="productsListDiv" style="position: absolute;index:10;background:#F1F1F1;overflow:auto;max-height:200px;">
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-auto">
                        <button onClick="store()" class="btn btn-success mb-3">Cadastrar</button>
                        </div>
                </div>
            </div>
        </div>
    </body>
</html>
<script>
    var listProducts = [];
    $('#searchClient').keyup(async function(){
        var response = await fetch(URL_BASE+"/api/clientes/get?search="+$('#searchClient').val()+"&per_page=20");
        if(response.ok){
            const data = await response.json();
            if(data.status == "success"){
                $('#clientsListDiv').html('');
                data.data.data.forEach(element => {
                    $('#clientsListDiv').append(`<button class="btn btn-link" onclick="setClient(${element.codCliente},'${element.nomeCliente} (${element.CPF})')">${element.nomeCliente} (${formataCPF(element.CPF)})</button></br>`);
                });
            }
        }
    });
    $('#searchProduto').keyup(async function(){
        var response = await fetch(URL_BASE+"/api/produtos/get?search="+$('#searchProduto').val()+"&per_page=20");
        if(response.ok){
            const data = await response.json();
            if(data.status == "success"){
                $('#productsListDiv').html('');
                data.data.data.forEach(element => {
                    $('#productsListDiv').append(`<button class="btn btn-link" onclick="addProduto(${element.codProduto},'${element.nomeProduto}',${element.valorUnitario})">${element.nomeProduto} (${moeda(element.valorUnitario)})</button></br>`);
                });
            }
        }
    });
    function setClient(id,name){
        $('#searchClient').val(name);
        $('#clientsListDiv').html('');
        $('#codCliente').val(id);
    }
    function render() {
        //produtos
        let produtos = document.getElementById('produtos');
        produtos.innerHTML = '';
        listProducts.forEach(produto => {
            produtos.innerHTML += `
            <tr>
                <td>${produto.nomeProduto} (${produto.codProduto})</td>
                <td><input type="number" id="quantProdut${produto.codProduto}" onChange="updateProduto(${produto.codProduto})" value="${produto.quantidade}" class="form-control"></td>
                <td>${moeda(parseFloat(produto.valor))}</td>
                <td>${moeda(parseFloat(produto.valor) * produto.quantidade)}</td>
                <td><button class="btn btn-danger" onClick="removeProduto(${produto.codProduto})">Remover</button></td>
            </tr>
            `;
        });
        let items = document.getElementById('items');
        items.value = JSON.stringify(listProducts);
    }
    function addProduto(codigo,nome,valor) {
        $('#searchProduto').val(name);
        $('#productsListDiv').html('');
        let produto = {
            codProduto: codigo,
            nomeProduto: nome,
            valor: valor,
            quantidade: 1,
        }
        //verify if product is already in the list
        let produtoFindList = listProducts.find(produto => produto.codProduto == codigo);
        if(!produtoFindList) {
            listProducts.push(produto);
        }
        render();
    }
    function removeProduto(codProduto) {
        listProducts = listProducts.filter(produto => produto.codProduto != codProduto);
        render();
    }
    function updateProduto(codProduto){
        listProducts.forEach(produto => {
            if(produto.codProduto == codProduto) {
                let quantidade = document.getElementById(`quantProdut${codProduto}`).value;
                produto.quantidade = quantidade;
            }
        });
        render();
    }
    async function store(){
        let response = await fetch(URL_BASE+"/api/pedidos/store",{
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                codCliente: $('#codCliente').val(),
                status: $('#status').val(),
                valorDesconto: $('#valorDesconto').val(),
                items: JSON.stringify(listProducts)
            })
        });
        if(response.ok){
            const data = await response.json();
            if(data.status == "success"){
                window.location.href = "{{url()->previous()}}";
            }
        }
    }
</script>

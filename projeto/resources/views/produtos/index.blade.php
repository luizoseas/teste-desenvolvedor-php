<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.head')
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Produtos Cadastrados</title>
    </head>
    <body>
        @include('nav')
        <div class="manual-container bg-dark">
            <div class="card col-8 manual-card">
                <div class="card-header manual-card-header">
                    <h5>Produtos Cadastrados</h5>
                    <a class="btn btn-success" href="{{route('produtos.create')}}">Cadastrar Produto</a>
                </div>
                <div class="card-body">
                    <input class="form-control" placeholder="Pesquise" id="search"/>
                    <div class="table-responsive">
                        <table id="sort" class="table">
                            <thead>
                                <tr>
                                    <th scope="col"><input type="checkbox" id="selectAll" onChange="ListSelectAll()" /></th>
                                    <th scope="col">#</th>
                                    <th scope="col">Nome do Produto</th>
                                    <th scope="col">Valor Unitário</th>
                                    <th scope="col">Código de Barras</th>
                                    <th scope="col">Ação</th>
                                </tr>
                              </thead>
                              <tbody id="bodytable">
                              </tbody>
                        </table>
                      </div>
                      <button class="btn btn-link" onClick="deleteMass()">Deletar Todos Itens Selecionados</button>
                </div>
                <div class="card-footer">
                    <nav class="overflow">
                        <ul class="pagination justify-content-center" id="pagination">
                        </ul>
                    </nav>
                    <div class="itemsPage"><span>Itens por Página:</span><input class="form-control" placeholder="20" id="perpage" onChange="updatePerPage()" type="number"/></div>
                </div>
            </div>
        </div>
    </body>
</html>
<script>
    var per_page = ""
    var search = "";
    $('#search').change(function(){
        search = $('#search').val();
        get();
    });
    function updatePerPage(){
        per_page = $("#perpage").val();
        get();
    }
    async function pagiantion(data){
        $('#pagination').html('');
        data.links.forEach(element => {
            if(element.url == null){
                $('#pagination').append(`
                    <li class="page-item disabled"><a class="page-link cursoPointer">${element.label}</a></li>
                `);
            }else{
                if(element.active){
                    $('#pagination').append(`
                        <li class="page-item active"><a class="page-link cursoPointer" onClick="get('${element.url}')">${element.label}</a></li>
                    `);
                }else{
                    $('#pagination').append(`
                        <li class="page-item"><a class="page-link cursoPointer" onClick="get('${element.url}')">${element.label}</a></li>
                    `);
                }
            }
        });
    }
    var ListRemoveMass = [];
    var ListSelect = [];
    function ListSelectAll(){
        if($('#selectAll')[0].checked){
            ListRemoveMass = ListSelect;
            ListSelect.forEach(element => {
                $('#check'+element).prop('checked', true);
            });
        }else{
            ListRemoveMass = [];
            ListSelect.forEach(element => {
                $('#check'+element).prop('checked', false);
            });
        }
    }
    function ListMass(code){
        //get input type checkbox checked
        if($('#check'+code)[0].checked){
            ListRemoveMass.push(code);
        }else{
            ListRemoveMass.splice(ListRemoveMass.indexOf(code),1);
        }
    }
    function deleteMass(){
        if(ListRemoveMass.length > 0){
            $.ajax({
                url: "{{route('api.produtos.deleteMass')}}",
                type: "DELETE",
                data: {
                    codigos: ListRemoveMass
                },
                success: function(data){
                    if(data.status == 'success'){
                        ListRemoveMass = [];
                        get();
                    }
                }
            });
        }
    }
    async function get(url = ""){
        var response
        if(url == ""){
            response = await fetch(URL_BASE+"/api/produtos/get?per_page="+per_page+"&search="+search);
        }else{
            response = await fetch(url+"&per_page="+per_page+"&search="+search);
        }
        if(response.ok){
            const json = await response.json();
            if(json.status == "success"){
                const data = json.data;
                $("#bodytable").html("");
                //foreach array in data.data

                ListSelect=[];
                data.data.forEach(function(cliente){
                    ListSelect.push(cliente.codProduto);
                    $("#bodytable").append(`
                        <tr>
                            <th scope="row"><input type="checkbox" id="check${cliente.codProduto}" onChange="ListMass(${cliente.codProduto})" /></th>
                            <th scope="row">${cliente.codProduto}</th>
                            <td>${cliente.nomeProduto}</td>
                            <td>${moeda(cliente.valorUnitario)}</td>
                            <td>${cliente.codBarras}</td>
                            <td>
                                <a class="btn btn-warning" href="${cliente.url_view}">Ver</a>
                                <button class="btn btn-danger" onClick="remove('${cliente.url_delete}','${url}')">Deletar</button>
                            </td>
                        </tr>
                    `);
                });
                pagiantion(data);
            }
        }
    }
    get()
</script>

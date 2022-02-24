<div class="nav bg-light">
    <ul>
        <li><a href="{{route('clientes.index')}}">Clientes</a></li>
        <li><a href="{{route('produtos.index')}}">Produtos</a></li>
        <li><a href="{{route('pedidos.index')}}">Pedidos</a></li>
        <li><a href="{{route('usuarios.index')}}">Usuários</a></li>
        <li><a class="text-danger" href="{{route('login.logout')}}">Sair</a></li>
    </ul>
</div>
<style>
    .nav{
        width: 100%;
        height: 6vh;
        z-index: 999;
    }
    .nav ul{
        width: 100%;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .nav ul li{
        list-style: none;
        width: 100px;
        height: 50px;
        line-height: 50px;
        text-align: center;
        font-size: 16px;
        font-weight: bold;
    }
    .nav ul li a:hover{
        color: #6d6d6d;
    }
    .nav ul li a{
        text-decoration: none;
        color: #3d3d3d;
    }

</style>
<script>
    function moeda(value){
        return value.toLocaleString('pt-BR', {
            style: 'currency',
            currency: 'BRL',
        });
    }
    function formataCPF(cpf){
        cpf = cpf.replace(/[^\d]/g, "");
        return cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4");
    }

    async function remove(link, localURL){
        $.ajax({
            url: link,
            type: 'DELETE',
            success: function(data){
                get(localURL);
            }
        });
    }
    async function removeEdit(link, localURL){
        $.ajax({
            url: link,
            type: 'DELETE',
            success: function(data){
                window.location.href = localURL;
            }
        });
    }
</script>

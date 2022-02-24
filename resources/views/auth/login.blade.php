<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <title>Login</title>
</head>
<body>
    <div class="corpo">
        <form method="post" class="bg-light border rounded" action="{{route('login.post')}}">
            @csrf
            @method('POST')
            <h2>LOGIN</h2>
            <div>
                <label class="text-dark">Usuário:</label>
                <input class="form-control" type="text" name="nomeUsuario" placeholder="Usuário">
            </div>
            <div>
                <label class="text-dark">Senha:</label>
                <input class="form-control" type="password" name="senha" placeholder="Senha">
            </div>
            <button class="btn btn-primary" type="submit">Entrar</button>
            @if($errors->any())
            {!! implode('', $errors->all('<div class=" m-1 text-danger">* :message</div>')) !!}
        @endif
        </form>
    </div>
</body>
</html>
<style>
    *{
        margin: 0;
        padding: 0;
    }
    body{
        background: #E3E3E3;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif
    }
    .corpo{
        width:100%;
        min-height: 100vh;
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
    }
    .corpo>form{
        padding: 5rem;
        width: 25rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    .corpo>form>h2{
        font-size: 25px;
        color: gray;
    }
    .corpo>form>div>input{
        padding: 1rem;
        margin: 15px;
        width: 16rem;
    }
    .corpo>form>button{
        width: 13rem;
    }
</style>

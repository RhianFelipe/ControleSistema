<?php
//incluir banco de dados 
include "./db/conexao.php";

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./style/telaFiltro.css?v=<?php echo time(); ?>">
    <title>Sistema de Controle de Permissões</title>
</head>

<body>
    <header>
        <img class="imgHeader" src="./assets\img/logo-govpr.png"></img>
        <a href="./src/cadastrarUser.php">Cadastrar Usuarios</a>

        <a href="">Lista de Usuários</a>
    </header>

    <main>
        <section>
            <h1>Filtro de Controle de Cadastro</h1>
            <div>
                Nome: <input class="inputTable" type="text">
                E-mail: <input class="inputTable" type="text">
                Sistemas: 
            
                <select name="permissao">
                    <option selected value="0">0</option>
                    <option value="1">1</option>
                </select>

                <label>Permissão:</label>
                <select name="permissao">
                    <option selected value="0">0</option>
                    <option value="1">1</option>
                </select>
                teste
            </div>
        </section>
    </main>

    <footer>
        Todos os direitos reservados 
    </footer>
</body>
</html>
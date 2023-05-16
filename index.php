<?php
// inclui o arquivo de conexão com o banco de dados
include "./db/conexao.php";
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <title>Sistema de Controle de Permissões</title>
</head>

<body>
    <header>
        <!-- Título da página -->
        <h1>Controle de Sistemas</h1>

        <!-- Link para página de cadastro de usuários -->
        <a href="./src/cadastrarUser.php">Cadastrar Usuários</a>

        <!-- Link para página de lista de usuários -->
        <a href="">Lista de Usuários</a>
    </header>

    <section>
        <!-- Título da seção -->
        <h1>Área de Consulta</h1>

        <div>
            <!-- Campo de busca por nome -->
            <label> Nome:</label> <input class="inputTable" type="text">

            <!-- Campo de busca por e-mail -->
            <label> E-mail:</label> <input class="inputTable" type="text">

            <!-- Seleção de sistemas -->
            <label>Sistemas:</label>
            <select name="permissao">
                <option selected value="0">0</option>
                <option value="1">1</option>
            </select>

            <!-- Seleção de permissão -->
            <label>Permissão:</label>
            <select name="permissao">
                <option selected value="0">0</option>
                <option value="1">1</option>
            </select>
        </div>
    </section>

</body>

</html>
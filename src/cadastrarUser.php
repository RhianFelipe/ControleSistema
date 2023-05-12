<?php
include "../db/conexao.php";
include "../src/popup.php";

//Pegar dados do formulário pelo método POST
if(count($_POST)>0){ 
    $nome = $_POST['nome'];
    $email = $_POST['email'];
   var_dump($_POST);

}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css?v=<?php echo time(); ?>"> <!-- Voltar uma pasta e pegar o style.css   -->
    <link rel="stylesheet" href="../style/telaCadastro.css?v=<?php echo time(); ?>">
    <title>Cadastrar Usuário</title>
</head>

<body>
    <header>
        <!-- Criação do Header para logo e navegação-->
        <img src="../assets/img/logo-govpr.png" alt="">
        <a href="../index.php">Voltar para Filtro</a>
    </header>
    <!-- Criação formulário para cadastro de Usuário-->
    <div id="area-form">
        <form id="form" method="POST" action="">
            <h1>Cadastrar Usuário</h1><br>
            <label>Nome:</label>
            <input class="input-value" placeholder="nome" name="nome" type="text" required><br>
            <label>E-mail:</label>
            <input class="input-value" placeholder="usuario@pge.pr.gov.br" name="email" type="text" required><br>
            <label>Grupo:</label>
            <select class="input-value" name="select">
                <option value="" selected disabled hidden>---</option>
                <option value="valor1">Procurador</option>
                <option value="valor2">Tercerizado</option>
                <option value="valor4">Servidor</option>
                <option value="valor3">Estagiário</option>
                <option value="valor4">Advogado</option>
            </select> <br>
            <label>Gerenciar Permissões:</label>
            <!-- Botão para abrir o pop-up de gerenciamento de Permissões-->
            <button onclick="openPopup()" id="button-permissao" type="button">Permissões</button> <br>
            <button id="button-submit" type="submit">Cadastrar</button>
        </form>
    </div>

    <footer>

    </footer>
     <!--Importar script do popup -->
    <script src="../script/popup.js"></script>
</body>

</html>
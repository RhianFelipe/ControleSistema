<?php
// Incluir arquivo de conexão com o banco de dados e arquivo de pop-up
include "../db/conexao.php";
include "../db/consulta.php";
include "../src/popup.php";
$erro = false;
// Função para verificar a existência de um valor em uma tabela do banco de dados
function verificarExistencia($mysqli, $valor, $tabela, $variavel)
{
    $verificar = "SELECT $valor FROM $tabela WHERE $valor='$variavel'";
    $resultVerificacao = $mysqli->query($verificar) or die($mysqli->error);
    return $resultVerificacao;
}

// Verificar se existem dados enviados pelo formulário pelo método POST
if (count($_POST) > 0) {
    // Pegar valores do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $grupo = $_POST['grupo'];
   
        // Imprimir os valores recebidos do formulário
    var_dump($_POST);

    $existeNome = verificarExistencia($mysqli, "nome", "usuarios", $nome);
    $existeEmail = verificarExistencia($mysqli, "email", "usuarios", $email);
    if ($existeNome->num_rows > 0) {
        echo "Esse nome já existe";
    } else {
        if ($existeEmail->num_rows > 0) {
            echo "Esse e-mail já existe";
        } else {
           // Salvar as informações do usuário no banco de dados
        $insertUsuario = "INSERT INTO usuarios (nome, email, grupo, data_create) VALUES ('$nome','$email','$grupo', NOW())";
        $mysqli->query($insertUsuario) or die($mysqli->error);
        $id_usuario = $mysqli->insert_id; // Obter o ID do usuário recém-inserido

        
        echo "Usuário cadastrado com sucesso!";
        echo "ID: " . $id_usuario;
         
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Importar folhas de estilo -->
    <link rel="stylesheet" href="../style.css?v=<?php echo time(); ?>"> <!-- Voltar uma pasta e pegar o style.css -->
    <link rel="stylesheet" href="../style/telaCadastro.css?v=<?php echo time(); ?>">
    <title>Cadastrar Usuário</title>
</head>

<body>
    <!-- Criação do Header para logo e navegação-->
    <header>
        <img src="../assets/img/logo-govpr.png" alt="">
        <a href="../index.php">Voltar para Filtro</a>
    </header>

    <!-- Criação formulário para cadastro de Usuário-->
    <div id="area-form">
        <form id="form" method="POST" action="">
            <h1>Cadastrar Usuário</h1><br>
            <label>Nome:</label>
            <input class="input-value" id="nome" placeholder="nome" name="nome" type="text" required><br>
            <label>E-mail:</label>
            <input class="input-value" placeholder="usuario@pge.pr.gov.br" name="email" type="text" required><br>
            <label>Grupo:</label>
            <!-- Obter valores dos grupos do banco de dados e mostrá-los em um menu suspenso -->
            <select class="input-value" name="grupo">
                <?php
                while ($colunaGrupo = mysqli_fetch_array($queryBuscaGrupo)) { ?>
                    <option value="<?= $colunaGrupo['grupo'] ?>"><?php echo $colunaGrupo['grupo']; ?></option> <?php }
                                                                                                                ?>
            </select> <br>
            <label>Gerenciar Permissões:</label>
            <!-- Botão para abrir o pop-up de gerenciamento de Permissões-->
            <button onclick="openPopup()" id="button-permissao" type="button">Permissões</button> <br>
            <button id="button-submit" type="submit">Cadastrar</button>
             
        </form>

    </div>

    <footer></footer>
    <script src="../script/popup.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../script/ajax.js"></script>

</body>

</html>
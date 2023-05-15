<?php
include "../db/conexao.php";
include "../src/popup.php";
//Pegar dados do formulário pelo método POST
function verificarExistencia($valor,$tabela,$variavel){
 $verificar = "SELECT $valor FROM $tabela WHERE $valor='$variavel'";
 $resultVerificacao = $mysqli->query($verificar) or die($mysqli->error);
}
if(count($_POST)>0){ 
  //Pegar valores do formulario
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $grupo = $_POST['grupo'];
    $id_usuario = $mysqli->insert_id;
    echo "ID:" . $id_usuario;
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
            <!--pegar valores do grupo que está no banco de dados e mostrar no Select -->
            <?php $sql  = mysqli_query($mysqli, "select grupo from usuarios");?>
            <select class="input-value" name="grupo"><?php
                while($resultado = mysqli_fetch_array($sql)){ ?>     
                    <option value="<?=  $resultado['grupo'] ?>"><?php echo $resultado['grupo']; ?></option>
                    <?php } ?>
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

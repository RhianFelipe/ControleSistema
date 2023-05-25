<?php
// Incluir arquivo de conexão com o banco de dados e arquivo de pop-up
include "../db/conexao.php";
include "../db/consulta.php";
include "../src/popup.php";

function verificarExistencia($mysqli, $valor, $tabela, $variavel)
{
    $verificar = "SELECT $valor FROM $tabela WHERE $valor='$variavel'";
    $resultVerificacao = $mysqli->query($verificar) or die($mysqli->error);
    return $resultVerificacao;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém os valores do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $grupo = $_POST['grupo'];
    $sistemas = $_POST['sistemas'];
    var_dump($_POST);
    $existeNome = verificarExistencia($mysqli, "nome", "usuarios", $nome);
    $existeEmail = verificarExistencia($mysqli, "email", "usuarios", $email);

    if ($existeNome->num_rows > 0) {
        echo "Esse nome já existe";
    } else {
        if ($existeEmail->num_rows > 0) {
        } else {
            $query = "INSERT INTO usuarios (nome, email, grupo, data_create) VALUES ('$nome', '$email', '$grupo', NOW())";
            mysqli_query($mysqli, $query);

            // Obtém o ID do novo usuário
            $idUsuario = mysqli_insert_id($mysqli);

            // Remove as permissões antigas do usuário
            $query = "DELETE FROM Permissoes WHERE id_usuario = $idUsuario";
            mysqli_query($mysqli, $query);

            // Insere ou atualiza as permissões selecionadas para o usuário
            foreach ($sistemas as $sistema => $permissao) {
                // Verifica se o usuário já possui uma permissão para o sistema
                $query = "SELECT * FROM permissoes WHERE id_usuario = $idUsuario AND sistemas = '$sistema'";
                $result = mysqli_query($mysqli, $query);

                if ($result->num_rows > 0) {
                    // Atualiza a permissão existente
                    $query = "UPDATE permissoes SET permissao = '$permissao' WHERE id_usuario = $idUsuario AND sistemas = '$sistema'";
                    mysqli_query($mysqli, $query);
                    echo "ENTROU NO UPDATE";
                } else {
                    // Verifica se o sistema já existe na tabela de permissões para outros usuários
                    $query = "SELECT * FROM permissoes WHERE sistemas = '$sistema'";
                    $result = mysqli_query($mysqli, $query);

                    if ($result->num_rows > 0) {
                        echo "ENTROU NO INSERT";
                        // Insere uma nova permissão apenas se o sistema já existe para outros usuários
                        $query = "INSERT INTO permissoes (id_usuario, sistemas, permissao) VALUES ($idUsuario, '$sistema', $permissao)";
                        mysqli_query($mysqli, $query);
                    }
                }
            }
        }
    }

    // Fecha a conexão com o banco de dados
    mysqli_close($mysqli);

    // Exibe uma mensagem de sucesso
    echo "Usuário criado/alterado com sucesso!";
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
                    <option value="<?= $colunaGrupo['grupo'] ?>"><?php echo $colunaGrupo['grupo']; ?></option> <?php } ?>
            </select> <br>
            <label>Gerenciar Permissões:</label>
            <!-- Criação da tabela de permissões -->
            <table id="tabela-permissoes">
                <h3>Permissões:</h3>
                <p>Marque as permissões para cada sistema:</p>
                <input type="checkbox" name="sistemas[SistemaA]" value="concedida"> SistemaA<br>
                <input type="checkbox" name="sistemas[SistemaB]" value="concedida"> SistemaB<br>



                <?php /*
                include "../db/consulta.php";
                while ($row = mysqli_fetch_assoc($queryBuscaSistemas)) {
                    echo "<tr>";
                    echo "<td>" . $row['sistemas'] . "</td>";
                    echo "<td><input type='checkbox' name='permissao[" . $row['sistemas'] . "]' value='1'> " . $row['permissao'] . "</td>";
                    echo "</tr>";
                }
                */
                ?>

            </table>
            <!-- Botão para abrir o pop-up de gerenciamento de Permissões-->
            <button onclick="openPopup()" id="button-permissao" type="button">Permissões</button> <br>
            <button id="button-submit" type="submit">Cadastrar</button>

        </form>

    </div>

    <footer></footer>
    <script src="../script/popup.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


</body>

</html>
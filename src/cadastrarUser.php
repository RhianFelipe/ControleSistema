<?php
include "../db/conexao.php";
include "../db/consulta.php";
include "../src/logUser.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém os valores do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $grupo = $_POST['grupo'];

    $existeNome = verificarExistencia($mysqli, "nome", "usuarios", $nome);
    $existeEmail = verificarExistencia($mysqli, "email", "usuarios", $email);

    if ($existeNome->num_rows > 0) {
        echo "<script>alert('Esse nome já existe.');</script>";
    } else {
        if ($existeEmail->num_rows > 0) {
            echo "<script>alert('Esse e-mail já existe.');</script>";
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<script>alert('E-mail digitado errado.');</script>";
        } else {
            $inserirUsuario = "INSERT INTO usuarios (nome, email, grupo, data_create) VALUES ('$nome', '$email', '$grupo', NOW())";
            mysqli_query($mysqli, $inserirUsuario);
            // Obtém o ID do novo usuário
            $idUsuario = mysqli_insert_id($mysqli);

            // Inserir as permissões para cada sistema
            foreach ($sistemas as $nomeSistema => $valorPermissao) {
                // Verifica se o sistema está presente nos dados enviados pelo formulário
                if (isset($_POST['sistemas'][$nomeSistema])) {
                    $valorSelecionado = $_POST['sistemas'][$nomeSistema];

                    // Insere o valor selecionado no banco de dados
                    $inserirPermissao = "INSERT INTO permissoes (id_usuario, sistemas, permissao) VALUES ('$idUsuario', '$nomeSistema', '$valorSelecionado')";
                    mysqli_query($mysqli, $inserirPermissao);
                }
            }

            // Adiciona o registro de log
            logCriacaoUsuario($mysqli, $idUsuario, $nome);
           

            echo "<script>alert('Usuário cadastrado com sucesso!');</script>";
        }
    }
}

// Fecha a conexão com o banco de dados
mysqli_close($mysqli);
?>

<?php
include "../db/conexao.php";
include "../db/consulta.php";
include "../src/logUser.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obter os valores do formulário
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    $nome = $dados['nome'];
    $email = $dados['email'];
    $grupo = $dados['grupo'];

    // Verificar se existe Nome e Email
    $existeNome = verificarExistencia($mysqli, "nome", "usuarios", $nome);
    $existeEmail = verificarExistencia($mysqli, "email", "usuarios", $email);

    if ($existeNome->num_rows > 0) {
        $retorna = ['status' => false, 'msg' => "Esse nome já existe."];
        echo json_encode($retorna);
    } else {
        if ($existeEmail->num_rows > 0) {
            $retorna = ['status' => false, 'msg' => "Esse e-mail já existe."];
            echo json_encode($retorna);
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $retorna = ['status' => false, 'msg' => "E-mail digitado errado."];
            echo json_encode($retorna);
        } else {
            // Inserir usuários no BD
            $inserirUsuario = "INSERT INTO usuarios (nome, email, grupo, data_create) VALUES ('$nome', '$email', '$grupo', NOW())";
            mysqli_query($mysqli, $inserirUsuario);
            // Obter o ID do novo usuário
            $idUsuario = mysqli_insert_id($mysqli);

            // Inserir as permissões para cada sistema
            foreach ($dados['sistemas'] as $nomeSistema => $valorPermissao) {
                $valorSelecionado = $valorPermissao;

                // Inserir o valor selecionado no banco de dados
                $inserirPermissao = "INSERT INTO permissoes (id_usuario, sistemas, permissao) VALUES ('$idUsuario', '$nomeSistema', '$valorSelecionado')";
                mysqli_query($mysqli, $inserirPermissao);
            }

            // Adicionar o registro de log
            logOperacaoUsuario($mysqli, $idUsuario,'Criado');

            $retorna = ['status' => true, 'msg' => "Usuário cadastrado com sucesso!"];
            echo json_encode($retorna);
        }
    }
}

// Fecha a conexão com o banco de dados
mysqli_close($mysqli);
?>

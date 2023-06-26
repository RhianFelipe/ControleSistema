<?php
include "../db/conexao.php";

// Função para registrar a operação de criação de usuário no log
function logCriacaoUsuario($mysqli, $idUsuario, $nomeUsuario) {
    // Crie a consulta SQL para inserir o registro de log
    $sql = "INSERT INTO logsusuarios (id_usuario, nome_usuario, tipo_operacao, data_operacao) VALUES ('$idUsuario', '$nomeUsuario', 'Criado', NOW())";

    // Execute a consulta SQL
    if (mysqli_query($mysqli, $sql)) {
        echo "Registro de criação de usuário adicionado ao log com sucesso.";
    } else {
        echo "Erro ao adicionar registro de criação de usuário ao log: " . mysqli_error($mysqli);
    }
}

// Função para registrar a operação de atualização de usuário no log
function logAtualizacaoUsuario($mysqli, $id) {
    // Crie a consulta SQL para inserir o registro de log
    $sqlNomeUsuario = "SELECT nome FROM usuarios WHERE id = $id";
    $queryNomeUsuario = $mysqli->query($sqlNomeUsuario) or die($mysqli->error);
    $rowNomeUsuario = $queryNomeUsuario->fetch_assoc();
    $nomeUsuario = $rowNomeUsuario['nome'];
    $sqlLogs = "INSERT INTO logsusuarios (id_usuario, nome_usuario, tipo_operacao, data_operacao) VALUES ('$id', '$nomeUsuario', 'Atualizado', NOW())";
    $queryLogs = $mysqli->query($sqlLogs) or die($mysqli->error);
}

// Função para registrar a operação de exclusão de usuário no log
function logExclusaoUsuario($mysqli, $id) {
    // Consulta o nome do usuário com base no ID
    $sqlNomeUsuario = "SELECT nome FROM usuarios WHERE id = $id";
    $queryNomeUsuario = $mysqli->query($sqlNomeUsuario) or die($mysqli->error);
    $rowNomeUsuario = $queryNomeUsuario->fetch_assoc();
    $nomeUsuario = $rowNomeUsuario['nome'];
    $sqlLogs = "INSERT INTO logsusuarios (id_usuario, nome_usuario, tipo_operacao, data_operacao) VALUES ('$id', '$nomeUsuario', 'Excluído', NOW())";
    $queryLogs = $mysqli->query($sqlLogs) or die($mysqli->error);
}
?>

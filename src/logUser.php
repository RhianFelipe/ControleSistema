<?php
session_start();

// Função para executar consultas SQL e registrar no log
function executaConsultaELog($mysqli, $sql, $idUsuario, $logMessage)
{
    $result =  $mysqli->query($sql) or die($mysqli->error);
    if ($result) {
        logOperacaoUsuario($mysqli, $idUsuario, $logMessage);
        return $result;
    }
}

// Função genérica para registrar operações no log de usuários
function logOperacaoUsuario($mysqli, $id, $tipoOperacao)
{
    // Consulta os dados do usuário com base no ID
    $sqlNomeUsuario = "SELECT nome,email,grupo FROM usuarios WHERE id = $id";
    $queryNomeUsuario = $mysqli->query($sqlNomeUsuario) or die($mysqli->error);
    $rowNomeUsuario = $queryNomeUsuario->fetch_assoc();
    $nomeUsuario = $rowNomeUsuario['nome'];
    $emailUsuario = $rowNomeUsuario['email'];
    $grupoUsuario = $rowNomeUsuario['grupo'];

    // Obtém o valor da variável de sessão $_SESSION['nome']
    $nomeAdmin = $_SESSION['nome'];

    // Insere o registro de log no banco de dados, incluindo o valor de $_SESSION['nome']
    $sqlLogs = "INSERT INTO logsusuarios (id_usuario, nome_usuario, email_usuario, grupo_usuario, tipo_operacao, nome_admin, data_operacao) VALUES ('$id', '$nomeUsuario', '$emailUsuario', '$grupoUsuario', '$tipoOperacao', '$nomeAdmin', NOW())";
    $queryLogs = $mysqli->query($sqlLogs) or die($mysqli->error);
}
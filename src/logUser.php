
<?php
include "../db/conexao.php";

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

    // Insere o registro de log no banco de dados
    $sqlLogs = "INSERT INTO logsusuarios (id_usuario, nome_usuario,email_usuario, grupo_usuario ,tipo_operacao, data_operacao) VALUES ('$id', '$nomeUsuario','$emailUsuario',' $grupoUsuario', '$tipoOperacao', NOW())";
    $queryLogs = $mysqli->query($sqlLogs) or die($mysqli->error);
}

// Função para registrar a operação de criação de usuário no log
function logCriacaoUsuario($mysqli, $id)
{
    logOperacaoUsuario($mysqli, $id, 'Criado');
}

// Função para registrar a operação de atualização de usuário no log
function logAtualizacaoUsuario($mysqli, $id)
{
    logOperacaoUsuario($mysqli, $id, 'Usuário Atualizado');
}

// Função para registrar a operação de exclusão de usuário no log
function logExclusaoUsuario($mysqli, $id)
{
    logOperacaoUsuario($mysqli, $id, 'Excluído');
}

function logAddSistemPerson($mysqli, $id)
{

    logOperacaoUsuario($mysqli, $id, 'Add Sistema Personalizado');
}

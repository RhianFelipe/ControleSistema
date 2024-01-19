<?php
include "../../db/conexao.php";
$nomeSistema = $_GET['nomeSistema'];
$adicionarParaTodos = $_GET['adicionarParaTodos'];

if ($adicionarParaTodos === '1') {
    // Lógica para excluir permissões para o sistema especificado
    $excluirPermissoes = "DELETE FROM permissoes WHERE sistemas = '$nomeSistema'";
    $queryExcluirPermissoes = $mysqli->query($excluirPermissoes) or die($mysqli->error);

    // Lógica para excluir o sistema do banco de dados
    $excluirSistema = "DELETE FROM admin WHERE nomeSistema = '$nomeSistema'";
    $queryExcluirSistema = $mysqli->query($excluirSistema) or die($mysqli->error);

    echo json_encode(['status' => true, 'message' => 'Exclusão do sistema concluída para todos os usuários.']);
} else {
    // Lógica para excluir o sistema do banco de dados
    $excluirSistema = "DELETE FROM admin WHERE nomeSistema = '$nomeSistema'";
    $queryExcluirSistema = $mysqli->query($excluirSistema) or die($mysqli->error);

    echo json_encode(['status' => true, 'message' => 'Exclusão do sistema concluída.']);
}

<?php
include "../db/conexao.php";
include "../src/logUser.php";

$idUsuario = filter_input(INPUT_GET, 'idUsuario', FILTER_SANITIZE_SPECIAL_CHARS);
$nomeSistema = filter_input(INPUT_GET, 'nomeSistema', FILTER_SANITIZE_SPECIAL_CHARS);


if (empty($idUsuario) || empty($nomeSistema)) {
    $retorna = ['status' => false, 'msg' => "Erro: ID do usuário ou nome do sistema vazio."];
    echo json_encode($retorna);
} else {

    // Excluir as permissões associadas ao sistema
    $sqlDeletePermissoes = "DELETE FROM permissoes WHERE id_usuario = $idUsuario AND sistemas = '$nomeSistema'";
    $query = $mysqli->query($sqlDeletePermissoes) or die($mysqli->error);

    if ($query) {
        // Se a exclusão foi bem-sucedida
        logOperacaoUsuario($mysqli, $idUsuario, 'Sistema do Usuário excluido');
        $retorna = ['status' => true, 'msg' => "Sistema e suas permissões excluídos com sucesso"];
    } else {
        // Se ocorreu um erro ao excluir
        $retorna = ['status' => false, 'msg' => "Erro ao excluir o sistema e suas permissões"];
    }

    echo json_encode($retorna);
}
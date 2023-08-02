<?php
include "../db/conexao.php";

$idUsuario = filter_input(INPUT_GET, 'idUsuario', FILTER_SANITIZE_NUMBER_INT);
$nomeSistema = filter_input(INPUT_GET, 'nomeSistema', FILTER_SANITIZE_STRING);

if (empty($idUsuario) || empty($nomeSistema)) {
    $retorna = ['status' => false, 'msg' => "Erro: ID do usuário ou nome do sistema vazio."];
    echo json_encode($retorna);
} else {
    try {
        // Excluir as permissões associadas ao sistema
        $sqlDeletePermissoes = "DELETE FROM permissoes WHERE id_usuario = $idUsuario AND sistemas = '$nomeSistema'";
        $mysqli->query($sqlDeletePermissoes);

        // Se tudo ocorrer corretamente, commit a transação
        $mysqli->commit();

        $retorna = ['status' => true, 'msg' => "Sistema e suas permissões excluídos com sucesso"];
        echo json_encode($retorna);
    } catch (Exception $e) {
        // Em caso de erro, rollback a transação para desfazer todas as operações
        $mysqli->rollback();

        $retorna = ['status' => false, 'msg' => "Erro ao excluir o sistema e suas permissões"];
        echo json_encode($retorna);
    }
}
?>

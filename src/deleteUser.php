<?php
include "../db/conexao.php";
include_once "../src/logUser.php";

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (empty($id)) {
    $retorna = ['status' => false, 'msg' => "Erro: Campo ID vazio."];
    echo json_encode($retorna);
} else {
    // Log de exclusão de Usuário
    logOperacaoUsuario($mysqli, $id, 'Excluído');

    // Mover os dados para a tabela de desativados
    $sqlInsert = "INSERT INTO desativados (nome, email, sistema, permissao, data_exclusao, nome_termo, assinado, grupo, setor, nomeSid, valorSid)
    SELECT u.nome, u.email, p.sistemas, p.permissao, NOW() AS data_exclusao, 
           t.nome_termo, t.assinado, u.grupo, u.setor, s.nomeSid, s.valorSid
    FROM usuarios u
    JOIN permissoes p ON u.id = p.id_usuario
    LEFT JOIN termos_assinados t ON u.id = t.id_usuario
    LEFT JOIN sid s ON u.id = s.id_usuario
    WHERE u.id = $id;
";

    // Excluir os registros das tabelas originais
    $sqlDeletePermissoes = "DELETE FROM permissoes WHERE id_usuario = $id";
    $sqlDeleteUsuarios = "DELETE FROM usuarios WHERE id = $id";
    $sqlDeleteTermos = "DELETE FROM termos_assinados WHERE id_usuario = $id";
    $sqlDeleteSids = "DELETE FROM sid WHERE id_usuario = $id";

    // Inicie uma transação
    $mysqli->begin_transaction();

    try {
        // Executar a query de inserção
        $mysqli->query($sqlInsert);
        // Executar a query de exclusão das permissões
        $mysqli->query($sqlDeletePermissoes);
        // Executar a query de exclusão dos termos assinados
        $mysqli->query($sqlDeleteTermos);
        // Executar a query de exclusão do usuário
        $mysqli->query($sqlDeleteUsuarios);
        // Executar a query de exclusão do SID
        $mysqli->query($sqlDeleteSids);

        // Confirmar a transação
        $mysqli->commit();

        $retorna = ['status' => true, 'msg' => "Usuário deletado com sucesso!"];
        echo json_encode($retorna);
    } catch (Exception $e) {
        // Em caso de erro, faça um rollback
        $mysqli->rollback();

        $retorna = ['status' => false, 'msg' => "ERRO: Não foi possível deletar o Usuário!"];
        echo json_encode($retorna);
    }
}

<?php
include "../db/conexao.php";
include_once "../src/logUser.php";

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (empty($id)) {
    $retorna = ['status' => false, 'msg' => "Erro: Campo ID vazio." ];
    echo json_encode($retorna);
} else {
    // Log de exclusão de Usuário
    logOperacaoUsuario($mysqli, $id,'Excluído');

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

    // Executar a query de inserção
    $queryInsert = $mysqli->query($sqlInsert) or die($mysqli->error);

    // Excluir os registros das tabelas originais
    $sqlDeletePermissoes = "DELETE FROM permissoes WHERE id_usuario = $id";
    $sqlDeleteUsuarios = "DELETE FROM usuarios WHERE id = $id";
    $sqlDeleteTermos = "DELETE FROM termos_assinados WHERE id_usuario = $id";
    $sqlDeleteSids = "DELETE FROM sid WHERE id_usuario = $id";

    // Executar a query de exclusão das permissões
    $queryDeletePermi = $mysqli->query($sqlDeletePermissoes) or die($mysqli->error);
    // Executar a query de exclusão dos termos assinados
    $queryDeleteTermos = $mysqli->query($sqlDeleteTermos) or die($mysqli->error);
    // Executar a query de exclusão do usuário
    $queryDeleteUser = $mysqli->query($sqlDeleteUsuarios) or die($mysqli->error);
    // Executar a query de exclusão do usuário
    $queryDeleteSid = $mysqli->query($sqlDeleteSids) or die($mysqli->error);

    // Se todas as queries estiverem corretas, retorne true
    if ($queryInsert && $queryDeletePermi && $queryDeleteTermos && $queryDeleteUser && $queryDeleteSid) {
         $retorna = ['status' => true, 'msg' => "Usuário deletado com sucesso!"];
         echo json_encode($retorna);
    } else {
        $retorna = ['status' => false, 'msg' => "ERRO: Não foi possível deletar o Usuário!"];
        echo json_encode($retorna);
    }
}

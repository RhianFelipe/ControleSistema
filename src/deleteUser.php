<?php
include_once "../db/conexao.php";
include_once "../src/logUser.php";

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (empty($id)) {
    $retorna = ['status' => false, 'msg' => "Erro: Campo ID vazio." ];
    echo json_encode($retorna);
} else {
 
    logExclusaoUsuario($mysqli, $id);
    // Mover os dados para a tabela de desativados
    $sqlInsert = "INSERT INTO desativados (nome, email, sistema, permissao, data_exclusao)
    SELECT u.nome, u.email, p.sistemas, p.permissao, NOW() AS data_exclusao
    FROM usuarios u
    JOIN permissoes p ON u.id = p.id_usuario
    WHERE u.id = $id";
    // Executar a query de inserção
    $queryInsert = $mysqli->query($sqlInsert) or die($mysqli->error);

    // Excluir os registros das tabelas originais
    $sqlDeletePermissoes = "DELETE FROM permissoes WHERE id_usuario = $id";
    $sqlDeleteUsuarios = "DELETE FROM usuarios WHERE id = $id";
       // Crie a consulta SQL para inserir o registro de log
 

    // Executar a query de exclusão das permissões
    $queryDeletePermi = $mysqli->query($sqlDeletePermissoes) or die($mysqli->error);

    // Executar a query de exclusão do usuário
    $queryDeleteUser = $mysqli->query($sqlDeleteUsuarios) or die($mysqli->error);

 

    if ($queryInsert && $queryDeletePermi && $queryDeleteUser) {
 
        $retorna = ['status' => true, 'msg' => "Deletado com Sucesso", 'ID' => $id];
        echo json_encode($retorna);
    }
}
?>

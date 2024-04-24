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

    // Consulta para selecionar id, nome e email do usuário
    $sqlUsuarioInfo = "SELECT id, nome, email, grupo, data_create, setor
                   FROM usuarios
                   WHERE id = $id";

    $resultUsuarioInfo = $mysqli->query($sqlUsuarioInfo);

    if ($resultUsuarioInfo->num_rows > 0) {
        // Extrair os dados do resultado
        $row =  $resultUsuarioInfo->fetch_assoc();
        $id = $row["id"];
        $nome = $row["nome"];
        $email = $row["email"];
        $grupo = $row["grupo"];
        $setor = $row["setor"];
        $data_create = $row["data_create"];

        $sqlInsertDesativadosNomeEmailGrupoSetor = "INSERT INTO desativados.usuarios (id, nome, email, grupo, setor, data_create, data_delete)
        VALUES ($id, '$nome', '$email', '$grupo', '$setor', '$data_create', NOW())";

        $mysqli->query($sqlInsertDesativadosNomeEmailGrupoSetor);
    }

    // Consulta para selecionar sistemas e permissões do usuário
    $sqlPermissoes = "SELECT sistemas, permissao
                  FROM permissoes
                  WHERE id_usuario = $id";

    $resultPermissoes = $mysqli->query($sqlPermissoes);


    if ($resultPermissoes->num_rows > 0) {
        // Extrair os dados do resultado e inserir na tabela 'desativados'
        while ($row = $resultPermissoes->fetch_assoc()) {
            $sistemas = $row["sistemas"];
            $permissao = $row["permissao"];

            // Consulta para inserir dados na tabela 'desativados' para permissões
            $sqlInsertPermissoes = "INSERT INTO desativados.permissoes (id_usuario, sistemas, permissao) 
                                VALUES ($id, '$sistemas', '$permissao')";
            $mysqli->query($sqlInsertPermissoes);
        }
    }

    // Consulta para selecionar os termos assinados pelo usuário
    $sqlTermosAssinados = "SELECT nome_termo, assinado
    FROM termos_assinados
    WHERE id_usuario = $id";

    $resultTermosAssinados = $mysqli->query($sqlTermosAssinados);

    if ($resultTermosAssinados->num_rows > 0) {
        // Extrair os dados do resultado e inserir na tabela 'desativados'
        while ($row = $resultTermosAssinados->fetch_assoc()) {
            $nome_termo = $row["nome_termo"];
            $assinado = $row["assinado"];

            // Consulta para inserir dados na tabela 'desativados' para termos assinados
            $sqlInsertTermosAssinados = "INSERT INTO desativados.termos_assinados (id_usuario, nome_termo, assinado) 
                                      VALUES ($id, '$nome_termo', '$assinado')";
            $mysqli->query($sqlInsertTermosAssinados);
        }
    }

    // Consulta para selecionar o SID do usuário
    $sqlSid = "SELECT nomeSid, valorSid
    FROM sid
    WHERE id_usuario = $id";

    $resultSid = $mysqli->query($sqlSid);

    if ($resultSid->num_rows > 0) {
        // Extrair os dados do resultado e inserir na tabela 'desativados'
        while ($row = $resultSid->fetch_assoc()) {
            $nomeSid = $row["nomeSid"];
            $valorSid = $row["valorSid"];

            // Consulta para inserir dados na tabela 'desativados' para SID
            $sqlInsertSid = "INSERT INTO desativados.sid (id_usuario, nomeSid, valorSid) 
                         VALUES ($id, '$nomeSid', '$valorSid')";
            $mysqli->query($sqlInsertSid);
        }
    }


    // Excluir os registros das tabelas originais
    $sqlDeletePermissoes = "DELETE FROM permissoes WHERE id_usuario = $id";
    $sqlDeleteUsuarios = "DELETE FROM usuarios WHERE id = $id";
    $sqlDeleteTermos = "DELETE FROM termos_assinados WHERE id_usuario = $id";
    $sqlDeleteSids = "DELETE FROM sid WHERE id_usuario = $id";

    // Inicie uma transação
    $mysqli->begin_transaction();

    try {
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
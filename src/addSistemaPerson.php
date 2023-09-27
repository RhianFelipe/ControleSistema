<?php
include "../db/conexao.php";
include "../src/logUser.php";

$sistemaPersonalizado = filter_input(INPUT_GET, 'sistema', FILTER_SANITIZE_SPECIAL_CHARS);
$idUsuario = filter_input(INPUT_GET, 'idUsuario', FILTER_SANITIZE_NUMBER_INT);

if (empty($sistemaPersonalizado) || empty($idUsuario)) {
    $retorna = ['status' => false, 'msg' => "Erro: Nome do sistema vazio."];
    echo json_encode($retorna);
} else {
    try {
        // Inserir o sistema personalizado na tabela de permissoes
        $sqlInserirSistema = "INSERT INTO permissoes (id_usuario, sistemas, permissao) VALUES ($idUsuario, '$sistemaPersonalizado', 0)";
        $mysqli->query($sqlInserirSistema);
        logOperacaoUsuario($mysqli, $idUsuario, 'Add Sistema Personalizado');
        $retorna = ['status' => true, 'msg' => "Sistema personalizado adicionado com sucesso"];
        echo json_encode($retorna);
    } catch (Exception $e) {
        $retorna = ['status' => false, 'msg' => "Erro ao adicionar o sistema personalizado"];
        echo json_encode($retorna);
    }
}

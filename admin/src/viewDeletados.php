<?php
include_once "../../db/conexao.php";

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);


$retorna = [];

if (isset($id)) {
    $sqlUsuario = "SELECT * FROM desativados WHERE id_usuario = $id";
    $resultUsuario = $mysqli->query($sqlUsuario);
    
    // Verifica se há resultados
    if ($resultUsuario->num_rows > 0) {
        // Obtém a linha do usuário
        $usuarioRow = $resultUsuario->fetch_assoc();
        // Atribui os resultados ao array $retorna
        $retorna = [
            'status' => true,
            'usuario' => $usuarioRow
        ];
    } else {
        $retorna = ['status' => false, 'msg' => "Nenhum usuário encontrado com o ID fornecido"];
    }
} else {
    $retorna = ['status' => false, 'msg' => "ERRO: ID do usuário não informado!"];
}


echo json_encode($retorna);
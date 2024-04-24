<?php
include_once "../db/conexao.php";
include "../db/consulta.php";

// Obtém os dados da requisição GET
$dados = $_GET;

// Extrai o ID do usuário e o novo nome do array de dados
$idUsuario = $dados['id'];
$novoNome = $dados['novoNome'];


// Verifica se o novo nome não é vazio
if (empty($novoNome)) {
    echo json_encode(['status' => false, 'msg' => 'O novo nome não pode ser vazio.']);
    exit();
}

$existeNome = verificarExistencia($mysqli, 'nome', 'usuarios', $novoNome);
if ($existeNome->num_rows > 0) {
    echo json_encode(['status' => false, 'msg' => 'Esse nome já existe.']);
    exit();
}

$sqlUpdate = "UPDATE usuarios SET nome = '$novoNome' WHERE id = $idUsuario";
$result = $mysqli->query($sqlUpdate);

if ($result) {
    echo json_encode(['status' => true, 'msg' => 'Nome atualizado com sucesso.']);
} else {
    echo json_encode(['status' => false, 'msg' => 'Erro ao atualizar o nome no banco de dados.']);
}
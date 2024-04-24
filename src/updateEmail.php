<?php
include_once "../db/conexao.php";
include "../db/consulta.php";

// Obtém os dados da requisição GET
$dados = $_GET;

// Extrai o ID do usuário e o novo email do array de dados
$idUsuario = $dados['id'];
$novoEmail = $dados['novoEmail'];

// Verifica se o novo email não é vazio
if (empty($novoEmail)) {
    echo json_encode(['status' => false, 'msg' => 'O novo email não pode ser vazio.']);
    exit();
}

// Verifica se o email tem o domínio esperado
$dominioEsperado = ".pr.gov.br";
$dominioEmail = substr($novoEmail, -strlen($dominioEsperado));

if (strcasecmp($dominioEmail, $dominioEsperado) !== 0) {
    echo json_encode(['status' => false, 'msg' => "O email deve ser do domínio $dominioEsperado"]);
    exit();
}

$existeEmail = verificarExistencia($mysqli, 'email', 'usuarios', $novoEmail);
if ($existeEmail->num_rows > 0) {
    echo json_encode(['status' => false, 'msg' => 'Esse email já existe.']);
    exit();
}

$sqlUpdate = "UPDATE usuarios SET email = '$novoEmail' WHERE id = $idUsuario";
$result = $mysqli->query($sqlUpdate);

if ($result) {
    echo json_encode(['status' => true, 'msg' => 'Email atualizado com sucesso.']);
} else {
    echo json_encode(['status' => false, 'msg' => 'Erro ao atualizar o email no banco de dados.']);
}
?>
<?php
include_once "../../db/conexao.php";
include "../../src/logUser.php";

$dados = $_GET;

$idUsuario = $dados['id'];
$novoSid = $dados['novoSid'];

// Verifica se o novo SID não é vazio
if (empty($novoSid) || $novoSid === "0") {
  echo json_encode(['status' => false, 'message' => 'O SID não pode ser vazio ou igual a "0".']);
  exit();
}

// Verifica se o novo SID é diferente do SID existente no banco de dados
$sqlCheckSid = "SELECT valorSid FROM sid WHERE id_usuario = $idUsuario";
$resultCheckSid = $mysqli->query($sqlCheckSid);

if ($resultCheckSid) {
  $rowCheckSid = $resultCheckSid->fetch_assoc();
  $sidExistente = $rowCheckSid['valorSid'];
  
  if ($novoSid === $sidExistente) {
    echo json_encode(['status' => false, 'message' => 'O novo SID deve ser diferente do SID existente.']);
    exit();
  }
} else {
  echo json_encode(['status' => false, 'message' => 'Erro ao verificar o SID existente.']);
  exit();
}

// Aqui você pode realizar a atualização no banco de dados usando os valores recebidos

// Exemplo de SQL (lembre-se de validar e sanitizar os valores antes de usá-los no SQL)
$sqlUpdate = "UPDATE sid SET valorSid = '$novoSid' WHERE id_usuario = $idUsuario";
$result = $mysqli->query($sqlUpdate);

if ($result) {
  // Atualização bem-sucedida
  echo json_encode(['status' => true]);
} else {
  // Erro na atualização
  echo json_encode(['status' => false, 'message' => 'Erro ao atualizar o SID no banco de dados.']);
}
?>

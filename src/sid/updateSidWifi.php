<?php
include_once "../../db/conexao.php";

$dados = $_GET;

$idUsuario = $dados['id'];
$novoSid = $dados['novoSid'];

// Verifica se o novo SID não é vazio
if (empty($novoSid) || $novoSid === "0") {
  echo json_encode(['status' => false, 'msg' => 'O SID não pode ser vazio ou igual a "0".']);
  exit();
}

// Verifica se o novo SID é diferente do SID existente no banco de dados
$sqlCheckSid = "SELECT valorSid FROM sid WHERE id_usuario = $idUsuario AND nomeSid = 'Wi-Fi'";
$resultCheckSid = $mysqli->query($sqlCheckSid);


if ($resultCheckSid) {
  $rowCheckSid = $resultCheckSid->fetch_assoc();
  $sidExistente = $rowCheckSid['valorSid'];
  
  if ($novoSid === $sidExistente) {
    echo json_encode(['status' => false, 'msg' => 'O novo SID deve ser diferente do SID existente.']);
    exit();
  }
} else {
  echo json_encode(['status' => false, 'msg' => 'Erro ao verificar o SID existente.']);
  exit(); 
}


$sqlUpdate = "UPDATE sid SET valorSid = '$novoSid' WHERE id_usuario = $idUsuario AND  nomeSid = 'Wi-Fi'";
$result = $mysqli->query($sqlUpdate);

$sqlSistemaUpdate = "UPDATE permissoes SET permissao = 1  WHERE id_usuario = $idUsuario AND sistemas = 'Wi-Fi'";
$resultSistema = $mysqli->query($sqlSistemaUpdate);

if ($result) {
  // Atualização bem-sucedida
  echo json_encode(['status' => true , 'msg' => 'SID atualizado com sucesso.']);
} else {
  // Erro na atualização
  echo json_encode(['status' => false, 'msg' => 'Erro ao atualizar o SID no banco de dados.']);
}

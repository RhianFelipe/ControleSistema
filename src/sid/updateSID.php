<?php
include "../../db/conexao.php";
include_once "../logUser.php";
$dados = $_GET;

$idUsuario = $dados['id'];
$novoSid = $dados['novoSid'];
$nomeSistema = $dados['nomeSid'];

// Verifica se o novo SID não é vazio
if (empty($novoSid) || $novoSid === "0" || !preg_match('/^\d{2}\.\d{3}\.\d{3}-\d$/', $novoSid)) {
  echo json_encode(['status' => false, 'msg' => 'O SID é inválido.']);
  exit();
}

// Verifica se o novo SID é diferente do SID existente no banco de dados para o sistema especificado
$sqlCheckSid = "SELECT valorSid FROM sid WHERE id_usuario = $idUsuario AND nomeSid = '$nomeSistema'";
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

// Verifica se já existe uma entrada para 'Wi-Fi' ou 'VPN' na tabela permissoes
$sqlCheckSistemas = "SELECT sistemas FROM permissoes WHERE id_usuario = $idUsuario AND sistemas IN ('Wi-Fi', 'VPN')";
$resultCheckSistemas = $mysqli->query($sqlCheckSistemas);

$permissoesExistentes = array();
while ($rowCheckSistema = $resultCheckSistemas->fetch_assoc()) {
  $permissoesExistentes[] = $rowCheckSistema['sistemas'];
}

// Verifique se deve inserir uma nova permissão
$inserirPermissao = false;

if ($nomeSistema === 'Wi-Fi' && !in_array('Wi-Fi', $permissoesExistentes)) {
  $inserirPermissao = true;
} elseif ($nomeSistema === 'VPN' && !in_array('VPN', $permissoesExistentes)) {
  $inserirPermissao = true;
}

if ($inserirPermissao) {
  // Inserir nova permissão
  $sistemas = $nomeSistema;
  $permissao = 1;

  $sqlInsertPermissao = "INSERT INTO permissoes (id_usuario, sistemas, permissao, data_altere)
    VALUES ($idUsuario, '$sistemas', $permissao, NOW())";

  $resultInsertPermissao = $mysqli->query($sqlInsertPermissao);

  if (!$resultInsertPermissao) {
    echo json_encode(['status' => false, 'msg' => 'Erro ao inserir permissão no banco de dados.']);
    exit();
  }
}

// Atualizar o SID
$sqlUpdate = "UPDATE sid SET valorSid = '$novoSid' WHERE id_usuario = $idUsuario AND nomeSid = '$nomeSistema'";
if (executaConsultaELog($mysqli, $sqlUpdate, $idUsuario, 'SID Atualizado')) {
  echo json_encode(['status' => true, 'msg' => 'SID atualizado com sucesso.']);
} else {
  echo json_encode(['status' => false, 'msg' => 'Erro ao atualizar o SID no banco de dados.']);
}

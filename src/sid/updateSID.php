<?php
include_once "../../db/conexao.php";

$dados = $_GET;

$idUsuario = $dados['id'];
$novoSid = $dados['novoSid'];
$nomeSistema = $dados['nomeSid'];

// Verifica se o novo SID não é vazio
if (empty($novoSid) || $novoSid === "0") {
  echo json_encode(['status' => false, 'msg' => 'O SID não pode ser vazio ou igual a "0".']);
  exit();
}

// Verifique se a string contém pontos e traços
if (!preg_match('/^\d{2}\.\d{3}\.\d{3}-\d$/', $novoSid)) {
  echo json_encode(['status' => false, 'msg' => 'O formato do número do protocolo está incorreto.']);
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

// Verifica se já existe uma entrada para 'Wi-Fi' na tabela permissoes
$sqlCheckWiFi = "SELECT id FROM permissoes WHERE id_usuario = $idUsuario AND sistemas = 'Wi-Fi'";
$resultCheckWiFi = $mysqli->query($sqlCheckWiFi);

// Verifica se já existe uma entrada para 'VPN' na tabela permissoes
$sqlCheckVPN = "SELECT id FROM permissoes WHERE id_usuario = $idUsuario AND sistemas = 'VPN'";
$resultCheckVPN = $mysqli->query($sqlCheckVPN);

// Verifique se deve inserir uma nova permissão
$inserirPermissao = false;

if ($nomeSistema === 'Wi-Fi' && ($resultCheckWiFi->num_rows === 0)) {
  $inserirPermissao = true;
} elseif ($nomeSistema === 'VPN' && ($resultCheckVPN->num_rows === 0)) {
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
$result = $mysqli->query($sqlUpdate);

if ($result) {
  echo json_encode(['status' => true, 'msg' => 'SID atualizado com sucesso.']);
} else {
  echo json_encode(['status' => false, 'msg' => 'Erro ao atualizar o SID no banco de dados.']);
}
?>

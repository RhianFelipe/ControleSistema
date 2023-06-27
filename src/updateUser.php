<?php
include_once "../db/conexao.php";
include "../src/logUser.php";

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

// Verificar se algum campo está vazio
if (empty($dados['id'])) {
  $retorna = ['status' => false, 'msg' => "Erro: Campo ID vazio. ID: "];
  echo json_encode($retorna);
  exit; // Encerrar a execução do script
} else if (empty($dados['sistema'])) {
  $retorna = ['status' => false, 'msg' => "Erro: Sistema vazio ou indefinido."];
  echo json_encode($retorna);
  exit; // Encerrar a execução do script
} else if (empty($dados['permissao'])) {
  $retorna = ['status' => false, 'msg' => "Erro: Campo Permissão vazio"];
  echo json_encode($retorna);
  exit; // Encerrar a execução do script
} else {
  include_once "../db/conexao.php";

  // Recupera os valores dos sistemas enviados pelo formulário e do ID
  $sistemas = $dados['sistema'];
  $idUsuario = $dados['id'];

//Logs para atualização do Usuário
  logAtualizacaoUsuario($mysqli,$idUsuario);
  // Atualiza as permissões dos sistemas no banco de dados
  foreach ($sistemas as $index => $sistema) {
    $permissao = $dados['permissao'][$index];
    $novasPermissoes[$index] = $permissao;
    $novasSistemas =  $sistemas;
    // Realize a atualização no banco de dados
    $sql = "UPDATE permissoes SET permissao = $permissao, data_altere = NOW() WHERE id_usuario = $idUsuario AND sistemas = '$sistema'";

    $queryUpdate = $mysqli->query($sql) or die($mysqli->error);

    // Verifique se a atualização foi bem-sucedida e trate os erros, se necessário
  }

  if ($queryUpdate) {

    $retorna = ['status' => true, 'msg' => "Usuário editado com sucesso!", 'permissoes' => $novasPermissoes, 'Sistemas' => $novasSistemas];
    echo json_encode($retorna);
  }
 
}

?>
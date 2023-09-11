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

  // Logs para atualização do Usuário
  logOperacaoUsuario($mysqli, $idUsuario, 'Permissão Atualizada');

  // Verificar se o campo grupo está preenchido
  if (!empty($dados['grupo'])) {
    // Atualizar o grupo do usuário
    $novoGrupo = $dados['grupo'];
    $sqlGrupo = "UPDATE usuarios SET grupo = '$novoGrupo' WHERE id = $idUsuario";
    $queryUpdateGrupo = $mysqli->query($sqlGrupo) or die($mysqli->error);
  }

  if (!empty($dados['setor'])) {
    // Atualizar o setor do usuário
    $novoSetor = $dados['setor'];
    $sqlSetor = "UPDATE usuarios SET setor = '$novoSetor' WHERE id = $idUsuario";
    $queryUpdateSetor = $mysqli->query($sqlSetor) or die($mysqli->error);
  }

  if (!empty($dados['termo']) && !empty($dados['nome_termo'])) {
    // Recupera os valores dos termos enviados pelo formulário e os respectivos nomes
    $termos = $dados['termo'];
    $nomesTermo = $dados['nome_termo'];

    // Atualizar os termos assinados no banco de dados
    foreach ($termos as $index => $assinado) {
      $nomeTermo = $nomesTermo[$index];

      // Realizar a atualização no banco de dados
      $sqlTermo = "UPDATE termos_assinados SET assinado = $assinado WHERE id_usuario = $idUsuario AND nome_termo = '$nomeTermo'";
      $queryUpdateTermo = $mysqli->query($sqlTermo) or die($mysqli->error);

      // Verificar se a atualização foi bem-sucedida e tratar os erros, se necessário
    }
  }

  // Atualizar as permissões dos sistemas no banco de dados
  foreach ($sistemas as $index => $sistema) {
    $permissao = $dados['permissao'][$index];
    $novasPermissoes[$index] = $permissao;
    $novasSistemas = $sistemas;
    // Realizar a atualização no banco de dados
    $sql = "UPDATE permissoes SET permissao = $permissao, data_altere = NOW() WHERE id_usuario = $idUsuario AND sistemas = '$sistema'";

    $queryUpdate = $mysqli->query($sql) or die($mysqli->error);

    // Verificar se a atualização foi bem-sucedida e tratar os erros, se necessário
  }

  if ($queryUpdate) {
    $mensagem = "Usuário atualizado com sucesso!";
    $retorna = ['status' => true, 'msg' => $mensagem, 'permissoes' => $novasPermissoes, 'Sistemas' => $novasSistemas];
    echo json_encode($retorna);
  }
}

<?php
include_once "../db/conexao.php";

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

// Verificar se algum campo está vazio
if (empty($dados['id'])) {
  $retorna = ['status' => false, 'msg' => "Erro: Campo ID vazio. ID: " ];
  echo json_encode($retorna);
  exit; // Encerrar a execução do script
}

else if (empty($dados['sistema'])) {
  $retorna = ['status' => false, 'msg' => "Erro: Campo Sistema vazio. Sistema: "];
  echo json_encode($retorna);
  exit; // Encerrar a execução do script
}

else if (empty($dados['permissao'])) {
  $retorna = ['status' => false, 'msg' => "Erro: Campo Permissão vazio"];
  echo json_encode($retorna);
  exit; // Encerrar a execução do script
}else{

  include_once "../db/conexao.php";
  // Se todos os campos estão preenchidos, prosseguir com a lógica de atualização no banco de dados
  
  // Recupera os valores dos sistemas enviados pelo formulário
  $sistemas = $dados['sistema'];
  
  // Recupera o ID do usuário a ser atualizado
  $idUsuario = $dados['id'];

  // Atualiza as permissões dos sistemas no banco de dados
  foreach ($sistemas as $index => $sistema) {
    $permissao = isset($dados['permissao'][$sistema]) ? 1 : 0;
   
    // Realize a atualização no banco de dados
    $sql = "UPDATE permissoes SET permissao = $permissao WHERE id_usuario = $idUsuario AND sistemas = '$sistema'";
    $queryUpdate = $mysqli->query($sql) or die($mysqli->error);
  
    // Verifique se a atualização foi bem-sucedida e trate os erros, se necessário
  }
  if($queryUpdate && $permissao == 0 ){

    $retorna = ['status' => true, 'msg' => "Usuário editado com sucesso!"];
    echo json_encode($retorna);
  }
  
 
}

?>

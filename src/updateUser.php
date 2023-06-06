<?php
include_once "../db/conexao.php";

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if (empty($dados['sistemas'])) {
  $retorna = ['status' => false, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Não há Sistemas"];

} else {
    $id = $dados['id'];

    // Aqui você pode realizar a lógica de atualização no banco de dados
    // por exemplo, executar a consulta SQL para atualizar os dados

    // Exemplo de atualização do campo "sistemas"
    // Certifique-se de adaptar essa consulta de acordo com sua estrutura de banco de dados
    $sistemas = $dados['sistemas'];
    $sql = "UPDATE usuarios SET sistemas = '$sistemas' WHERE id_usuario = $id";
    // Execute a consulta usando $sql e $mysqli
 $retorna = ['status' => true, 'msg' => "<div class='alert alert-success' role='alert'>Usuário editado com sucesso!</div>"];
}

echo json_encode($retorna);
?>

<?php
include_once "../../db/conexao.php";

// Obtém os dados da requisição GET
$dados = $_GET;

// Extrai o ID do usuário do array de dados
$idUsuario = $dados['id'];

// Prepara a consulta SQL para excluir a conta do usuário
$sqlDelete = "DELETE FROM admin WHERE id = $idUsuario";

// Executa a consulta SQL
$result = $mysqli->query($sqlDelete);

// Verifica se a consulta foi bem-sucedida
if ($result) {
    echo json_encode(['status' => true, 'msg' => 'Conta excluída com sucesso.']);
} else {
    echo json_encode(['status' => false, 'msg' => 'Erro ao excluir a conta no banco de dados.']);
}

// Fecha a conexão com o banco de dados
$mysqli->close();

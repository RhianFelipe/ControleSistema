<?php
include_once "../../../db/conexao.php";

// Obtém os dados da requisição GET
$dados = $_GET;

// Extrai o ID do usuário e a nova senha do array de dados
$idUsuario = $dados['id'];
$novoSetor = $dados['novoSetor'];

// Verifica se a nova senha não é vazia
if (empty($novoSetor)) {
    echo json_encode(['status' => false, 'msg' => 'O nome do setor não pode ser vazia.']);
    exit();
}


// Prepara a consulta SQL para atualizar a senha na tabela 'admin'
$sqlUpdate = "UPDATE setores SET nomeSetor = '$novoSetor' WHERE id = $idUsuario";

// Executa a consulta SQL
$result = $mysqli->query($sqlUpdate);

// Verifica se a consulta foi bem-sucedida
if ($result) {
    echo json_encode(['status' => true, 'msg' => 'Setor atualizado com sucesso.']);
} else {
    echo json_encode(['status' => false, 'msg' => 'Erro ao atualizar o setor no banco de dados.']);
}

// Fecha a conexão com o banco de dados
$mysqli->close();

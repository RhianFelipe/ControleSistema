<?php
include_once "../../../db/conexao.php";

// Obtém os dados da requisição GET
$dados = $_GET;

// Extrai o novo nome do setor do array de dados
$novoSetor = $dados['novoSetor'];

// Verifica se o novo nome do setor não é vazio
if (empty($novoSetor)) {
    echo json_encode(['status' => false, 'msg' => 'O nome do setor não pode ser vazio.']);
    exit();
}

// Verifica se o setor já existe na tabela
$sqlVerificar = "SELECT COUNT(*) AS total FROM setores WHERE nomeSetor = '$novoSetor'";
$resultVerificar = $mysqli->query($sqlVerificar);
$row = $resultVerificar->fetch_assoc();
if ($row['total'] > 0) {
    echo json_encode(['status' => false, 'msg' => 'O setor já existe.']);
    exit();
}

// Prepara a consulta SQL para inserir o novo setor na tabela 'setores'
$sqlInsert = "INSERT INTO setores (nomeSetor) VALUES ('$novoSetor')";

// Executa a consulta SQL
$resultInsert = $mysqli->query($sqlInsert);

// Verifica se a consulta foi bem-sucedida
if ($resultInsert) {
    echo json_encode(['status' => true, 'msg' => 'Setor criado com sucesso.']);
} else {
    echo json_encode(['status' => false, 'msg' => 'Erro ao criar o setor no banco de dados.']);
}

// Fecha a conexão com o banco de dados
$mysqli->close();

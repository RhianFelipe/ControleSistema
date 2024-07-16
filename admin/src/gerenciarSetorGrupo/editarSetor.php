<?php
include_once "../../../db/conexao.php";

// Obtém os dados da requisição GET
$dados = $_GET;

// Extrai o ID do setor e o novo nome do setor do array de dados
$idSetor = $dados['id'];
$novoSetor = $dados['novoSetor'];

// Verifica se o novo nome do setor não é vazio
if (empty($novoSetor)) {
    echo json_encode(['status' => false, 'msg' => 'O nome do setor não pode ser vazio.']);
    exit();
}

// Obtém o nome antigo do setor
$sqlGetOldSetor = "SELECT nomeSetor FROM setores WHERE id = $idSetor";
$resultOldSetor = $mysqli->query($sqlGetOldSetor);
$oldSetor = $resultOldSetor->fetch_assoc()['nomeSetor'];

// Prepara a consulta SQL para atualizar o nome do setor na tabela 'setores'
$sqlUpdateSetor = "UPDATE setores SET nomeSetor = '$novoSetor' WHERE id = $idSetor";

// Executa a consulta SQL
$resultUpdateSetor = $mysqli->query($sqlUpdateSetor);

// Verifica se a consulta foi bem-sucedida
if ($resultUpdateSetor) {
    // Atualiza o nome do setor na tabela 'usuarios'
    $sqlUpdateUsuarios = "UPDATE usuarios SET setor = '$novoSetor' WHERE setor = '$oldSetor'";
    $resultUpdateUsuarios = $mysqli->query($sqlUpdateUsuarios);
    
    // Verifica se a atualização na tabela 'usuarios' foi bem-sucedida
    if ($resultUpdateUsuarios) {
        echo json_encode(['status' => true, 'msg' => 'Setor atualizado com sucesso e usuários atualizados.']);
    } else {
        echo json_encode(['status' => true, 'msg' => 'Setor atualizado, mas houve um erro ao atualizar os usuários.']);
    }
} else {
    echo json_encode(['status' => false, 'msg' => 'Erro ao atualizar o setor no banco de dados.']);
}

// Fecha a conexão com o banco de dados
$mysqli->close();
?>

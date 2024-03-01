<?php
include_once "../../db/conexao.php";

// Obtém os dados da requisição GET
$dados = $_GET;

// Extrai o ID do usuário e a nova senha do array de dados
$idUsuario = $dados['id'];
$novaSenha = $dados['novaSenha'];

// Verifica se a nova senha não é vazia
if (empty($novaSenha)) {
    echo json_encode(['status' => false, 'msg' => 'A nova senha não pode ser vazia.']);
    exit();
}

// Criptografa a nova senha usando a técnica de substituição simples
$senha_criptografada = '';
for ($i = 0; $i < strlen($novaSenha); $i++) {
    $char = $novaSenha[$i];
    $encrypted_char = chr(ord($char) + 3); // Desloca o caractere por 3 posições no código ASCII
    $senha_criptografada .= $encrypted_char;
}

// Prepara a consulta SQL para atualizar a senha na tabela 'admin'
$sqlUpdate = "UPDATE admin SET senha = '$senha_criptografada' WHERE id = $idUsuario";

// Executa a consulta SQL
$result = $mysqli->query($sqlUpdate);

// Verifica se a consulta foi bem-sucedida
if ($result) {
    echo json_encode(['status' => true, 'msg' => 'Senha atualizada com sucesso.']);
} else {
    echo json_encode(['status' => false, 'msg' => 'Erro ao atualizar a senha no banco de dados.']);
}

// Fecha a conexão com o banco de dados
$mysqli->close();

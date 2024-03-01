<?php
include "../../db/conexao.php";

// Define um array para armazenar a resposta
$resposta = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém os valores do formulário
    $usuario = $_POST['username'];
    $senha = $_POST['password'];
    $permissao_texto = $_POST['permission'];

    // Verifica se o nome de usuário e a senha não estão vazios
    if (empty($usuario) || empty($senha)) {
        $resposta['success'] = false;
        $resposta['mensagem'] = 'O nome de usuário e a senha são obrigatórios.';
    } else {
        // Converte a permissão de "Sim" ou "Não" para 0 ou 1
        $permissao = ($permissao_texto === 'Sim') ? 1 : 0;

        // Verifica se o usuário já existe
        $consultaUsuario = "SELECT id FROM admin WHERE usuario = '$usuario'";
        $resultadoConsulta = $mysqli->query($consultaUsuario);

        if ($resultadoConsulta->num_rows > 0) {
            // O usuário já existe, adiciona uma mensagem de erro à resposta
            $resposta['success'] = false;
            $resposta['mensagem'] = 'Usuário já existe. Por favor, escolha outro nome de usuário.';
        } else {
            // Criptografa a senha
            $senha_criptografada = '';
            for ($i = 0; $i < strlen($senha); $i++) {
                $char = $senha[$i];
                $encrypted_char = chr(ord($char) + 3);
                $senha_criptografada .= $encrypted_char;
            }

            // Realiza a inserção dos dados no banco de dados
            $inserirUsuario = "INSERT INTO admin (usuario, senha, permissao) VALUES ('$usuario', '$senha_criptografada', '$permissao')";

            if ($mysqli->query($inserirUsuario)) {
                // Inserção bem-sucedida, adiciona uma mensagem de sucesso à resposta
                $resposta['success'] = true;
                $resposta['mensagem'] = 'Usuário cadastrado com sucesso!';
            } else {
                // Erro na inserção, adiciona uma mensagem de erro à resposta
                $resposta['success'] = false;
                $resposta['mensagem'] = 'Ocorreu um erro ao cadastrar o usuário.';
            }
        }
    }

    // Fecha a conexão com o banco de dados
    $mysqli->close();
} else {
    // Se a requisição não for POST, adiciona uma mensagem de erro à resposta
    $resposta['success'] = false;
    $resposta['mensagem'] = 'Método de requisição inválido.';
}


// Retorna a resposta em formato JSON
header('Content-Type: application/json');
echo json_encode($resposta);

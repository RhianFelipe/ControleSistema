<?php
include "../../db/conexao.php";

// Pegando os valores dos dados
$nomeSistema = $_GET['nomeSistema'];
$adicionarParaTodos = $_GET['adicionarParaTodos'];

// Verifica se o sistema está vazio
if (empty($nomeSistema)) {
    echo json_encode(['status' => false, 'msg' => 'O nome do sistema está vazio.']);
    exit();
}

// Verifica se o sistema já existe
$verificarExistencia = "SELECT * FROM admin WHERE nomeSistema = '$nomeSistema'";
$resultadoVerificacao = $mysqli->query($verificarExistencia);

if ($resultadoVerificacao->num_rows > 0) {
    echo json_encode(['status' => false, 'msg' => 'Esse sistema já existe.']);
    exit();
}

// Se adicionarParaTodos estiver marcado
if ($adicionarParaTodos === '1') {
    // Inserir o sistema na tabela admin
    $inserirSistema = "INSERT INTO admin(nomeSistema) VALUES ('$nomeSistema')";
    $queryInserirSistema = $mysqli->query($inserirSistema) or die($mysqli->error);

    // Obter os IDs dos usuários
    $sqlUser = "SELECT id FROM usuarios";
    $queryUserID = $mysqli->query($sqlUser);

    // Inserir permissões para todos os usuários
    while ($row = mysqli_fetch_assoc($queryUserID)) {
        $idUsuario = $row['id'];
        $inserirPermissao = "INSERT INTO permissoes(id_usuario, sistemas, permissao) VALUES ($idUsuario, '$nomeSistema', 0)";
        $queryInserirPermissao = $mysqli->query($inserirPermissao) or die($mysqli->error);
    }

    echo json_encode(['status' => true, 'msg' => 'Sistema inserido com sucesso para todos os usuários.']);
} else {
    // Inserir o sistema na tabela admin
    $inserirSistema = "INSERT INTO admin(nomeSistema) VALUES ('$nomeSistema')";
    $queryInserirSistema = $mysqli->query($inserirSistema) or die($mysqli->error);

    echo json_encode(['status' => true, 'msg' => 'Sistema inserido com sucesso.']);
}
?>

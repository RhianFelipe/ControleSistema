<?php
include "../../db/conexao.php";

$idUsuario = filter_input(INPUT_GET, 'userID', FILTER_SANITIZE_SPECIAL_CHARS);
$newPassword = filter_input(INPUT_GET, 'newPassword', FILTER_SANITIZE_SPECIAL_CHARS);

if (empty($idUsuario) || empty($newPassword)) {
    $retorna = ['status' => false, 'msg' => "Erro: ID do usuário ou nova senha vazios."];
    echo json_encode($retorna);
} else {
    // Aplicando a criptografia fornecida ao novo password
    $senha_criptografada = '';
    for ($i = 0; $i < strlen($newPassword); $i++) {
        $char = $newPassword[$i];
        $encrypted_char = chr(ord($char) + 3);
        $senha_criptografada .= $encrypted_char;
    }

    $sqlUpdateSenha = "UPDATE admin SET senha = '$senha_criptografada' WHERE id = $idUsuario";
    $querySenha = $mysqli->query($sqlUpdateSenha) or die($mysqli->error);

    if ($querySenha) {
     
        $retorna = ['status' => true, 'msg' => "Senha alterada com sucesso"];
    } else {
        // Se ocorreu um erro ao alterar a senha
        $retorna = ['status' => false, 'msg' => "Erro ao alterar a senha"];
    }

    // Adicione operações adicionais aqui se necessário

    echo json_encode($retorna);
}
?>

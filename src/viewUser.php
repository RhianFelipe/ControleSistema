<?php
include_once "../db/conexao.php";

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (!empty($id)) {
    // Obter os dados do usuário
    $sqlUsuario = "SELECT id, nome, email, grupo FROM usuarios WHERE id = $id";
    $resultUsuario = $mysqli->query($sqlUsuario);
    $usuarioRow = $resultUsuario->fetch_assoc();

    if ($usuarioRow) {
        // Obter os dados de sistemas e permissões
        $sqlPermissoes = "SELECT sistemas, permissao FROM permissoes WHERE id_usuario = $id ORDER BY sistemas ASC";
        $resultPermissoes = $mysqli->query($sqlPermissoes);
        $permissoesRows = array();
        while ($permissoesRow = $resultPermissoes->fetch_assoc()) {
            $permissoesRows[] = $permissoesRow;
        }

        // Obter os dados de termos assinados
        $sqlTermos = "SELECT nome_termo, assinado FROM termos_assinados WHERE id_usuario = $id";
        $resultTermos = $mysqli->query($sqlTermos);
        $termosRows = array();
        while ($termosRow = $resultTermos->fetch_assoc()) {
            $termosRows[] = $termosRow;
        }

        $retorna = [
            'status' => true,
            'dados' => [
                'id_usuario' => $usuarioRow['id'],
                'nome' => $usuarioRow['nome'],
                'email' => $usuarioRow['email'],
                'grupo' => $usuarioRow['grupo'],
                'permissoes' => $permissoesRows,
                'termos' => $termosRows,
            ]
        ];
    } else {
        $retorna = ['status' => false, 'msg' => "Usuário não encontrado!"];
    }
} else {
    $retorna = ['status' => false, 'msg' => "ERRO: ID do usuário não informado!"];
}

echo json_encode($retorna);
?>

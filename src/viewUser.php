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
        $permissoesRows = $resultPermissoes->fetch_all(MYSQLI_ASSOC);

        // Obter os dados de termos assinados
        $sqlTermos = "SELECT nome_termo, assinado FROM termos_assinados WHERE id_usuario = $id";
        $resultTermos = $mysqli->query($sqlTermos);
        $termosRows = $resultTermos->fetch_all(MYSQLI_ASSOC);

        // Obter os valores de SID
        $sqlSIDTermoTur = "SELECT valorSid FROM sid WHERE id_usuario = $id AND nomeSid = 'TermoTur'";
        $resultSIDTermoTur = $mysqli->query($sqlSIDTermoTur);
        $sidValueTermoTur = "";
        if ($resultSIDTermoTur &&  $resultSIDTermoTur->num_rows > 0) {
            $sidRowTermos =  $resultSIDTermoTur->fetch_assoc();
            $sidValueTermoTur = $sidRowTermos['valorSid'];
        }

        $sqlSIDTermoTcc = "SELECT valorSid FROM sid WHERE id_usuario = $id AND nomeSid = 'TermoTcc'";
        $resultSIDTermoTcc = $mysqli->query($sqlSIDTermoTcc);
        $sidValueTermoTcc = "";
        if ($resultSIDTermoTcc  && $resultSIDTermoTcc->num_rows > 0) {
            $sidRowTermos = $resultSIDTermoTcc->fetch_assoc();
            $sidValueTermoTcc = $sidRowTermos['valorSid'];
        }

        $sqlSIDWiFI = "SELECT valorSid FROM sid WHERE id_usuario = $id AND nomeSid = 'Wi-Fi'";
        $resultSIDWiFI = $mysqli->query($sqlSIDWiFI);
        $sidValueWiFI = "";

        if ($resultSIDWiFI && $resultSIDWiFI->num_rows > 0) {
            $sidRowWiFI = $resultSIDWiFI->fetch_assoc();
            $sidValueWiFI = $sidRowWiFI['valorSid'];
        }

        $sqlSIDVPN = "SELECT valorSid FROM sid WHERE id_usuario = $id AND nomeSid = 'VPN'";
        $resultSIDVPN = $mysqli->query($sqlSIDVPN);
        $sidValueVPN = "";

        if ($resultSIDVPN && $resultSIDVPN->num_rows > 0) {
            $sidRowVPN = $resultSIDVPN->fetch_assoc();
            $sidValueVPN = $sidRowVPN['valorSid'];
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
                'sidTermoTur' => $sidValueTermoTur,
                'sidTermoTcc' => $sidValueTermoTcc,
                'sidWifi' => $sidValueWiFI, // Valor do SID para Wi-Fi
                'sidVPN' => $sidValueVPN  // Valor do SID para VPN
            ]
        ];
    } else {
        $retorna = ['status' => false, 'msg' => "Usuário não encontrado!"];
    }
} else {
    $retorna = ['status' => false, 'msg' => "ERRO: ID do usuário não informado!"];
}

echo json_encode($retorna);

<?php
include_once '../../db/conexao.php'; // Verifique o caminho correto para o arquivo de conexão

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

function consultarValorSID($mysqli, $id, $nomeSid)
{
    $sql = "SELECT valorSid FROM desativados.sid WHERE id_usuario = $id AND nomeSid = '$nomeSid'";
    $result = $mysqli->query($sql);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['valorSid'];
    }
    return "";
}

function consultarDados($mysqli, $id, $tabela, $campo)
{
    $sql = "SELECT $campo FROM desativados.$tabela WHERE id_usuario = $id";
    $result = $mysqli->query($sql);
    if ($result && $result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    return [];
}

if (!empty($id)) {
    $sqlUsuario = "SELECT id, nome, email, grupo, setor FROM desativados.usuarios WHERE id = $id";
    $resultUsuario = $mysqli->query($sqlUsuario);
    $usuarioRow = $resultUsuario->fetch_assoc();

    if ($usuarioRow) {
        $permissoesRows = consultarDados($mysqli, $id, 'permissoes', 'sistemas, permissao');
        $termosRows = consultarDados($mysqli, $id, 'termos_assinados', 'nome_termo, assinado');
        $sidValueTermoTur = consultarValorSID($mysqli, $id, 'TermoTur');
        $sidValueTermoTcc = consultarValorSID($mysqli, $id, 'TermoTcc');
        $sidValueWiFI = consultarValorSID($mysqli, $id, 'Wi-Fi');
        $sidValueVPN = consultarValorSID($mysqli, $id, 'VPN');

        $retorna = [
            'status' => true,
            'dados' => [
                'id_usuario' => $usuarioRow['id'],
                'nome' => $usuarioRow['nome'],
                'email' => $usuarioRow['email'],
                'grupo' => $usuarioRow['grupo'],
                'setor' => $usuarioRow['setor'],
                'permissoes' => $permissoesRows,
                'termos' => $termosRows,
                'sidTermoTur' => $sidValueTermoTur,
                'sidTermoTcc' => $sidValueTermoTcc,
                'sidWifi' => $sidValueWiFI,
                'sidVPN' => $sidValueVPN
            ]
        ];
    } else {
        $retorna = ['status' => false, 'msg' => "Usuário não encontrado!"];
    }
} else {
    $retorna = ['status' => false, 'msg' => "ERRO: ID do usuário não informado!"];
}

echo json_encode($retorna);

<?php
include "../db/conexao.php";
include "../db/consulta.php";
include "../src/logUser.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    $nome = $dados['nome'];
    $email = $dados['email'];
    $grupo = $dados['grupo'];
    $setor = $dados['setor'];
    $termoUso = isset($dados['termoUso']) ? 1 : 0;
    $termoCompromisso = isset($dados['termoCompromisso']) ? 1 : 0;
    $termoWifi = isset($dados['termoWi-Fi']) ? 1 : 0;
    $termoVPN = isset($dados['termoVPN']) ? 1 : 0;
    $sidTermos = $dados['sidTermos'];
    $sidWifi = $dados['sidWifi'];
    $sidVPN = $dados['sidVPN'];

    // Verifica se o nome ou o email já existem
    $existeNome = verificarExistencia($mysqli, 'nome', 'usuarios', $nome);
    $existeEmail = verificarExistencia($mysqli, 'email', 'usuarios', $email);
    $existeSid = verificarExistencia($mysqli, 'valorSid', 'sid', $sidTermos);
    if ($existeNome->num_rows > 0) {
        $retorna = ['status' => false, 'msg' => "Esse nome já existe."];
    } elseif ($existeEmail->num_rows > 0) {
        $retorna = ['status' => false, 'msg' => "Esse e-mail já existe."];
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $retorna = ['status' => false, 'msg' => "E-mail digitado errado."];
    } else {
        $dominioEsperado = ".pr.gov.br";
        $dominioEmail = substr($email, -strlen($dominioEsperado));

        if (strcasecmp($dominioEmail, $dominioEsperado) !== 0) {
            $retorna = ['status' => false, 'msg' => "E-mail deve ser do domínio $dominioEsperado"];
        } elseif (!preg_match('/^\d{2}\.\d{3}\.\d{3}-\d$/', $sidTermos)) {
            $retorna = ['status' => false, 'msg' => 'O formato do número do protocolo está incorreto.'];
        } elseif ($existeSid->num_rows > 0) {
            $retorna = ['status' => false, 'msg' => 'Este SID já existe.'];
        } else {
            // Inserir usuários no BD
            $mysqli->query("INSERT INTO usuarios (nome, email, grupo, setor, data_create) VALUES ('$nome', '$email', '$grupo','$setor', NOW())");

            // Obter o ID do novo usuário
            $idUsuario = $mysqli->insert_id;

            // Inserir as permissões para cada sistema
            foreach ($dados['sistemas'] as $nomeSistema => $valorPermissao) {
                $mysqli->query("INSERT INTO permissoes (id_usuario, sistemas, permissao) VALUES ('$idUsuario', '$nomeSistema', '$valorPermissao')");
            }

            // Inserir os valores dos termos assinados e SID
            $mysqli->query("INSERT INTO termos_assinados (id_usuario, nome_termo, assinado) VALUES ('$idUsuario', 'Termo de Uso e Responsabilidade', '$termoUso')");
            $mysqli->query("INSERT INTO termos_assinados (id_usuario, nome_termo, assinado) VALUES ('$idUsuario', 'Termo de Compromisso e Confidencialidade', '$termoCompromisso')");
            $mysqli->query("INSERT INTO termos_assinados (id_usuario, nome_termo, assinado) VALUES ('$idUsuario', 'Termo de Wi-Fi', '$termoWifi')");
            $mysqli->query("INSERT INTO termos_assinados (id_usuario, nome_termo, assinado) VALUES ('$idUsuario', 'Termo de VPN', '$termoVPN')");
            $mysqli->query("INSERT INTO sid(id_usuario,nomeSid, valorSid) VALUES ('$idUsuario', 'TermoTur', '$sidTermos')");
            $mysqli->query("INSERT INTO sid(id_usuario,nomeSid, valorSid) VALUES ('$idUsuario', 'TermoTcc', '$sidTermos')");
            $mysqli->query("INSERT INTO sid(id_usuario,nomeSid, valorSid) VALUES ('$idUsuario', 'Wi-Fi', '$sidWifi')");
            $mysqli->query("INSERT INTO sid(id_usuario,nomeSid, valorSid) VALUES ('$idUsuario', 'VPN', '$sidVPN')");

            // Adicionar o registro de log
            logOperacaoUsuario($mysqli, $idUsuario, 'Criado');

            $retorna = ['status' => true, 'msg' => "Usuário cadastrado com sucesso!"];
        }
    }

    echo json_encode($retorna);
}

mysqli_close($mysqli);

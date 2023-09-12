<?php
include "../db/conexao.php";
include "../db/consulta.php";
include "../src/logUser.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obter os valores do formulário
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    $nome = $dados['nome'];
    $email = $dados['email'];
    $grupo = $dados['grupo'];
    $setor = $dados['setor'];
    $termoUso = isset($dados['termoUso']) ? 1 : 0;
    $termoCompromisso = isset($dados['termoCompromisso']) ? 1 : 0;
    $sidTermos = $dados['sidTermos'];
    $sidWifi = $dados['sidWifi'];
    $sidVPN = $dados['sidVPN'];

    // Verificar se existe Nome e Email
    $existeNome = verificarExistencia($mysqli, "nome", "usuarios", $nome);
    $existeEmail = verificarExistencia($mysqli, "email", "usuarios", $email);

    if ($existeNome->num_rows > 0) {
        $retorna = ['status' => false, 'msg' => "Esse nome já existe."];
        echo json_encode($retorna);
    } else {
        if ($existeEmail->num_rows > 0) {
            $retorna = ['status' => false, 'msg' => "Esse e-mail já existe."];
            echo json_encode($retorna);
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $retorna = ['status' => false, 'msg' => "E-mail digitado errado."];
            echo json_encode($retorna);
        } else {
            $dominioEsperado = ".pr.gov.br";
            $dominioEmail = substr($email, -strlen($dominioEsperado));

            if (strcasecmp($dominioEmail, $dominioEsperado) !== 0) {
                $retorna = ['status' => false, 'msg' => "E-mail deve ser do domínio $dominioEsperado"];
                echo json_encode($retorna);
            } else {
                // Verificar se já existe um SID igual no banco de dados
                $existeSID = verificarExistencia($mysqli, "valorSid", "sid", $sidTermos);

                if ($existeSID->num_rows > 0) {
                    $retorna = ['status' => false, 'msg' => "Esse SID já existe."];
                    echo json_encode($retorna);
                } else {
                    // Inserir usuários no BD
                    $inserirUsuario = "INSERT INTO usuarios (nome, email, grupo, setor , data_create) VALUES ('$nome', '$email', '$grupo','$setor', NOW())";
                    mysqli_query($mysqli, $inserirUsuario);
                    // Obter o ID do novo usuário
                    $idUsuario = mysqli_insert_id($mysqli);

                    // Inserir as permissões para cada sistema
                    foreach ($dados['sistemas'] as $nomeSistema => $valorPermissao) {
                        $valorSelecionado = $valorPermissao;

                        // Inserir o valor selecionado no banco de dados
                        $inserirPermissao = "INSERT INTO permissoes (id_usuario, sistemas, permissao) VALUES ('$idUsuario', '$nomeSistema', '$valorSelecionado')";
                        mysqli_query($mysqli, $inserirPermissao);
                    }

                    // Inserir os valores dos termos assinados e SID
                    $inserirTermoUso = "INSERT INTO termos_assinados (id_usuario, nome_termo, assinado) VALUES ('$idUsuario', 'Termo de Uso e Responsabilidade', '$termoUso')";
                    mysqli_query($mysqli, $inserirTermoUso);

                    $inserirTermoCompromisso = "INSERT INTO termos_assinados (id_usuario, nome_termo, assinado) VALUES ('$idUsuario', 'Termo de Compromisso e Confidencialidade', '$termoCompromisso')";
                    mysqli_query($mysqli, $inserirTermoCompromisso);

                    $inserirSidTermos = "INSERT INTO sid(id_usuario,nomeSid, valorSid) VALUES ('$idUsuario', 'Termos', '$sidTermos')";
                    mysqli_query($mysqli, $inserirSidTermos);
                    $inserirSidWifi = "INSERT INTO sid(id_usuario,nomeSid, valorSid) VALUES ('$idUsuario', 'Wi-Fi', '$sidWifi')";
                    mysqli_query($mysqli, $inserirSidWifi);
                    $inserirSidVPN = "INSERT INTO sid(id_usuario,nomeSid, valorSid) VALUES ('$idUsuario', 'VPN', '$sidVPN')";
                    mysqli_query($mysqli, $inserirSidVPN );
                    // Adicionar o registro de log
                    logOperacaoUsuario($mysqli, $idUsuario, 'Criado');

                    $retorna = ['status' => true, 'msg' => "Usuário cadastrado com sucesso!"];
                    echo json_encode($retorna);
                }
            }
        }
    }
}

// Fecha a conexão com o banco de dados
mysqli_close($mysqli);
?>

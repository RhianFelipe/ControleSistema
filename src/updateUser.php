<?php
include_once "../db/conexao.php";
include "../src/logUser.php";

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

// Verificar se algum campo está vazio
if (empty($dados['id']) || empty($dados['sistema']) || empty($dados['permissao'])) {
  $retorna = ['status' => false, 'msg' => "Erro: Campo ID, Sistema ou Permissão vazio."];
  echo json_encode($retorna);
  exit; // Encerrar a execução do script
}

include_once "../db/conexao.php";

// Recupera os valores dos sistemas enviados pelo formulário e do ID
$sistemas = $dados['sistema'];
$idUsuario = $dados['id'];

// Logs para atualização do Usuário
logOperacaoUsuario($mysqli, $idUsuario, 'Permissão Atualizada');

// Verificar e atualizar grupo e setor
if (!empty($dados['grupo'])) {
    $novoGrupo = $dados['grupo'];
    $sqlGrupo = "UPDATE usuarios SET grupo = '$novoGrupo' WHERE id = $idUsuario";
    $mysqli->query($sqlGrupo);
}

if (!empty($dados['setor'])) {
    $novoSetor = $dados['setor'];
    $sqlSetor = "UPDATE usuarios SET setor = '$novoSetor' WHERE id = $idUsuario";
    $mysqli->query($sqlSetor);
}

// Verificar e atualizar termos assinados
if (!empty($dados['termo']) && !empty($dados['nome_termo'])) {
    $termos = $dados['termo'];
    $nomesTermo = $dados['nome_termo'];

    foreach ($termos as $index => $assinado) {
        $nomeTermo = $nomesTermo[$index];
        $sqlTermo = "UPDATE termos_assinados SET assinado = $assinado WHERE id_usuario = $idUsuario AND nome_termo = '$nomeTermo'";
        $mysqli->query($sqlTermo);
    }
}

// Atualizar as permissões dos sistemas no banco de dados
foreach ($sistemas as $index => $sistema) {
    $permissao = $dados['permissao'][$index];
    $novasPermissoes[$index] = $permissao;
    $novasSistemas = $sistemas;

    $sqlPermissoes = "UPDATE permissoes SET permissao = $permissao, data_altere = NOW() WHERE id_usuario = $idUsuario AND sistemas = '$sistema'";
    $mysqli->query($sqlPermissoes);
}

$mensagem = "Usuário atualizado com sucesso!";
$retorna = ['status' => true, 'msg' => $mensagem, 'permissoes' => $novasPermissoes, 'Sistemas' => $novasSistemas];
echo json_encode($retorna);
?>

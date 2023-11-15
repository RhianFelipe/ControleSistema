<?php
include_once "../db/conexao.php";
include "../src/logUser.php";

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$idUsuario = $dados['id'];
$sistemas = $dados['sistema'];

// Verificar se algum campo está vazio
if (empty($idUsuario) || empty($sistemas) || empty($dados['permissao'])) {
    $retorna = ['status' => false, 'msg' => "Erro: Campo ID, Sistema ou Permissão vazio."];
    echo json_encode($retorna);
    exit; // Encerrar a execução do script
}

if (!empty($dados['grupo'])) {
    // Consulta para verificar o valor atual do grupo
    $sqlVerificaGrupo = "SELECT grupo FROM usuarios WHERE id = $idUsuario";
    $resultado = $mysqli->query($sqlVerificaGrupo);

    if ($resultado) {
        $row = $resultado->fetch_assoc();
        $grupoAtual = $row['grupo'];

        // Verificar se o valor recebido é diferente do valor atual no banco de dados
        if ($dados['grupo'] !== $grupoAtual) {
            // Se forem diferentes, executar a atualização
            $sqlUpdateGrupo = "UPDATE usuarios SET grupo = '{$dados['grupo']}' WHERE id = $idUsuario";
            executaConsultaELog($mysqli, $sqlUpdateGrupo, $idUsuario, 'Grupo Atualizado');
        }
        // Se forem iguais, não fazer a atualização e continuar
    } else {
        // Tratar erros na consulta, se necessário
    }
}

if (!empty($dados['setor'])) {
    // Consulta para verificar o valor atual do setor
    $sqlVerificaSetor = "SELECT setor FROM usuarios WHERE id = $idUsuario";
    $resultadoSetor = $mysqli->query($sqlVerificaSetor);

    if ($resultadoSetor) {
        $rowSetor = $resultadoSetor->fetch_assoc();
        $setorAtual = $rowSetor['setor'];

        // Verificar se o valor recebido é diferente do valor atual no banco de dados
        if ($dados['setor'] !== $setorAtual) {
            // Se forem diferentes, executar a atualização
            $sqlUpdateSetor = "UPDATE usuarios SET setor = '{$dados['setor']}' WHERE id = $idUsuario";
            executaConsultaELog($mysqli, $sqlUpdateSetor, $idUsuario, 'Setor Atualizado');
        }
        // Se forem iguais, não fazer a atualização e continuar
    } else {
        // Tratar erros na consulta, se necessário
    }
}

// Atualizar termos assinados
$termosAssinadosAtuais = array();
$queryTermos = "SELECT nome_termo, assinado FROM termos_assinados WHERE id_usuario = $idUsuario";
$resultTermos = $mysqli->query($queryTermos);

if ($resultTermos) {
    while ($rowTermo = $resultTermos->fetch_assoc()) {
        $termosAssinadosAtuais[$rowTermo['nome_termo']] = $rowTermo['assinado'];
    }
}

$termosAlterados = false;

if (!empty($dados['termo']) && !empty($dados['nome_termo'])) {
    foreach ($dados['termo'] as $index => $assinado) {
        $nomeTermo = $dados['nome_termo'][$index];
        $termoAtual = $termosAssinadosAtuais[$nomeTermo];

        if ($termoAtual != $assinado) {
            $sqlUpdateTermo = "UPDATE termos_assinados SET assinado = $assinado WHERE id_usuario = $idUsuario AND nome_termo = '$nomeTermo'";
            $mysqli->query($sqlUpdateTermo);
            $termosAlterados = true;
        }
    }
}

if ($termosAlterados) {
    logOperacaoUsuario($mysqli, $idUsuario, 'Termos Atualizados');
}

// Atualizar permissões
$permissaoAtual = array();
$queryPermissoes = "SELECT sistemas, permissao FROM permissoes WHERE id_usuario = $idUsuario";
$resultPermissoes = $mysqli->query($queryPermissoes);

if ($resultPermissoes) {
    while ($row = $resultPermissoes->fetch_assoc()) {
        $permissaoAtual[$row['sistemas']] = $row['permissao'];
    }
}

$permissoesAlteradas = false;

foreach ($sistemas as $index => $sistema) {
    $permissao = $dados['permissao'][$index];

    if (!isset($permissaoAtual[$sistema]) || $permissaoAtual[$sistema] != $permissao) {
        $sqlUpdatePermissao = "UPDATE permissoes SET permissao = $permissao, data_altere = NOW() WHERE id_usuario = $idUsuario AND sistemas = '$sistema'";
        $mysqli->query($sqlUpdatePermissao);
        $permissoesAlteradas = true;
    }
}

if ($permissoesAlteradas) {
    logOperacaoUsuario($mysqli, $idUsuario, 'Atualização de Permissões');
}

$retorna = ['status' => true, 'msg' => 'Usuário atualizado com sucesso!'];
echo json_encode($retorna);

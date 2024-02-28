<?php
include "../db/conexao.php";
//Função que faz consultar para verificar se existe algum atributo no Banco de Dados
function verificarExistencia($mysqli, $valor, $tabela, $variavel)
{
    $verificar = "SELECT $valor FROM $tabela WHERE $valor='$variavel'";
    $resultVerificacao = $mysqli->query($verificar) or die($mysqli->error);
    return $resultVerificacao;
}
// Consultas relacionadas a usuários
$buscaNomeUserOrder = "SELECT * FROM usuarios ORDER BY nome";
$queryBuscaNomeUserOrder = $mysqli->query($buscaNomeUserOrder);

$buscaQuantiaUsuarios = "SELECT COUNT(*) as totalUsuarios FROM usuarios";
$queryBuscaQuantiaUsuarios = $mysqli->query($buscaQuantiaUsuarios);

$buscaGrupo = "SELECT grupo FROM usuarios";
$queryBuscaGrupo = $mysqli->query($buscaGrupo) or die($mysqli->error);

// Consultas relacionadas a sistemas
$buscaSistemas = "SELECT sistemas FROM permissoes";
$queryBuscaSistemas =  $mysqli->query($buscaSistemas) or die($mysqli->error);

// Consultas relacionadas a logs
$buscaRegistroLogsUser = "SELECT * FROM logsusuarios ORDER BY data_operacao DESC";
$queryBuscaRegistroLogsUser = mysqli_query($mysqli, $buscaRegistroLogsUser);

// Consulta os grupos de cada funcionario(procuradores, estags, servidores...)
$buscaGrupo = "SELECT grupo FROM usuarios";
$queryBuscaGrupo = $mysqli->query($buscaGrupo) or die($mysqli->error);

// Consulta SQL para selecionar todos os setores da tabela
$buscaSetor = "SELECT nomeSetor FROM setores ORDER BY nomeSetor ASC";
$queryBuscaSetor = $mysqli->query($buscaSetor) or die($mysqli->error);

$setores = array();

if ($queryBuscaSetor->num_rows > 0) {
    // Armazenar os resultados em um array
    while ($row = $queryBuscaSetor->fetch_assoc()) {
        $setores[] = $row["nomeSetor"];
    }
} else {
}

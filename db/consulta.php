<?php 
 include "../db/conexao.php";


//Função que faz consultar para verificar se existe algum atributo no Banco de Dados
function verificarExistencia($mysqli, $valor, $tabela, $variavel)
{
    $verificar = "SELECT $valor FROM $tabela WHERE $valor='$variavel'";
    $resultVerificacao = $mysqli->query($verificar) or die($mysqli->error);
    return $resultVerificacao;
}



// Consulta os sistemas e as permissões disponíveis no banco de dados
$buscaSistemas = "SELECT sistemas FROM permissoes";
$queryBuscaSistemas =  $mysqli->query($buscaSistemas) or die($mysqli->error);


// Consulta os grupos de cada funcionario(procuradores, estags, servidores...)
$buscaGrupo = "SELECT grupo FROM usuarios"; 
$queryBuscaGrupo = $mysqli->query($buscaGrupo) or die($mysqli->error);


 ?>




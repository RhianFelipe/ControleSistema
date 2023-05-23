<?php 
 include "../db/conexao.php";

// Consulta os sistemas e as permissões disponíveis no banco de dados
$buscaSistemas = "SELECT sistemas FROM permissoes";
$queryBuscaSistemas =  $mysqli->query($buscaSistemas) or die($mysqli->error);


// Consulta os grupos de cada funcionario(procuradores, estags, servidores...)
$buscaGrupo = "SELECT grupo FROM usuarios"; 
$queryBuscaGrupo = $mysqli->query($buscaGrupo) or die($mysqli->error);

 ?>




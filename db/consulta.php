<?php 
 include "../db/conexao.php";

// Consulta os sistemas e as permissões disponíveis no banco de dados
$buscaSistemas = "SELECT sistemas,permissao FROM permissoes";
$queryBuscaSistemas =  $mysqli->query($buscaSistemas) or die($mysqli->error);

 ?>


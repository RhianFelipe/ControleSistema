<?php 
include "../../db/conexao.php";

$buscaNomeSistema = "SELECT DISTINCT nomeSistema FROM admin";
$queryBuscaNomeSistema = $mysqli->query($buscaNomeSistema) or die($mysqli->error);

$sistemas = [];

if (mysqli_num_rows($queryBuscaNomeSistema) > 0) {
    while ($row = mysqli_fetch_assoc($queryBuscaNomeSistema)) {
        $nomeSistema = $row['nomeSistema'];
        if (!empty($nomeSistema)) {
            $sistemas[] = $nomeSistema;
        }
    }
}

if (!empty($sistemas)) {
    $retorna = [
        'status' => true,
        'dados' => $sistemas
    ];
} else {
    $retorna = [
        'status' => false,
        'msg' => 'Nenhum sistema encontrado'
    ];
}

echo json_encode($retorna);
?>

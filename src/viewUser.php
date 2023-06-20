<?php 
include_once "../db/conexao.php";

$id = filter_input(INPUT_GET,'id', FILTER_SANITIZE_NUMBER_INT);

if(!empty($id)){
    $sql = "SELECT id_usuario,sistemas, permissao FROM permissoes WHERE id_usuario = $id";
    $result = $mysqli->query($sql);
    $rows = array();
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    } 
    $retorna = ['status' => true, 'dados' => $rows];

}else{
    $retorna = ['status' => false, 'msg' => "<div class='alert alert-danger' role='alert'>ERRO: Usuario não cadastrado com sucesso!"];
}

echo json_encode($retorna);
?>
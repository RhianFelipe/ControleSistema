<?php 
include_once "../db/conexao.php";

$id = filter_input(INPUT_GET,'id', FILTER_SANITIZE_NUMBER_INT);

if(!empty($id)){
    $retorna = ['status' => true, 'dados' => $id];

}else{
    $retorna = ['status' => false, 'msg' => "<div class='alert alert-danger' role='alert'>ERRO: Usuario não cadastrado com sucesso!"];
}

echo json_encode($retorna);
?>
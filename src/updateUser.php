<?php 
include_once "../db/conexao.php";


$dados = filter_input_array(INPUT_POST,FILTER_DEFAULT);
print($dados);
echo $dados;

if(empty($dados['sistemas'])){
$retorna = ['status' => false, 'msg' => "<div class='alert alert-danger'role='alert'>Erro: Não há Sistemas"];

}else if($dados['permissao']){
    $retorna = ['status' => false, 'msg' => "<div class='alert alert-danger'role='alert'>Erro: Não há Permissao"];

}else{

    
}


?>
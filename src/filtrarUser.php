<?php
session_start(); // Inicia a sessão

include_once "../db/conexao.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pegar os valores do filtro
    $nome = $_POST['nome'];
    $email = $_POST['email'];

    // Código SQL para criação do Filtro
    $sqlFiltro = "SELECT * FROM usuarios WHERE 1=0"; // Iniciamos a consulta com uma cláusula WHERE falsa
    if (!empty($nome)){ $sqlFiltro  .= " OR nome LIKE '%$nome%'"; }
    if (!empty($email)){$sqlFiltro  .= " OR email LIKE '%$email%'";}

    $resultado = $mysqli->query($sqlFiltro);
    $resultados = array();

    // Se caso o valor não esteja vazio, mapeia os valores recebidos do Select Filtro
    if ($resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            $id = $row['id'];
            $nomeUsuario = $row['nome'];
            $emailUsuario = $row['email'];
            $resultados[] = array('id' =>  $id, 'nome' => $nomeUsuario, 'email' => $emailUsuario);
        }
    } else {
        $resultados = array();
    }

    // Armazene os resultados na sessão em vez de passá-los como parâmetros de URL
    $_SESSION['resultados_filtro'] = $resultados;

    // Redirecione para a página inicial usando o método GET
    header('Location: ../public/pageFiltro.php');
    exit();
}
?>

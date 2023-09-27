<?php
session_start(); // Inicia a sessão

include_once "../db/conexao.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pegar os valores do filtro
    $nome = $_POST['nome'];
    $email = $_POST['email'];

    // Construa a consulta SQL para criação do filtro
    $sqlFiltro = "SELECT * FROM usuarios WHERE 1=0"; // Iniciamos a consulta com uma cláusula WHERE falsa
    if (!empty($nome)) {
        $sqlFiltro .= " OR nome LIKE '%$nome%'";
    }
    if (!empty($email)) {
        $sqlFiltro .= " OR email LIKE '%$email%'";
    }

    $resultado = $mysqli->query($sqlFiltro);
    $resultados = array();

    // Se o valor não estiver vazio, mapeie os resultados
    if ($resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            $resultados[] = $row;
        }
    }

    // Armazene os resultados na sessão
    $_SESSION['resultados_filtro'] = $resultados;

    // Redirecione para a página inicial usando o método GET
    header('Location: ../public/pageFiltro.php');
    exit();
}
?>

<?php
include "../db/conexao.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pegar os valores do filtro
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    
    // Definir as configurações da paginação
    $resultadosPorPagina = 61; // Número de resultados por página
    $pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 1; // Página atual, padrão é a página 1
    
    // Cálculo do OFFSET
    $offset = ($pagina - 1) * $resultadosPorPagina;

    // Código SQL para criação do Filtro com paginação
    $sqlFiltro = "SELECT * FROM usuarios WHERE 1=0"; // Iniciamos a consulta com uma cláusula WHERE falsa
    if (!empty($nome)) { $sqlFiltro  .= " OR nome LIKE '%$nome%'"; }
    if (!empty($email)) { $sqlFiltro  .= " OR email LIKE '%$email%'"; }
    $sqlFiltro .= " LIMIT $resultadosPorPagina OFFSET $offset";

    // Consulta para obter os resultados da página atual
    $resultado = $mysqli->query($sqlFiltro);
    $resultados = array();

    // Mapear os valores recebidos do Select Filtro
    if ($resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            $id = $row['id'];
            $nomeUsuario = $row['nome'];
            $emailUsuario = $row['email'];
            $resultados[] = array('id' => $id, 'nome' => $nomeUsuario, 'email' => $emailUsuario);
        }
    } else {
        $resultados = array();
    }

    // Consulta para obter o número total de resultados
    $sqlTotal = "SELECT COUNT(*) AS total FROM usuarios WHERE 1=0";
    if (!empty($nome)) { $sqlTotal .= " OR nome LIKE '%$nome%'"; }
    if (!empty($email)) { $sqlTotal .= " OR email LIKE '%$email%'"; }
    $resultadoTotal = $mysqli->query($sqlTotal);
    $total = $resultadoTotal->fetch_assoc()['total'];

// Redirecionar para a página inicial, passando os resultados e a informação da página como parâmetros de URL
$paginaAnterior = $pagina > 1 ? $pagina - 1 : null;
$proximaPagina = ($offset + count($resultados)) < $total ? $pagina + 1 : null;
$resultadosCodificados = urlencode(json_encode($resultados));
header("Location: ../public/pageFiltro.php?resultados=$resultadosCodificados&paginaAnterior=$paginaAnterior&proximaPagina=$proximaPagina");
exit();

}
?>
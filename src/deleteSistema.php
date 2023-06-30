
<?php
include "../db/conexao.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $nomeSistema = $_GET['nomeSistema'];

    // Lógica para excluir o sistema do banco de dados
    // Substitua a linha abaixo pelo código apropriado para realizar a exclusão no banco de dados
    $excluirSistema = "DELETE FROM permissoes WHERE nomeSistema = '$nomeSistema'";
    $queryExcluirSistema = $mysqli->query($excluirSistema) or die($mysqli->error);
    
    // Envie uma resposta ao cliente (opcional)
    echo "Exclusão do sistema concluída.";
}
?>

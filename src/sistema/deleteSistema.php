<?php
include "../../db/conexao.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $nomeSistema = $_GET['nomeSistema'];

    if (isset($_GET['adicionarParaTodos']) && $_GET['adicionarParaTodos'] === '1') {
        // Lógica para excluir permissões para o sistema especificado
        // Substitua a linha abaixo pelo código apropriado para realizar a exclusão no banco de dados
        $excluirPermissoes = "DELETE FROM permissoes WHERE sistemas = '$nomeSistema'";
        $queryExcluirPermissoes = $mysqli->query($excluirPermissoes) or die($mysqli->error);
        
        // Lógica para excluir o sistema do banco de dados
        // Substitua a linha abaixo pelo código apropriado para realizar a exclusão no banco de dados
        $excluirSistema = "DELETE FROM admin WHERE nomeSistema = '$nomeSistema'";
        $queryExcluirSistema = $mysqli->query($excluirSistema) or die($mysqli->error);

        echo "Exclusão do sistema concluída para todos os usuários.";
    } else {
        // Lógica para excluir o sistema do banco de dados
        // Substitua a linha abaixo pelo código apropriado para realizar a exclusão no banco de dados
        $excluirSistema = "DELETE FROM admin WHERE nomeSistema = '$nomeSistema'";
        $queryExcluirSistema = $mysqli->query($excluirSistema) or die($mysqli->error);

        echo "Exclusão do sistema concluída.";
    }
}
?>

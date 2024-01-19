<?php

function verificarPermissao()
{
    // Verifica se o usuário está logado
    if (!isset($_SESSION['user']) || !isset($_SESSION['permissao'])) {
        // Usuário não está logado, redirecione para a página de login
        header("Location: ../../index.php");
        exit();
    }

    $permissaoUsuario = $_SESSION['permissao'];

    // Verifica se o usuário tem permissão 0 (ou outra condição específica)
    if ($permissaoUsuario == 0) {
        // Usuário tem permissão 0, redirecione para uma página de acesso negado
        header("Location: ../view/public/viewBlock.php");
        exit();
    }
}

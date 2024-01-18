<header>
    <a href="../public/viewFiltro.php">
        <img class="imgHeader" src="..\..\public\assets\img\logo-govpr-white.png" alt="Descrição da imagem">
    </a>
    <nav class="navbar">
         <li class="list-header"><a class="a1" <?php if ($pageTitle === 'Filtrar Usuários') echo 'id="botao-filtro-a"'; ?> href="../public/viewFiltro.php">Filtrar Usuários</a></li>
        <li class="list-header"><a class="a1" <?php if ($pageTitle === 'Lista de Usuários') echo 'id="botao-filtro-a"'; ?> href="../public/viewLista.php">Lista de Usuários</a></li>
        <div class="dropdown">
        <button class="dropbtn" style="border: none; outline: none;"><img src="../../public/assets/img/icon-profile.png" alt="Descrição da Imagem"></button>

            <div class="dropdown-content">
                <p id="username"><?php echo $_SESSION['nome']; ?></p>
            <!-- <a href="../../public/pageDocs.php">Documentação</a> -->  
                <a href="?logout=1">Sair</a>
            </div>
        </div>
    </nav>
</header>

<?php
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: ../../index.php");
    exit();
}
?>
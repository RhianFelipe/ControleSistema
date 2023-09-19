<header>
        <img class="imgHeader" src="..\public\assets\img\logo-govpr-white.png">
        <nav class="navbar">
        <li class="list-header"><a class="a1" <?php if ($pageTitle === 'Cadastrar Usuários') echo 'id="botao-filtro-a"'; ?> href="../public/pageCadastro.php">Cadastrar Usuários</a></li>
        <li class="list-header"><a class="a1" <?php if ($pageTitle === 'Filtrar Usuários') echo 'id="botao-filtro-a"'; ?> href="../public/pageFiltro.php">Filtrar Usuários</a></li>
        <li class="list-header"><a class="a1" <?php if ($pageTitle === 'Lista de Usuários') echo 'id="botao-filtro-a"'; ?> href="../public/pageLista.php">Lista de Usuários</a></li>
        <li class="list-header"><a class="a1" <?php if ($pageTitle === 'Logs de Usuário') echo 'id="botao-filtro-a"'; ?> href="../public/pageLogs.php">Logs de Usuário</a></li>
        <!-- ... outras opções de navegação ... -->
            <li class="list-header"><a onclick="openModalSistema()" class="a1">Inserir Sistema</a></li>
            <div class="dropdown">
                <button class="dropbtn"><img src="https://cdn-icons-png.flaticon.com/512/6017/6017051.png" alt="Descrição da Imagem"></button>
                <div class="dropdown-content">
                    <a href="../public/pageAdmin.php">Admin</a>
                    <a href="#">Sair</a>
                </div>
            </div>
        </nav>
    </header>
    <!-- JavaScript para adicionar o id "botao-filtro-a" ao botão da página atual -->

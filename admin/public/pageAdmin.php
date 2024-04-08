<?php
$pageTitle = "Pagina Admin";
session_start();

if (!isset($_SESSION['user'])) {
    // Redireciona o usuário para o painel de login se a sessão não estiver definida
    header("Location: ../../index.php");
    exit();
}

$permissaoUsuario = $_SESSION['permissao'];

// Verifica se o usuário tem permissão 0 (ou outra condição específica)
if ($permissaoUsuario == 0) {
    // Usuário tem permissão 0, redirecione para uma página de acesso negado
    header("Location: ../../view/public/viewBlock.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/style/telaAdmin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-... (verifique a integridade no site do Font Awesome)" crossorigin="anonymous">
    <script src="../../js/sweetalert2.js"></script>
    <script src="../../script/utils.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title>Dashboard de Administração</title>
</head>

<body>
    <div class="container">
        <div class="sidebar">
            <h2><a href="pageAdmin.php">Admin Dashboard</a></h2>
            <a class="home-icon" href="../../public/pageFiltro.php" onclick=""><i class="fas fa-home"></i> Início</a>
            <ul>

                <li><a href="#" onclick="showAccounts()">Gerenciar Contas</a></li>
                <li><a href="#" onclick="showSectorGroup()">Gerenciar Grupo/Setor</a></li>
                <li><a href="#" onclick="showPermissions()">Gerenciar Permissões</a></li>
                <li><a href="#" onclick="showReports()">Gerenciar Relatórios</a></li>
                <li><a href="#" onclick="showDeletedUsers()">Lista de Excluídos</a></li>

            </ul>
        </div>

        <div class="content" id="dashboardContent">
            <h3>Bem-vindo ao Painel de Administração</h3>
            <p>Selecione uma opção no menu lateral para começar.</p>
        </div>
    </div>


</body>

</html>

<script>
    function showAccounts() {
        document.getElementById('dashboardContent').innerHTML =
            `<?php include 'pageGerenciarConta.php'; ?>`
    }

    function showSectorGroup() {
        document.getElementById('dashboardContent').innerHTML =
            `<?php include 'pageGrupoSetor.php'; ?>`;
    }

    function showDeletedUsers() {
        document.getElementById('dashboardContent').innerHTML =
            `<?php include 'pageDelete.php'; ?>`;
    }

    function showPermissions() {
        document.getElementById('dashboardContent').innerHTML = `
        <h1>Gerenciar Permissões</h1>
        <!-- Lógica para exibir e gerenciar permissões -->
    `;
    }

    function showReports() {
        document.getElementById('dashboardContent').innerHTML = `
        <h1>Gerenciar Relatórios</h1>
        <div id="reportSection">
            <!-- Lógica para exibir relatórios -->
        </div>
    `;
    }
</script>

<?php include '../src/modalDeletados.php'; ?>
<script src="../script/gerenciarConta/criarConta.js"></script>
<script src="../script/gerenciarConta/excluirConta.js"></script>
<script src="../script/gerenciarConta/resetarSenhaConta.js"></script>
<script src="../script/gerenciarSetorGrupo/manterSetor.js"></script>
<script src="../script/gerenciarDeletados/openModalDeletados.js"></script>
<script src="../script/gerenciarDeletados/preencherModalDelete.js"></script>
<script src="../../script/utils.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
<?php
$pageTitle = "Pagina Admin";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Dashboard de Administração</title>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h2>Admin Dashboard</h2>
            <ul>
                <li><a href="#" onclick="showAccounts()">Criar Contas</a></li>
                <li><a href="#" onclick="showPermissions()">Gerenciar Permissões</a></li>
                <li><a href="#" onclick="showReports()">Gerenciar Relatórios</a></li>
            </ul>
        </div>

        <div class="content" id="dashboardContent">
            <!-- Conteúdo dinâmico será carregado aqui -->
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>


<style>

body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
}

.container {
    display: flex;
    max-width: 100%; /* Modificado para ocupar 100% da largura da tela */
    height: 57.41rem;
}

.sidebar {
    width: 200px;
    padding: 20px;
    background-color: #333;
    color: #fff;
}

.sidebar h2 {
    margin-bottom: 20px;
}

.sidebar ul {
    list-style-type: none;
    padding: 0;
}

.sidebar li {
    margin-bottom: 10px;
}

.sidebar a {
    text-decoration: none;
    color: #fff;
    font-weight: bold;
}

.content {
    flex: 1;
    padding: 20px;
}

.button-container {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}

.button-container button {
    background-color: #4caf50;
    color: #fff;
    padding: 10px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-bottom: 10px;
}

.button-container button:hover {
    background-color: #45a049;
}

</style>


<script>

function showAccounts() {
    document.getElementById('dashboardContent').innerHTML = `
        <h1>Criar Contas</h1>
        <form id="accountForm">
            <!-- Formulário para criar contas -->
        </form>
    `;
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
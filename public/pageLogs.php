<?php
session_start();

// Verifica se a variável de sessão está definida
if (!isset($_SESSION['user'])) {
    // Redireciona o usuário para o painel de login
    header("Location: ../public/pageLogin.php");
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Histórico de Logs de Usuários</title>
    <link rel="stylesheet" href="../public/main.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../public/style/telaLogs.css?v=<?php echo time(); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="icon" href="../public/assets/img/icon-govpr.png" type="image/x-icon">
</head>

<body>
    <header>
        <img class="imgHeader" src="..\public\assets\img\logo-govpr-white.png">
        <nav class="navbar">

            <li class="list-header"><a class="a1" href="../public/pageCadastro.php">Cadastrar Usuários</a></li>
            <li class="list-header"><a class="a1" href="../public/pageFiltro.php">Filtrar Usuários</a></li>
            <li class="list-header"><a class="a1" href="../public/pageLista.php">Lista de Usuários</a></li>
            <li class="list-header"><a onclick="openPopupSistema()" class="a1">Inserir Sistema</a></li>
        </nav>
    </header>
    <section>


        <h1>Histórico de Logs de Usuários</h1>

        <?php
        include "../db/conexao.php";

        // Consulta os logs de usuários ordenados pela última data de operação
        $sql = "SELECT id, nome_usuario,email_usuario,grupo_usuario, tipo_operacao, data_operacao FROM logsusuarios ORDER BY data_operacao DESC";
        $resultado = mysqli_query($mysqli, $sql);

        // Verifica se há registros de logs
        if (mysqli_num_rows($resultado) > 0) {
            echo "<table>";
            echo "<tr><th>ID</th><th>Nome do Usuário</th><th>Email do Usuário</th><th>Grupo do Usuário</th><th>Tipo de Operação</th><th>Data da Operação</th></tr>";

            // Itera sobre os registros de logs
            while ($row = mysqli_fetch_assoc($resultado)) {
                $id = $row['id'];
                $nomeUsuario = $row['nome_usuario'];
                $emailUsuario = $row['email_usuario'];
                $grupoUsuario = $row['grupo_usuario'];
                $tipoOperacao = $row['tipo_operacao'];
                $dataOperacao = $row['data_operacao'];

                echo "<tr><td>$id</td><td>$nomeUsuario</td><td>$emailUsuario</td><td>$grupoUsuario</td><td>$tipoOperacao</td><td>$dataOperacao</td></tr>";
            }

            echo "</table>";
        } else {
            echo "<p>Nenhum registro de log encontrado.</p>";
        }

        // Fecha a conexão com o banco de dados
        mysqli_close($mysqli);
        ?>

        <footer>
            <p>&copy; 2023 Procuradoria Geral do Estado do Paraná. Todos os direitos reservados.</p>
        </footer>
        <?php include '../src/sistema/modalSistema.php'; ?>
        <script src="../script/utils.js"></script>
        <script src="../js/sweetalert2.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
        </script>
</body>

</html>
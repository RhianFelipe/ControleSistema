<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../public/pageLogin.php");
    exit();
}

include "../db/conexao.php";

$sql = "SELECT id, nome_usuario, email_usuario, grupo_usuario, tipo_operacao, data_operacao FROM logsusuarios ORDER BY data_operacao DESC";
$resultado = mysqli_query($mysqli, $sql);
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
            <ul class="list-header">
                <li><a class="a1" href="../public/pageCadastro.php">Cadastrar Usuários</a></li>
                <li><a class="a1" href="../public/pageFiltro.php">Filtrar Usuários</a></li>
                <li><a class="a1" href="../public/pageLista.php">Lista de Usuários</a></li>
                <li><a onclick="openModalSistema()" class="a1">Inserir Sistema</a></li>
            </ul>
        </nav>
    </header>
    <section>
        <h1>Histórico de Logs de Usuários</h1>

        <?php if (mysqli_num_rows($resultado) > 0): ?>
            <table class='logs-table'>
                <tr>
                    <th>ID</th>
                    <th>Nome do Usuário</th>
                    <th>Email do Usuário</th>
                    <th>Grupo do Usuário</th>
                    <th>Tipo de Operação</th>
                    <th>Data da Operação</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($resultado)): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['nome_usuario']; ?></td>
                        <td><?php echo $row['email_usuario']; ?></td>
                        <td><?php echo $row['grupo_usuario']; ?></td>
                        <td><?php echo $row['tipo_operacao']; ?></td>
                        <td><?php echo $row['data_operacao']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>Nenhum registro de log encontrado.</p>
        <?php endif; ?>

        <?php include '../src/sistema/modalSistema.php'; ?>
    </section>

    <script src="../script/utils.js"></script>
    <script src="../js/sweetalert2.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>

<?php
mysqli_close($mysqli);
?>

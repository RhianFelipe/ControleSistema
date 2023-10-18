<?php
include "../db/conexao.php";
include "../db/consulta.php";

$pageTitle = "Logs de Usuário";
session_start();

// Verifica se a sessão do usuário está definida
if (!isset($_SESSION['user'])) {
    // Redireciona o usuário para a página de login se a sessão não estiver definida
    header("Location: ../index.php");
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
    <?php include 'header.php'; ?>
    <section>
        <h1>Histórico de Logs de Usuários</h1>

        <?php if (mysqli_num_rows($queryBuscaRegistroLogsUser) > 0) : ?>
            <table class='logs-table'>
                <tr>
                    <th>Nome do Usuário</th>
                    <th>Email do Usuário</th>
                    <th>Grupo do Usuário</th>
                    <th>Tipo de Operação</th>
                    <th>Data da Operação</th>
                    <th>Administrador</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($queryBuscaRegistroLogsUser)) : ?>
                    <tr>
                        <td><?php echo $row['nome_usuario']; ?></td>
                        <td><?php echo $row['email_usuario']; ?></td>
                        <td><?php echo $row['grupo_usuario']; ?></td>
                        <td><?php echo $row['tipo_operacao']; ?></td>
                        <td><?php echo date('d/m/Y H:i:s', strtotime($row['data_operacao'])); ?></td>
                        <td><?php echo $row['nome_admin']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else : ?>
            <p>Nenhum registro de log encontrado.</p>
        <?php endif; ?>

        <?php include '../src/sistema/modalSistema.php'; ?>
    </section>

    <script src="../script/utils.js"></script>
    <script src="../js/sweetalert2.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
</body>

</html>

<?php
// Fecha a conexão com o banco de dados
mysqli_close($mysqli);
?>
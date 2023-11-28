<?php

include "../db/conexao.php";
include "../db/consulta.php";

$pageTitle = "Lista de Usuários";
session_start();

if (!isset($_SESSION['user'])) {
    // Redireciona o usuário para o painel de login se a sessão não estiver definida
    header("Location: ../index.php");
    exit();
}

// Verifica se há resultados e os armazena em um array associativo
$usuarios = $queryBuscaNomeUserOrder->num_rows > 0 ? $queryBuscaNomeUserOrder->fetch_all(MYSQLI_ASSOC) : [];

$row = $queryBuscaQuantiaUsuarios->fetch_assoc();
$totalUsuarios = $row['totalUsuarios'];

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/main.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../public/style/telaLista.css?v=<?php echo time(); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="icon" href="../public/assets/img/icon-govpr.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0/dist/pretty-checkbox.min.css">
    <title>Sistema de Controle de Permissões</title>
</head>

<body>



    <?php include 'header.php'; ?>
    <p class="total-usuarios">N°: <?php echo $totalUsuarios; ?> Usuários</p>

    <section>


        <table class="lista-usuarios">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Grupo</th>
                    <th>Setor</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario) : ?>
                    <!-- Exibir os dados de cada usuário -->
                    <tr id="linha-usuario-<?php echo $usuario['id']; ?>">

                        <td><?php echo $usuario['nome']; ?></td>
                        <td><?php echo $usuario['email']; ?></td>
                        <td id="tdGrupo"><?php echo $usuario['grupo']; ?></td>
                        <td id="tdSetor"><?php echo $usuario['setor']; ?></td>
                        <td>
                            <!-- Botões para editar e excluir usuários -->
                            <button class="button-edit" onclick="openModalEdit(<?php echo $usuario['id']; ?>)">Editar</button>
                            <button class="button-excluir" onclick="apagarUsuarioDados(<?php echo $usuario['id']; ?>, '<?php echo $usuario['nome']; ?>')">Excluir</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($usuarios)) : ?>
                    <!-- Exibir mensagem se nenhum registro for encontrado -->
                    <tr>
                        <td colspan="4">Nenhum registro encontrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

    </section>


    <?php include '../include/modals.php'; ?>
    <?php include '../include/importUser.php'; ?>
    <script src="../js/sweetalert2.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
</body>

</html>
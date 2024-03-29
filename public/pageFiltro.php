<?php
$pageTitle = "Filtrar Usuários";
session_start();
include_once "../view/src/verificarPermissao.php";

verificarPermissao();

if (!isset($_SESSION['user'])) {
    // Redireciona o usuário para o painel de login se a sessão não estiver definida
    header("Location: ../index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/main.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../public/style/telaFiltro.css?v=<?php echo time(); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="icon" href="../public/assets/img/icon-govpr.png" type="image/x-icon">
    <title>Sistema de Controle de Permissões</title>
</head>

<body onload="limparFiltragem()">


    <?php include 'header.php'; ?>
    <section class="area-consulta">
        <h1 class="consulta-title">Área de Consulta</h1>
        <form action="../src/filtrarUser.php" method="POST">
            <div class="input-wrapper">
                <!-- Campos de entrada para filtrar usuários -->
                <input placeholder="nome" class="input-table" type="text" name="nome">
                <input placeholder="e-mail" class="input-table" type="text" name="email">
                <button type="submit" id="button-filtro" class="btn-filtro">Filtrar</button>
            </div>
        </form>

        <table class="consulta-table">
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
                <?php if (isset($_SESSION['resultados_filtro'])) : ?>
                    <?php $resultados = $_SESSION['resultados_filtro']; ?>
                    <?php if (empty($resultados)) : ?>
                        <!-- Exibir mensagem se nenhum resultado for encontrado -->
                        <tr>
                            <td colspan="4">Nenhum resultado encontrado.</td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($resultados as $resultado) : ?>
                            <!-- Exibir os dados de cada usuário filtrado -->
                            <tr class="linha-usuario" id="linha-usuario-<?php echo $resultado['id']; ?>">
                                <td><?php echo $resultado['nome']; ?></td>
                                <td><?php echo $resultado['email']; ?></td>
                                <td id="tdGrupo"><?php echo $resultado['grupo']; ?></td>
                                <td id="tdSetor"><?php echo $resultado['setor']; ?></td>
                                <td class="td-button">
                                    <!-- Botões para editar e excluir usuários -->
                                    <button class="button-edit" onclick="openModalEdit('<?php echo $resultado['id']; ?>')">Editar</button>
                                    <button class="button-excluir" onclick="apagarUsuarioDados(<?php echo $resultado['id']; ?>, '<?php echo $resultado['nome']; ?>')">Excluir</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <?php unset($_SESSION['resultados_filtro']); ?>
                <?php else : ?>
                    <!-- Exibir mensagem inicial de filtragem -->
                    <tr>
                        <td colspan="4">Digite um nome ou email para filtrar.</td>
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
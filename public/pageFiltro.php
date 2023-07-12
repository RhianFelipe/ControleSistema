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
    <header> <img class="imgHeader" src="..\public\assets\img\logo-govpr-white.png">
        <nav class="navbar">
            <li class="list-header"><a class="a1" href="../public/pageCadastro.php">Cadastrar Usuários</a></li>
            <li class="list-header"><a class="a1" href="../public/pageLista.php">Lista de Usuários</a></li>
            <li class="list-header"><a class="a1" href="../public/pageLogs.php">Logs de Usuário</a></li>
            <li class="list-header"><a onclick="openModalSistema()" class="a1">Inserir Sistema</a></li>
        </nav>
    </header>
    <section class="area-consulta">
        <h1 class="consulta-title">Área de Consulta</h1>
        <form action="../src/filtrarUser.php" method="POST">
            <div class="input-wrapper">
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
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Verifica se existem resultados na sessão
                if (isset($_SESSION['resultados_filtro'])) {
                    $resultados = $_SESSION['resultados_filtro'];

                    if (empty($resultados)) {
                        echo "<tr><td colspan='3'>Nenhum resultado encontrado.</td></tr>";
                    } else {
                        foreach ($resultados as $resultado) {
                            $id = $resultado['id'];
                            $nomeUsuario = $resultado['nome'];
                            $emailUsuario = $resultado['email'];
                            $grupoUsuario = $resultado['grupo'];
                ?>
                            <tr class="linha-usuario" id="linha-usuario-<?php echo $id; ?>">
                                <td><?php echo $nomeUsuario; ?></td>
                                <td><?php echo $emailUsuario; ?></td>
                                <td><?php echo $grupoUsuario; ?></td>
                                <td class="td-button">
                                    <button class="button-edit" onclick="openModalEdit('<?php echo $id; ?>')">Editar</button>
                                    <button class="button-excluir" onclick="apagarUsuarioDados('<?php echo $id; ?>')">Excluir</button>
                                </td>
                            </tr>
                <?php
                        }
                    }

                    unset($_SESSION['resultados_filtro']); // Remove os dados da sessão após exibir os resultados (opcional)
                } else {
                    echo "<tr><td colspan='3'>Digite um nome ou email para filtrar.</td></tr>";
                }
                ?>

            </tbody>
        </table>
    </section>


    <!-- Tabela para exibir os dados -->
    <span id="msgAlerta"></span>


    <!-- Início Modal editar usuário -->
    <?php include '../src/modalEdit.php'; ?>
    <?php include '../src/sistema/modalSistema.php'; ?>
    <!-- Fim Modal editar usuário -->


    <script src="../script/editModalUser.js"></script>
    <script src="../script/deleteUser.js"></script>
    <script src="../script/utils.js"></script>
    <script src="../js/sweetalert2.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
</body>

</html>
<?php
session_start();

if (!isset($_SESSION['user'])) {
    // Redireciona o usuário para o painel de login se a sessão não estiver definida
    header("Location: ../index.php");
    exit();
}

include "../db/conexao.php";

// Consulta para obter os usuários do banco de dados
$sql = "SELECT * FROM usuarios ORDER BY nome";
$result = $mysqli->query($sql);

// Verifica se há resultados e os armazena em um array associativo
$usuarios = $result->num_rows > 0 ? $result->fetch_all(MYSQLI_ASSOC) : [];

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
    <title>Sistema de Controle de Permissões</title>
</head>

<body>
    <header>
        <img class="imgHeader" src="..\public\assets\img\logo-govpr-white.png">
        <nav class="navbar">
            <ul class="list-header">
                <!-- Links de navegação no cabeçalho -->
                <li><a class="a1" href="../public/pageCadastro.php">Cadastrar Usuários</a></li>
                <li><a class="a1" href="../public/pageFiltro.php">Filtrar Usuários</a></li>
                <li><a class="a1" id="botao-filtro-a" href="../public/pageLista.php">Lista de Usuários</a></li>
                <li><a class="a1" href="../public/pageLogs.php">Logs de Usuário</a></li>
                <li><a onclick="openModalSistema()" class="a1">Inserir Sistema</a></li>
            </ul>
        </nav>
    </header>

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
                        <td><?php echo $usuario['grupo']; ?></td>
                        <td><?php echo $usuario['setor']; ?></td>
                        <td>
                            <!-- Botões para editar e excluir usuários -->
                            <button class="button-edit" onclick="openModalEdit(<?php echo $usuario['id']; ?>)">Editar</button>
                            <button class="button-excluir" onclick="apagarUsuarioDados(<?php echo $usuario['id']; ?>)">Excluir</button>
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

        <?php include '../src/modalEdit.php'; ?>
        <?php include '../src/sistema/modalSistema.php'; ?>
    </section>

    <script src="../script/utils.js"></script>
    <script src="../script//preencherModalUser.js"></script>
    <script src="../script/editModalUser.js"></script>
    <script src="../script/deleteUser.js"></script>
    <script src="../js/sweetalert2.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>
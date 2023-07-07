
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
    <link rel="stylesheet" href="../public/style/telaLista.css?v=<?php echo time(); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <link rel="icon" href="../public/assets/img/icon-govpr.png" type="image/x-icon">
    <title>Sistema de Controle de Permissões</title>
</head>

<body>
<header>
        <img class="imgHeader" src="..\public\assets\img\logo-govpr-white.png">
        <nav class="navbar">

            <li class="list-header"><a class="a1" href="../public/pageCadastro.php">Cadastrar Usuários</a></li>
            <li class="list-header"><a class="a1" href="../public/pageFiltro.php">Filtrar Usuários</a></li>
        
            <li class="list-header"><a class="a1" href="../public/pageLogs.php">Logs de Usuário</a></li>
            <li class="list-header"><a onclick="openPopupSistema()" class="a1">Inserir Sistema</a></li>
        </nav>
    </header>

    <!-- Tabela para exibir os dados -->
    <span id="msgAlerta"></span>
    <section>
        <table>
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
                // Conexão com o banco de dados (substitua as informações de conexão com as suas)
                include "../db/conexao.php";

                // Consulta SQL para obter os dados
                $sql = "SELECT id, nome, email, grupo FROM usuarios ORDER BY nome";
                $result = $mysqli->query($sql);

                if ($result->num_rows > 0) {
                    // Exibe os dados na tabela
                    while ($row = $result->fetch_assoc()) {
                        $id = $row["id"];
                        $nome = $row["nome"];
                        $email = $row["email"];
                        $grupo = $row["grupo"];
                ?>
                <tr id="linha-usuario-<?php echo $id; ?>">
                   
                    <td><?php echo $nome; ?></td>
                    <td><?php echo $email; ?></td>
                    <td><?php echo $grupo; ?></td>
                    <td>
                        <button class='button-edit'
                        
                            onclick="openPopup(<?php echo $id; ?>)">Editar
                            <button class='button-excluir'
                                onclick="apagarUsuarioDados(<?php echo $id; ?>)">Excluir</button>
                    </td>
                </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='3'>Nenhum registro encontrado.</td></tr>";
                }
                $mysqli->close();
                ?>
            </tbody>
        </table>

        <!-- Início Modal editar usuário -->
        <?php include '../src/modalEdit.php'; ?>
        <!-- Fim Modal editar usuário -->
    </section>

    <footer>
       <p>&copy; 2023 Procuradoria Geral do Estado do Paraná. Todos os direitos reservados.</p>
    </footer>
    <script src="../script/utils.js"></script>
    <script src="../script/popupEdit.js"></script>
    <script src="../script/deleteUser.js"></script>
    <script src="../js/sweetalert2.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

    
</body>

</html>
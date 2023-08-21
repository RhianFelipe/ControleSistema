<?php
session_start();

// Verifica se a solicitação é do tipo POST e se os campos de usuário e senha estão definidos
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['usuario']) && isset($_POST['senha'])) {
    $conexao_file = "./db/conexao.php";
    if (!file_exists($conexao_file)) {
        die("Erro: Arquivo de conexão não encontrado.");
    }

    include $conexao_file;

    // Usando prepared statements para evitar SQL Injection
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    $stmt = $mysqli->prepare("SELECT * FROM admin WHERE usuario = ? AND senha = ?");
    $stmt->bind_param("ss", $usuario, $senha);
    $stmt->execute();

    // Armazena o resultado da consulta em variáveis ​​associativas
    $stmt->store_result();
    $num_rows = $stmt->num_rows;
    $stmt->bind_result($id, $usuario, $senha, $nome);

    // Verifica se há um único resultado e autentica o usuário
    if ($num_rows == 1 && $stmt->fetch()) {
        // Armazena os dados do usuário na sessão
        $_SESSION['user'] = $id;
        $_SESSION['nome'] = $nome;

        // Redireciona para a página de filtro após o login bem-sucedido
        header("Location: ./public/pageFiltro.php");
        exit();
    } else {
        // Define uma variável de sessão para indicar um erro de login
        $_SESSION['login_error'] = true;
        header("Location: ../index.php");
        exit();
    }

    // Fecha o prepared statement e a conexão
    $stmt->close();
    mysqli_close($mysqli);
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./public/main.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./public/style/telaLogin.css?v=<?php echo time(); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title>Login</title>
    <link rel="icon" href="../public/assets/img/icon-govpr.png" type="image/x-icon">
</head>

<body>
    <script src="./js/sweetalert2.js"></script>
    <?php include './src/login/modalCriarConta.php'; ?>

    <script>
        async function openModalCriarConta() {
            const criarContaModal = new bootstrap.Modal(
                document.getElementById("criarContaModal")
            );
            criarContaModal.show();
        }
    </script>

    <header>
        <img class="imgHeader" src=".\public\assets\img\logo-govpr-white.png">
    </header>
    <div id="area-form">
        <form id="form" method="POST" action="">
            <h1>Login</h1><br>
            <label>Usuário:</label>
            <input class="input-value" id="usuario" value="" placeholder="usuário" name="usuario" type="text" required><br>

            <label>Senha:</label>
            <input class="input-value" value="" placeholder="senha" name="senha" type="password" required><br>

            <!-- Links abaixo do input de senha -->
            <div class="links">
                <a href="esquecerSenha.php">Esquecer senha</a>
               <!-- <a href="javascript:void(0);" onclick="openModalCriarConta()">Criar nova conta</a> -->
            </div>

            <button id="button-submit" type="submit">Login</button>
        </form>
    </div>

    <footer>
        <p>&copy; 2023 Procuradoria Geral do Estado do Paraná. Todos os direitos reservados.</p>
        <div class="contact-info">
            <a href="mailto:estag.rhian@pge.pr.gov.br" class="contact-link">
                <img src="https://1000logos.net/wp-content/uploads/2021/05/Gmail-logo.png" alt="Email" class="contact-icon" style="width: 50px;">
            </a>
            <a href="https://github.com/RhianFelipe" target="_blank" class="contact-link">
                <img src="https://cdn-icons-png.flaticon.com/512/25/25231.png" alt="GitHub" class="contact-icon" style="width: 25px;">
            </a>
        </div>
    </footer>

    <?php
    // Exibe uma mensagem de erro caso a variável de sessão esteja definida
    if (isset($_SESSION['login_error']) && $_SESSION['login_error']) {
        echo "<script>
  
        window.onload = function() {
            Swal.fire(
                'Falha ao logar!',
                'Usuário ou senha incorretos!',
                'error'
            );
        }
    </script>";

        $_SESSION['login_error'] = false;
    }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>

</html>
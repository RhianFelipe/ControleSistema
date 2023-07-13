<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['usuario']) && isset($_POST['senha'])) {
    include "../db/conexao.php";

    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    $consulta = "SELECT * FROM admin WHERE usuario = ? AND senha = ?";
    $stmt = mysqli_prepare($mysqli, $consulta);
    mysqli_stmt_bind_param($stmt, 'ss', $usuario, $senha);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    if ($resultado->num_rows == 1) {
        $user = $resultado->fetch_assoc();

        $_SESSION['user'] = $user['id'];
        $_SESSION['nome'] = $user['nome'];

        header("Location: ../public/pageFiltro.php");
        exit();
    } else {
        $_SESSION['login_error'] = true;
        header("Location: ../public/pageLogin.php");
        exit();
    }

    mysqli_stmt_close($stmt);
    mysqli_close($mysqli);
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/main.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../public/style/telaLogin.css?v=<?php echo time(); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title>Login</title>
    <link rel="icon" href="../public/assets/img/icon-govpr.png" type="image/x-icon">
</head>

<body>
    <header>
        <img class="imgHeader" src="..\public\assets\img\logo-govpr-white.png">
    </header>

    <div id="area-form">
        <form id="form" method="POST" action="">
            <h1>Login</h1><br>
            <label>Usuário:</label>
            <input class="input-value" id="usuario" value="" placeholder="usuário" name="usuario" type="text" required><br>

            <label>Senha:</label>
            <input class="input-value" value="" placeholder="senha" name="senha" type="password" required><br>

            <button id="button-submit" type="submit">login</button>
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
    <script src="../js/sweetalert2.js"></script>
</body>

</html>

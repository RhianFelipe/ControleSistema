<?php
session_start(); // Inicia a sessão

// Verifica se os campos de usuário e senha foram enviados via POST
if (isset($_POST['usuario']) && isset($_POST['senha'])) {
    // Inclui o arquivo de conexão com o banco de dados
    include "../db/conexao.php";

    // Obtém os valores do usuário e senha do formulário
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    // Utiliza declarações preparadas para evitar ataques de injeção de SQL
    $consulta = "SELECT * FROM admin WHERE usuario = ? AND senha = ?";
    $stmt = mysqli_prepare($mysqli, $consulta);
    mysqli_stmt_bind_param($stmt, 'ss', $usuario, $senha);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    // Verifica se encontrou um registro com o usuário e a senha informados
    if ($resultado->num_rows == 1) {
        $user = $resultado->fetch_assoc();

        // Define as variáveis de sessão
        $_SESSION['user'] = $user['id'];
        $_SESSION['nome'] = $user['nome'];

        // Redireciona o usuário para a página desejada
        header("Location: ../public/pageFiltro.php");
        exit();
    } else {
        echo "Falha ao logar! Usuário ou senha incorretos!";
    }

    // Fecha o statement
    mysqli_stmt_close($stmt);
    // Fecha a conexão com o banco de dados
    mysqli_close($mysqli);
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Importar folhas de estilo -->
    <link rel="stylesheet" href="../public/main.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../public/style/telaCadastro.css?v=<?php echo time(); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
   
    <title>Login</title>
    <link rel="icon" href="../public/assets/img/icon-govpr.png" type="image/x-icon">
</head>

<body>
    <!-- Criação do Header para logo e navegação-->
    <header>
        <img class="imgHeader" src="..\public\assets\img\logo-govpr-white.png">
        
    </header>

    <!-- Criação formulário para cadastro de Usuário-->
    <div id="area-form">
        <form id="form" method="POST" action="">
            <h1>Login</h1><br>
            <label>Usuário:</label>
            <input class="input-value" id="usuario" value="" placeholder="usuário" name="usuario" type="text" required><br>

            <label>Senha:</label>
            <input class="input-value" value="" placeholder="senha" name="senha"  type="password" required><br>
          
            <button id="button-submit" type="submit">Cadastrar</button>
        </form>
    </div>

    <footer>
        <p>&copy; 2023 Procuradoria Geral do Estado do Paraná. Todos os direitos reservados.</p>
    </footer>

</body>

</html>

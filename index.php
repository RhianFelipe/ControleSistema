<?php
session_start();

$conexao_file = "./db/conexao.php";

if (!file_exists($conexao_file)) {
    die("Erro: Arquivo de conexão não encontrado.");
}

include $conexao_file;

if (isset($_POST['usuario']) && isset($_POST['senha'])) {
    // Usando mysqli->real_escape_string para evitar injeção de SQL
    $usuario = $mysqli->real_escape_string($_POST['usuario']);
    $senha_digitada = $mysqli->real_escape_string($_POST['senha']);

    // Construa a consulta SQL
    $sql = "SELECT id, senha, usuario, permissao FROM admin WHERE usuario = '$usuario'";
    $result = $mysqli->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $id = $row['id'];
            $senha_bd = $row['senha'];
            $permissao = $row['permissao'];

            // Descriptografa a senha do BD usando cifra de César chave 3
            $senha_descriptografada = '';
            for ($i = 0; $i < strlen($senha_bd); $i++) {
                $char = $senha_bd[$i];
                $decrypted_char = chr(ord($char) - 3);
                $senha_descriptografada .= $decrypted_char;
            }

            // Verifique se a senha digitada corresponde à senha do BD
            if ($senha_digitada === $senha_descriptografada) {
                // Inicia a sessão antes de atribuir valores
               
                $_SESSION['user'] = $id;
                $_SESSION['nome'] = $usuario;
                $_SESSION['permissao'] = $permissao;

                // Verifique o valor da permissão e redirecione conforme necessário
                if ($permissao == 1) {
                    // Redireciona para a página de filtro após o login bem-sucedido
                    header("Location: ./public/pageFiltro.php");
                    exit();
                } else {
                    // Redireciona para outra página
                    header("Location: ./view/public/viewFiltro.php");
                    exit();
                }
            } else {
                // Define uma variável de sessão para indicar um erro de login
                $_SESSION['login_error'] = true;
                header("Location: ../index.php");
                exit();
            }
        } else {
            // Define uma variável de sessão para indicar um erro de login
            $_SESSION['login_error'] = true;
            header("Location: ../index.php");
            exit();
        }
    } else {
        echo "Erro na consulta ao banco de dados.";
    }

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
<script src="./js/sweetalert2.js"></script>
<?php // include './src/login/modalCriarConta.php'; 
?>

<script>
  /*
   async function openModalCriarConta() {
    const criarContaModal = new bootstrap.Modal(
      document.getElementById("criarContaModal")
    );
    criarContaModal.show();
  }
  */
</script>

<body>
  <div class="grid-container">
    <div class="colun-left">
      <div class="div-form-login">
        <div id="area-form">
          <form id="form" method="POST" action="">
            <h2 class="h2-fontsize">PROCURADORIA- GERAL DO ESTADO DO PARANÁ</h2><br>
            <h4 class="h2-fontsize">CONTROLE DE SISTEMAS</h4><br>
            <p class="text-form-login">Preencha os campos abaixo para entrar no sistema. </p>
            <label class="text-form-login">Usuário:</label>
            <input class="input-value" id="usuario" value="" name="usuario" type="text" required><br>

            <label class="text-form-login">Senha:</label>
            <input class="input-value" value="" name="senha" type="password" required><br>

            <button id="button-submit" type="submit">Login</button><br>
            <!--<a href="#">Esqueci minha senha</a>-->


          </form>
        </div>
      </div>
    </div>

    <div class="colun-right">
      <img src="public\assets\img\bg-imagem-login.jpg" />
      <div class="row">
        <img class="img-row" src="public\assets\img\logo-governo-branco.png">
      </div>
    </div>
  </div>

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
  <script src="../js/sweetalert2.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>

<!--guardando código

<header>
        <img class="imgHeader" src="..\public\assets\img\logo-govpr-white.png">
</header>

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
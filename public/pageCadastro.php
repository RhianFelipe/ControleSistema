<?php
// Incluir arquivo de conexão com o banco de dados e arquivo de pop-up
include "../src/cadastrarUser.php";

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
    <!-- Importar folhas de estilo -->
    <link rel="stylesheet" href="../public/main.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../public/style/telaCadastro.css?v=<?php echo time(); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="../script/utils.js"></script>
    <script src="../js/sweetalert2.js"></script>
    <title>Cadastrar Usuário</title>
    <link rel="icon" href="../public/assets/img/icon-govpr.png" type="image/x-icon">
</head>

<body>

    <!-- Criação do Header para logo e navegação-->

    <style>
        .column-container {
            display: flex;
            flex-wrap: wrap;
        }

        .selects-permissoes {
            flex-basis: 50%;
            margin-bottom: 10px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        .custom-select {
            width: 100%;
            padding: 6px 12px;
            font-size: 14px;
            line-height: 1.42857143;
            color: #555555;
            background-color: #ffffff;
            background-image: none;
            border: 1px solid #cccccc;
            border-radius: 4px;
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
            transition: border-color ease-in-out 0.15s, box-shadow ease-in-out 0.15s;
        }
    </style>

    <header>
        <img class="imgHeader" src="..\public\assets\img\logo-govpr-white.png">
        <nav class="navbar">

            <li class="list-header"><a class="a1" href="../public/pageFiltro.php">Filtrar Usuários</a></li>
            <li class="list-header"><a class="a1" href="../public/pageLista.php">Lista de Usuários</a></li>
            <li class="list-header"><a class="a1" href="../public/pageLogs.php">Logs de Usuário</a></li>

        </nav>
    </header>

    <!-- Criação formulário para cadastro de Usuário-->
    <div id="area-form">
        <form id="form" method="POST" action="../src/cadastrarUser.php">
            <h1>Cadastrar Usuário</h1><br>
            <label>Nome:</label>
            <input class="input-value" id="nome" value="" placeholder="nome" name="nome" type="text" required><br>

            <label>E-mail:</label>
            <input class="input-value" value="" placeholder="usuario@pge.pr.gov.br" name="email" type="text" required><br>

            <label>Grupo:</label>
            <!-- Obter valores dos grupos do banco de dados e mostrá-los em um menu suspenso -->
            <select class="input-value" name="grupo">
                <?php
                $gruposPermitidos = array("Procurador", "Servidor", "Tercerizado", "Estagiário", "Advogado");
                foreach ($gruposPermitidos as $grupoPermitido) {
                    echo "<option value='$grupoPermitido'>$grupoPermitido</option>";
                }
                ?>
            </select>

            <label>Gerenciar Permissões:</label>
            <button id="button-permissao" type="button">Permissões</button><br>

            <button id="button-submit" type="submit">Cadastrar</button>
        </form>
        <!-- Modal para gerenciar permissões -->
        <div class="modal fade" id="editUsuarioModal" tabindex="-1" aria-labelledby="editUsuarioModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editUsuarioModalLabel">Gerenciar Permissões</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="col-12">
                            <form id="modalForm">
                                <!-- Adicione os selects gerados dinamicamente aqui -->
                                <?php
                                include "../db/conexao.php";

                                $sql = "SELECT DISTINCT nomeSistema
        FROM admin
        WHERE nomeSistema NOT LIKE '%:%' AND nomeSistema <> ''
";
                                $result = mysqli_query($mysqli, $sql);

                                // Verificar se a consulta teve resultados
                                if (mysqli_num_rows($result) > 0) {
                                    $sistemas = array();

                                    // Loop pelos resultados da consulta
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $nomeSistema = $row['nomeSistema'];
                                        // Verificar se o nome do sistema é válido
                                        $sistemas[] = $nomeSistema;
                                    }

                                    echo '<div class="column-container">';
                                    foreach ($sistemas as $nomeSistema) {
                                        echo '<div class="selects-permissoes">';
                                        echo "<label for='$nomeSistema'>$nomeSistema:</label>";
                                        echo "<select class='' name='sistemas[$nomeSistema]' id='$nomeSistema'>";
                                        echo "<option value='0'>Não</option>";
                                        echo "<option value='1'>Sim</option>";
                                        echo "</select>";
                                        echo "</div>";
                                    }
                                    echo '</div>';
                                }
                                ?>

                                <!-- Fim dos selects gerados dinamicamente -->
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">

                        <button type="button" class="btn btn-primary" id="salvarModal">Salvar</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <footer>
        <p>&copy; 2023 Procuradoria Geral do Estado do Paraná. Todos os direitos reservados.</p>
    </footer>


    <script src="../script/utils.js"></script>
    <script src="../script/cadastrarUser.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
 
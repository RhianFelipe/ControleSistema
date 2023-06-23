<?php
// Incluir arquivo de conexão com o banco de dados e arquivo de pop-up
include "../src/cadastrarUser.php";
cadastrarUsuario();
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
    <title>Cadastrar Usuário</title>
</head>

<body>
    <!-- Criação do Header para logo e navegação-->
    <header>
        <img class="imgHeader" src="..\public\assets\img\logo-govpr-white.png">
        <nav class="navbar">
            
            <li class="list-header"><a class="a1" href="../public/pageFiltro">Voltar para Filtro</a> </li>
        </nav>
    </header>

    <!-- Criação formulário para cadastro de Usuário-->
    <div id="area-form">
        <form id="form" method="POST" action="../public/pageCadastro.php">
            <h1>Cadastrar Usuário</h1><br>
            <label>Nome:</label>
            <input class="input-value" id="nome" value="<?php if(isset($_POST['nome']))?>"
                placeholder="nome" name="nome" type="text" required><br>

            <label>E-mail:</label>
            <input class="input-value" value="<?php if(isset($_POST['email'])) ?>"
                placeholder="usuario@pge.pr.gov.br" name="email" type="text" required><br>


            <label>Grupo:</label>
            <!-- Obter valores dos grupos do banco de dados e mostrá-los em um menu suspenso -->
            <select class="input-value" name="grupo">
                <?php
                $gruposPermitidos = array("Procurador", "Servidor", "Tercerizado", "Estagiário", "Advogado");
                foreach ($gruposPermitidos as $grupoPermitido) {
                    echo "<option value='$grupoPermitido'>$grupoPermitido</option>";
                }
                ?>
            </select> <br>
            <label>Gerenciar Permissões:</label>
            <!-- Criação da tabela de permissões -->

            <button onclick="gerenciarPermissoes() " id="button-permissao" type="button">Permissões</button> <br>
            <div id="selects-permissoes" style="display: none; ">
                <h3>Permissões:</h3>
                <p>Marque as permissões para cada sistema:</p>
                <?php
                $sistemas = array(
                    "admIntranet" => "ADM/INTRANET",
                    "admInternet" => "ADM/INTERNET",
                    "arisp" => "ARISP",
                    "copel" => "Copel",
                    "detran" => "Detran",
                    "documentador" => "Documentador",
                    "sipro" => "Sipro",
                    "eProtocolo" => "eProtocolo"
                );
                foreach ($sistemas as $nomeSistema => $descricaoSistema) {
                    echo "<div class='selects-permissoes'>";
                    echo "<label for='$nomeSistema'>$descricaoSistema:</label>";
                    echo "<select name='sistemas[$nomeSistema]' id='$nomeSistema'>"; // Adiciona o atributo id
                    echo "<option value='0'>0</option>";
                    echo "<option value='1'>1</option>";
                    echo "</select>";
                    echo "</div><br><br>";
                }
                ?>
            </div>
            <button id="button-submit" type="submit">Cadastrar</button>
        </form>
    </div>

    <footer></footer>
    <script>

    </script>
    <script src="../script/utils.js"></script>
</body>

</html>
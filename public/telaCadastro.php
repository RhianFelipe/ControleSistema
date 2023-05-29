
<?php 
include "../db/conexao.php";
include "../db/consulta.php";



?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Importar folhas de estilo -->
    <link rel="stylesheet" href="../public/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../public/style/telaCadastro.css?v=<?php echo time(); ?>">
    <title>Cadastrar Usuário</title>
</head>

<body>
    <!-- Criação do Header para logo e navegação-->
    <header>
        <img src="../public/assets/img/logo-govpr.png" alt="">
        <a href="../public/index.php">Voltar para Filtro</a>
    </header>

    <!-- Criação formulário para cadastro de Usuário-->
    <div id="area-form">
        <form id="form" method="POST" action="../src/cadastrarUser.php">
            <h1>Cadastrar Usuário</h1><br>
            <label>Nome:</label>
            <input class="input-value" id="nome" placeholder="nome" name="nome" type="text" required><br>
            <label>E-mail:</label>
            <input class="input-value" placeholder="usuario@pge.pr.gov.br" name="email" type="text" required><br>
            <label>Grupo:</label>
            <!-- Obter valores dos grupos do banco de dados e mostrá-los em um menu suspenso -->
            <select class="input-value" name="grupo">
                <?php
                while ($colunaGrupo = mysqli_fetch_array($queryBuscaGrupo)) { ?>
                    <option value="<?= $colunaGrupo['grupo'] ?>"><?php echo $colunaGrupo['grupo']; ?></option> <?php } ?>
            </select> <br>
            <label>Gerenciar Permissões:</label>
            <!-- Criação da tabela de permissões -->

            <button onclick="togglePermissoes() " id="button-permissao" type="button">Permissões</button> <br>
            <div id="selects-permissoes" style="display: none;">
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
  
    <script >
         function togglePermissoes() {
            var selectsPermissoes = document.getElementById('selects-permissoes');
            var buttonPermissao = document.getElementById('button-permissao');
            if (selectsPermissoes.style.display === 'none') {
                selectsPermissoes.style.display = 'block';
                buttonPermissao.textContent = 'Ocultar Permissões';
            } else {
                selectsPermissoes.style.display = 'none';
                buttonPermissao.textContent = 'Permissões';
            }
        }
    </script>


</body>

</html>

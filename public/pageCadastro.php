<?php
// Incluir arquivo de conexão com o banco de dados e arquivo de pop-up
$pageTitle = "Cadastrar Usuários";
include "../src/cadastrarUser.php";
include_once "../db/consulta.php";
session_start();

// Verifica se a variável de sessão está definida
if (!isset($_SESSION['user'])) {
    // Redireciona o usuário para o painel de login
    header("Location: ../index.php");
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
    <?php include 'header.php'; ?>

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
            <select class="input-value" name="grupo" id="grupo">
                <?php
                $gruposPermitidos = array("Procurador", "Servidor", "Terceirizado", "Estagiário", "Advogado", "Externo");
                foreach ($gruposPermitidos as $grupoPermitido) {
                    echo "<option value='$grupoPermitido'>$grupoPermitido</option>";
                }
                ?>
            </select>
            <label>Setor:</label>
            <!-- Obter valores dos grupos do banco de dados e mostrá-los em um menu suspenso -->
            <select class="input-value" name="setor" id="setor">
                <?php
                include_once "../db/consulta.php";
                foreach ($setores as $setor) {
                    echo "<option value='$setor'>$setor</option>";
                }
                ?>
            </select>
            <div class="termo-sid-container">
                <div class="termo-container">
                    <label for="termoUso" title="Termo de Uso e Responsabilidade">TUR?</label>
                    <input class="checkbox" type="checkbox" id="termoUso" name="termoUso">
                </div>

                <div class="termo-container">
                    <label for="termoCompromisso" title="Termo de Compromisso e Confidencialidade">TCC?</label>
                    <input class="checkbox" type="checkbox" id="termoCompromisso" name="termoCompromisso">
                </div>

                <div class="termo-container">

                    <input class="form-control" type="text" id="sidTermos" name="sidTermos" placeholder="SID Termos" required>
                </div>
            </div>


            <div class="termo-container" hidden>
                <label for="sidWifi" title="SID Wifi">SID</label>
                <input class="form-control" type="text" id="sidWifi" name="sidWifi" placeholder="SID Termos">
            </div>
            <div class="termo-container" hidden>
                <label for="sidVPN" title="SID VPN">SID</label>
                <input class="form-control" type="text" id="sidVPN" name="sidVPN" placeholder="SID Termos">
            </div>


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

                                $sql = "SELECT DISTINCT nomeSistema FROM admin  WHERE nomeSistema NOT LIKE '%:%' AND nomeSistema <> ''";
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
        <div class="contact-info">
            <a href="mailto:estag.rhian@pge.pr.gov.br" class="contact-link">
                <img src="https://1000logos.net/wp-content/uploads/2021/05/Gmail-logo.png" alt="Email" class="contact-icon" style="width: 50px;">
            </a>
            <a href="https://github.com/RhianFelipe" target="_blank" class="contact-link">
                <img src="https://cdn-icons-png.flaticon.com/512/25/25231.png" alt="GitHub" class="contact-icon" style="width: 25px;">
            </a>
        </div>
    </footer>
    <?php include '../src/sistema/modalSistema.php'; ?>
    <script src="../script/utils.js"></script>
    <script>
        // Evento de mudança no select do grupo
        document.getElementById('grupo').addEventListener('change', function() {
            const grupoSelecionado = this.value;
            const termoCompromissoCheckbox = document.getElementById('termoCompromisso');

            if (grupoSelecionado === 'Terceirizado') {
                // Se o grupo for "Terceirizado", desabilita o checkbox do segundo termo
                termoCompromissoCheckbox.disabled = true;
            } else {
                // Se o grupo não for "Terceirizado", habilita o checkbox do segundo termo
                termoCompromissoCheckbox.disabled = false;
            }
        });
    </script>
    <script src="../script/cadastrarUser.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="../script/utils.js"></script>
    <script src="../js/sweetalert2.js"></script>
    <title>Cadastrar Usuário</title>
    <link rel="icon" href="../public/assets/img/icon-govpr.png" type="image/x-icon">
</head>

<body>
    <!-- Criação do Header para logo e navegação-->
    <header>
        <img class="imgHeader" src="..\public\assets\img\logo-govpr-white.png">
        <nav class="navbar">
            <li class="list-header"><a class="a1" href="../public/pageFiltro.php">Voltar para Filtro</a> </li>
        </nav>
    </header>

    <!-- Criação formulário para cadastro de Usuário-->
    <div id="area-form">
        <form id="form" method="POST" action="../src/cadastrarUser.php">
            <h1>Cadastrar Usuário</h1><br>
            <label>Nome:</label>
            <input class="input-value" id="nome" value="" placeholder="nome" name="nome" type="text" required><br>

            <label>E-mail:</label>
            <input class="input-value" value="" placeholder="usuario@pge.pr.gov.br" name="email" type="text"
                required><br>

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
        <div class="modal fade" id="editUsuarioModal" tabindex="-1" aria-labelledby="editUsuarioModalLabel"
            aria-hidden="true">
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
                                    // Mostrar os valores em selects
                                    if (!empty($sistemas)) {
                                        foreach ($sistemas as $nomeSistema) {
                                            echo "<div class='selects-permissoes col-md-6'>"; // Adicione a classe "col-md-6" para criar duas colunas
                                            echo "<label for='$nomeSistema'>$nomeSistema:</label>";
                                            echo "<select class='form-select' name='sistemas[$nomeSistema]' id='$nomeSistema'>"; // Adicione a classe "form-select" para estilizar os selects
                                            echo "<option value='0'>Não</option>";
                                            echo "<option value='1'>Sim</option>";
                                            echo "</select>";
                                            echo "</div><br><br>";
                                        }
                                        
                                    }
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
   <script>
    function abrirModalPermissoes() {
        const editSistema = new bootstrap.Modal(document.getElementById('editUsuarioModal'));
        editSistema.show();
    }

    // Evento de clique no botão "Permissões"
    document.getElementById('button-permissao').addEventListener('click', abrirModalPermissoes);

    // Enviar os dados do formulário para o arquivo PHP
    document.getElementById('form').addEventListener('submit', function (event) {
        event.preventDefault(); // Impedir o envio padrão do formulário

        const formData = new FormData(this);

        // Enviar os dados selecionados na modal para o FormData
        const modalForm = document.getElementById('modalForm');
        const selectsModal = modalForm.getElementsByTagName('select');
        for (let i = 0; i < selectsModal.length; i++) {
            const select = selectsModal[i];
            const nomeSistema = select.id;
            const valor = select.value;
            formData.append(`sistemas[${nomeSistema}]`, valor);
        }

        // Enviar os dados do formulário para o arquivo PHP usando Fetch API
        fetch(this.action, {
            method: this.method,
            body: formData
        })
            .then(function (response) {
                return response.json();
            })
            .then(function (data) {
                if (data.status) {
                    Swal.fire({
                        text: data.msg,
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Fechar'
                    });
                } else {
                    Swal.fire({
                        text: data.msg,
                        icon: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Fechar'
                    });
                }
            })
            .catch(function (error) {
                console.error(error);
            });
    });

    // Evento de clique no botão "Salvar"
    document.getElementById('salvarModal').addEventListener('click', function () {
        Swal.fire({
            text: 'Os dados foram salvos.',
            icon: 'success',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Fechar'
        });
    });
</script>

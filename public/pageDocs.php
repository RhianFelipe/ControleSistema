<?php
// Incluir arquivo de conexão com o banco de dados e arquivo de pop-up
$pageTitle = "Documentação";
include_once "../db/conexao.php";
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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/main.css">
    <link rel="stylesheet" href="../public/style/telaDocs.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="icon" href="../public/assets/img/icon-govpr.png" type="image/x-icon">
    <title>Documentação</title>
</head>

<body>
    <header>


        <a href="../public/pageFiltro.php">
            <img class="imgHeader" src="..\public\assets\img\logo-govpr-white.png" alt="Descrição da imagem">
        </a>

        <nav class="navbar">
            <a class="home-link" title="Página Inicial" href="../public/pageFiltro.php">
                <img src="../public/assets/img/icons8-home-64.png" alt="Home">
            </a>

            <div class="dropdown">
                <button class="dropbtn"><img src="../public/assets/img/icon-profile.png" alt=""></button>
                <div class="dropdown-content">
                    <p id="username"><?php echo $_SESSION['nome']; ?></p>
                    <a href="../admin/src/public/pageAdmin.php">Admin</a>
                    <a href="../public/pageDocs.php">Documentação</a>
                    <a href="?logout=1">Sair</a>
                </div>
            </div>
        </nav>
    </header>
    <nav>
        <ul class="navs-docs">
            <li><a href="#guia-utilizacao">Guia de Utilização</a></li>
            <li><a href="#log-versao">Log de Versão</a></li>
        </ul>
    </nav>

    <?php
    if (isset($_GET['logout'])) {
        session_destroy();
        header("Location: ../index.php");
        exit();
    }
    ?>

    <style>
        /* Estilo para links que ativam as descrições */
        .link-description {
            cursor: pointer;
            /* Altera o cursor para indicar que é clicável */
            color: #333;
            /* Cor do texto (pode personalizar) */
            text-decoration: none;
            /* Remove a sublinhagem padrão */
            font-weight: bold;
            /* Define a fonte como negrito (pode personalizar) */
            transition: color 0.3s ease-in-out, text-decoration 0.3s ease-in-out;
            /* Efeito de transição suave na cor e na sublinhagem */
        }

        .link-description:hover {
            color: #555;
            /* Cor alterada ao passar o mouse (pode personalizar) */
            text-decoration: underline;
            /* Adiciona sublinhagem ao passar o mouse */
        }

        /* Estilos para a seção tutorial */
        #tutorial1 {
            display: none;
            padding: 20px;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        #tutorial1 h4 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
            font-family: Arial, sans-serif;
        }

        #tutorial1 p {
            font-size: 18px;
            font-family: Arial, sans-serif;
            line-height: 1.5;
        }

        #tutorial1 ul {
            list-style: none;
            margin-left: 0;
            padding-left: 20px;
        }

        #tutorial1 li {
            font-size: 15px;
            font-family: Arial, sans-serif;
            margin-bottom: 10px;
        }

        #tutorial1 span {
            font-weight: bold;
            color: #007bff;
        }

        p#username {
            text-align: center;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 5px;
            margin-bottom: 0;
        }


        /* Estilo para o ícone da casa */
        .home-link img {
            width: 45px;
            /* Defina a largura desejada */
            height: 50px;
            /* Defina a altura desejada */
            margin-right: 1rem;
        }
    </style>
    <main>
        <section id="guia-utilizacao">
            <h2>Guia de Utilização</h2>
            <p>Este é o guia para utilizar o CSSPR</p>

            <!-- Links para tutoriais e guias -->
            <h3>Tutoriais</h3>
            <ul>
                <li>
                    <a href="#" class="link-description" onclick="toggleDescription('tutorial1')">Padrões de Nomes dos
                        Sistemas</a>
                    <!-- Descrição do Tutorial 1 (inicialmente oculta) -->
                    <div id="tutorial1" style="display: none;">
                        <p>
                            O padrão para nomear os sistemas deve seguir esta fórmula: <br>
                            <strong>&lt;Inicial Maiúscula&gt;&lt;nome
                                sistema&gt;</strong>.
                            Para sistemas com permissão de administrador, adicione um parêntese indicando a função. Exemplos:
                        </p>
                        <ul>
                            <li>Internet(adm)</li>
                            <li>Intranet(adm)</li>
                        </ul>

                    </div>
                </li>

                <li>
                    <a href="#" class="link-description" onclick="toggleDescription('tutorial2')">Tutorial 2</a>
                    <!-- Descrição do Tutorial 2 (inicialmente oculta) -->
                    <div id="tutorial2" style="display: none;">
                        <h4>Descrição do Tutorial 2</h4>
                        <p>Este é o conteúdo do Tutorial 2.</p>
                    </div>
                </li>

                <li>
                    <a href="#" class="link-description" onclick="toggleDescription('tutorial3')">Tutorial 3</a>
                    <!-- Descrição do Tutorial 3 (inicialmente oculta) -->
                    <div id="tutorial3" style="display: none;">
                        <h4>Descrição do Tutorial 3</h4>
                        <p>Este é o conteúdo do Tutorial 3.</p>
                    </div>
                </li>
            </ul>

            <h3>Guias</h3>
            <ul>
                <li><a class="link-description" href="#">Guia 1</a></li>
                <li><a class="link-description" href="#">Guia 2</a></li>
                <!-- Adicione mais guias aqui -->
            </ul>



            <!-- Link para o Guia do Usuário em PDF -->
            <h3>Guia do Usuário</h3>
            <p>Consulte o <a href="https://drive.google.com/file/d/1TQsNzOh2nXZ3CPCH-QYpylbgOE-mcXgJ/view?usp=drive_link" target="_blank">Guia do Usuário (PDF)</a> para obter informações detalhadas sobre como utilizar o
                projeto.</p>
        </section>

        <section id="log-versao">
            <h2>Log de Versão</h2>
            <ul>
                <li>
                    <h3>v1.8.12</h3>
                    <p>Data de Início: 29 de Setembro de 2023</p>
                    <ul id="log-list">

                    </ul>
                </li>
                <!-- Adicione mais entradas de log de versão conforme necessário -->
            </ul>
        </section>
    </main>
    <style>
        /* Remova a borda e estilização padrão do botão */
        button.dropbtn {
            border: none;
            background: none;
            padding: 0;
            cursor: pointer;
        }

        /* Defina a largura e altura máxima para a imagem */
        button.dropbtn img {
            max-width: 100%;
            max-height: 100%;
        }

        /* Remova o contorno ao focar o botão (opcional) */
        button.dropbtn:focus {
            outline: none;
        }
    </style>
    <script>
        // Função para alternar a exibição da descrição do tutorial
        function toggleDescription(tutorialId) {
            const tutorial = document.getElementById(tutorialId);
            if (tutorial.style.display === 'none' || tutorial.style.display === '') {
                tutorial.style.display = 'block';
            } else {
                tutorial.style.display = 'none';
            }
        }

        // Seu nome de usuário e nome do repositório
        const username = 'RhianFelipe';
        const repoName = 'ControleSistema';

        // URL da API do GitHub para obter os commits
        const apiUrl = `https://api.github.com/repos/${username}/${repoName}/commits?per_page=10`;

        // Função para buscar os commits e atualizar o log de versão
        async function updateLog() {
            try {
                const response = await fetch(apiUrl);
                const commits = await response.json();
                const logList = document.getElementById('log-list');

                // Limpar o log de versão existente
                logList.innerHTML = '';

                // Iterar pelos 10 commits mais recentes e adicionar à lista
                commits.slice(0, 10).forEach(commit => {
                    const listItem = document.createElement('li');
                    listItem.classList.add('commit-entry');

                    // Adicionar a data do commit na mesma linha da mensagem do commit
                    const commitMessage = document.createElement('span');
                    commitMessage.textContent =
                        `${new Date(commit.commit.author.date).toLocaleDateString()} - ${commit.commit.message}`;
                    listItem.appendChild(commitMessage);

                    logList.appendChild(listItem);
                });
            } catch (error) {
                console.error('Erro ao buscar commits:', error);
            }
        }

        // Chamar a função para atualizar o log de versão
        updateLog();

        // Função para exibir a guia clicada
        function showTab(tabId) {
            const sections = document.querySelectorAll('section');
            sections.forEach(section => {
                section.style.display = 'none';
            });
            const tab = document.getElementById(tabId);
            tab.style.display = 'block';
        }

        // Exibir a primeira guia por padrão
        showTab('guia-utilizacao');

        document.querySelector('a[href="#guia-utilizacao"]').addEventListener('click', function(e) {
            e.preventDefault();
            showTab('guia-utilizacao');
        });

        document.querySelector('a[href="#log-versao"]').addEventListener('click', function(e) {
            e.preventDefault();
            showTab('log-versao');
        });
    </script>
</body>

</html>
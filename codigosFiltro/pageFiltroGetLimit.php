<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/main.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../public/style/telaFiltro.css?v=<?php echo time(); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
   
    <title>Sistema de Controle de Permissões</title>
</head>

<body onload="limparFiltragem()">
    <header>
        <img class="imgHeader" src="..\public\assets\img\logo-govpr-white.png">
        <nav class="navbar">
    
                <li class="list-header"><a class="a1" href="../public/pageCadastro.php">Cadastrar Usuários</a></li>
                <li class="list-header"><a class="a1" href="../public/pageLista.php">Lista de Usuários</a></li>
                <li class="list-header"><a class="a1" href="../public/pageLogs.php">Logs de Usuário</a></li>
          
        </nav>
    </header>
    <section class="area-consulta">
        <h1>Área de Consulta</h1>
        <form action="../src/filtrarUser.php" method="POST">
            <div>
                <label>Nome:</label>
                <input class="input-table" type="text" name="nome">
                <label>E-mail:</label>
                <input class="input-table" type="text" name="email">
                <button type="submit" onclick="ocultarListagem()">Filtrar</button>
            </div>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
           if (isset($_GET['resultados'])) {
            $resultadosCodificados = $_GET['resultados'];
            $resultados = json_decode($resultadosCodificados, true);
            if ($resultados !== null) {
                foreach ($resultados as $resultado) {
                    $id = $resultado['id'];
                    $nomeUsuario = $resultado['nome'];
                    $emailUsuario = $resultado['email'];
                    ?>
                    <tr id="linha-usuario-<?php echo $id; ?>">
                        <td><?php echo $nomeUsuario; ?></td>
                        <td><?php echo $emailUsuario; ?></td>
                        <td>
                            <button class="btn btn-outline-warning btn-sm" onclick="openPopup('<?php echo $id; ?>')">Editar</button>
                            <button class="btn btn-outline-danger btn-sm" onclick="apagarUsuarioDados('<?php echo $id; ?>')">Excluir</button>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                echo "<tr><td colspan='3'>Erro ao decodificar os resultados.</td></tr>";
            }
        } else {
            echo "<tr><td colspan='3'>Digite um nome ou email para filtrar.</td></tr>";
        }
?>        
            </tbody>
        </table>
    </section>


    <!-- Tabela para exibir os dados -->
    <span id="msgAlerta"></span>


    <!-- Início Modal editar usuário -->
    <?php include '../src/modalEdit.php'; ?>
    <!-- Fim Modal editar usuário -->

    <footer>
     <p>&copy; 2023 Procuradoria Geral do Estado do Paraná. Todos os direitos reservados.</p>
    </footer>
    <script src="../script/popupEdit.js"></script>
    <script src="../script/deleteUser.js"></script>
    <script src="../script/utils.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
</body>

</html>

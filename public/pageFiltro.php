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
            <ul>
                <li class="listHeader"><a class="a1" href="../public/pageCadastro.php">Cadastrar Usuários</a></li>
                <li class="listHeader"><a class="a2" href="../public/pageLista.php">Lista de Usuários</a></li>
            </ul>
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
                    $resultados = json_decode(urldecode($_GET['resultados']), true);
                    if (empty($resultados)) {
                        echo "<tr><td colspan='3'>Nenhum resultado encontrado.</td></tr>";
                    } else {
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
    <div class="modal fade" id="editUsuarioModal" tabindex="-1" aria-labelledby="editUsuarioModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUsuarioModalLabel">Editar Usuário</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form class="row g-3" id="edit-usuario-form">
                        <input type="hidden" name="id" id="editid">
                        <div class="col-12">


                            <table>
                                <tr>
                                    <th>Sistemas</th>
                                    <th>Permissão</th>
                                </tr>
                                <tr>
                                    <td id="sistemasEdit"></td>
                                    <td id="permissaoEdit"></td>
                                </tr>
                            </table>

                        </div>
                        <div class="col-12">
                            <input type="submit" class="btn btn-outline-warning btn-sm" id="edit-usuario-btn" value="Salvar">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Fim Modal editar usuário -->

    <footer>

        Todos os direitos reservados
    </footer>
    <script src="../script/popupEdit.js"></script>
    <script src="../script/deleteUser.js"></script>
    <script src="../script/utils.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
</body>

</html>
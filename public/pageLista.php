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

<body>
    <header>
        <img class="imgHeader" src="..\public\assets\img\logo-govpr-white.png">
        <nav class="navbar">
            <a href="../public/pageFiltro">Voltar para Filtro</a>
            <ul>
                <!-- Adicione aqui os itens do menu, se necessário -->
            </ul>
        </nav>
    </header>

    <!-- Tabela para exibir os dados -->
    <span id="msgAlerta"></span>
    <section>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Grupo</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Conexão com o banco de dados (substitua as informações de conexão com as suas)
                include "../db/conexao.php";

                // Consulta SQL para obter os dados
                $sql = "SELECT id, nome, email, grupo FROM usuarios ORDER BY nome";
                $result = $mysqli->query($sql);

                if ($result->num_rows > 0) {
                    // Exibe os dados na tabela
                    while ($row = $result->fetch_assoc()) {
                        $id = $row["id"];
                        $nome = $row["nome"];
                        $email = $row["email"];
                        $grupo = $row["grupo"];
                ?>
                        <tr id="linha-usuario-<?php echo $id; ?>">
                            <td><?php echo $id; ?></td>
                            <td><?php echo $nome; ?></td>
                            <td><?php echo $email; ?></td>
                            <td><?php echo $grupo; ?></td>
                            <td>
                                <button class='btn btn-outline-warning btn-sm' onclick="openPopup(<?php echo $id; ?>)">Editar</a>
                                    <button class='btn btn-outline-danger btn-sm' onclick="apagarUsuarioDados(<?php echo $id; ?>)">Excluir</button>
                            </td>
                        </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='3'>Nenhum registro encontrado.</td></tr>";
                }
                $mysqli->close();
                ?>
            </tbody>
        </table>

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
    </section>

    <footer>
        Todos os direitos reservados
    </footer>

    <script src="../script/popupEdit.js"></script>
    <script src="../script/deleteUser.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
</body>

</html>
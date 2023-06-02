<?php
include "../src/popup.php";
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/main.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../public/style/telaFiltro.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../public/style/popup.css?v=<?php echo time(); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

    <title>Sistema de Controle de Permissões</title>
</head>

<body>
    <header>
        <h1>Controle de Sistemas</h1>
        <a href="../public/pageCadastro.php">Cadastrar Usuários</a>
        <a href="">Lista de Usuários</a>
    </header>
    <section class="area-consulta">
        <h1>Área de Consulta</h1>
        <div>
            <label>Nome:</label> <input class="input-table" type="text">
            <label>E-mail:</label> <input class="input-table" type="text">

            <label>Sistemas:</label>
            <select name="permissao">
                <option selected value="0">0</option>
                <option value="1">1</option>
            </select>

            <label>Permissão:</label>
            <select name="permissao">
                <option selected value="0">0</option>
                <option value="1">1</option>
            </select>
        </div>
    </section>
    <!-- Tabela para exibir os dados -->
    <section>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Conexão com o banco de dados (substitua as informações de conexão com as suas)
                include "../db/conexao.php";

                // Consulta SQL para obter os dados
                $sql = "SELECT id, nome, email FROM usuarios ORDER BY nome";
                $result = $mysqli->query($sql);

                if ($result->num_rows > 0) {
                    // Exibe os dados na tabela
                    while ($row = $result->fetch_assoc()) {
                        $id = $row["id"];
                        $nome = $row["nome"];
                        $email = $row["email"];
                ?>
                        <tr>
                            <td><?php echo $id; ?></td>
                            <td><?php echo $nome; ?></td>
                            <td><?php echo $email; ?></td>
                            <td>
                                <span id="msgAlerta"></span>
                                <button class='btn btn-outline-warning btn-sm' onclick="openPopup(<?php echo $id; ?>)">Editar</a>

                                    <button onclick="">Excluir</button>
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
                        <span id="msgAlertaErroEdit"></span>
                        <form class="row g-3" id="edit-usuario-form">
                            <input type="hidden" name="id" id="editid">
                            <div class="col-12">
                            
                                <div class="col-12">

                                <td>
    
</td>

                                    <?php
                                    include "../db/conexao.php";

                                    echo "<div id='sistemasEdit'></div>";
                echo "<div id='permissaoEdit'></div>";

                                    $mysqli->close();
                                    ?>
                                </div>
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

    <script>
        async function openPopup(id) {
            console.log(id)

            const dados = await fetch('../src/editarUser.php?id=' + id);
            const resposta = await dados.json();

            console.log(resposta);
            if (!resposta['status']) {
                document.getElementById("msgAlerta").innerHTML = resposta['msg']



            } else {
                const editModel = new bootstrap.Modal(document.getElementById("editUsuarioModal"))
                editModel.show()
                document.getElementById('sistemasEdit').innerHTML = resposta['dados'].sistemas;
                document.getElementById('permissaoEdit').innerHTML = resposta['dados'].permissao;
           


            }

        }
        /* 
    async function openPopup(id_usuario) {
        console.log(id_usuario); // Verifica o valor do ID no console do navegador
        var popupWrapper = document.getElementById("popupWrapper");
        var popupContent = document.getElementById("popupContent");
        popupWrapper.style.display = "block";

        await fetch('../src/popup.php?id=' + id_usuario)
        console.log(await fetch('../src/popup.php?id=' + id_usuario))
    }
*/

        function closePopup() {
            var popupWrapper = document.getElementById("popupWrapper");
            popupWrapper.style.display = "none";
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
</body>

</html>
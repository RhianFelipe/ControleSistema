<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/main.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../public/style/telaFiltro.css?v=<?php echo time(); ?>">
    <title>Sistema de Controle de Permissões</title>
</head>

<body>
    <header>
        <h1>Controle de Sistemas</h1>
        <a href="../public/telaCadastro.php">Cadastrar Usuários</a>
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
            $sql = "SELECT nome, email FROM usuarios ORDER BY nome";
            $result = $mysqli->query($sql);

            if ($result->num_rows > 0) {
                // Exibe os dados na tabela
                while ($row = $result->fetch_assoc()) {
                    $nome = $row["nome"];
                    $email = $row["email"];
            ?>
                <tr>
                    <td><?php echo $nome; ?></td>
                    <td><?php echo $email; ?></td>
                    <td>
                        <button onclick="abrirPopup()">Permissões</button>
                        <button onclick="excluir()">Excluir</button>
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
    </section>




    <footer>
        Todos os direitos reservados
    </footer>



    <script>
    function abrirPopup() {
        // Lógica para abrir o popup
    }

    function excluir() {
        // Lógica para excluir o registro
    }
    </script>
</body>

</html>
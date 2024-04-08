<?php

include "../../db/conexao.php";

$pageTitle = "Lista de Admin";
include_once "../../view/src/verificarPermissao.php";

verificarPermissao();

// Consulta SQL para selecionar os atributos 'usuario' e 'permissao' da tabela 'admin'
$sql = "SELECT id, usuario, permissao FROM admin WHERE usuario <> '' AND permissao IS NOT NULL ORDER BY usuario ASC";



// Executar a consulta
$resultado = $mysqli->query($sql);

// Obter o número total de usuários
$totalUsuarios = $resultado->num_rows;


?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/style/telaGerenciarConta.css?v=<?php echo time(); ?>">
    <link rel="icon" href="../public/assets/img/icon-govpr.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0/dist/pretty-checkbox.min.css">

    <title>Criar Contas</title>

</head>


<body>
    <header>
        <h1>Criar Contas</h1>
    </header>

    <form id="accountForm" method="post">
        <label for="username">Nome de Usuário:</label>
        <input type="text" id="username" required>

        <label for="password">Senha:</label>
        <input type="password" id="password" required>

        <label for="permission">Permissão de Admin:</label>
        <select id="permission" required>
            <option value="1">Sim</option>
            <option value="0">Não</option>
        </select>
 <br>
        <button type="button" onclick="criarConta()">Criar Conta</button>
    </form>
    <section id="dados-conta-section">
        <h2>Dados de Conta Criada</h2>
        <table class="dados-conta" id="dados-conta-table">
            <thead>
                <tr>
                    <th>Nome de Usuário</th>
                    <th>Permissão de Admin</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Verificar se há resultados da consulta
                if ($resultado->num_rows > 0) {
                    // Loop para exibir os dados dos usuários
                    while ($row = $resultado->fetch_assoc()) {
                        echo "<tr id='linha-usuario-" . $row['id'] . "'>";
                        echo "<td id='mostrar-username'>" . $row['usuario'] . "</td>";
                        // Convertendo valor da permissão para "Sim" ou "Não"
                        $permissao = $row['permissao'] == 1 ? 'Sim' : 'Não';
                        echo "<td id='mostrar-permission'>" . $permissao . "</td>";
                        echo "<td>";
                        echo "<button class='button-edit' onclick='resetarSenha(" . $row['id'] . ")'>Resetar Senha</button>";
                        echo "<button class='button-excluir' onclick='excluirConta(" . $row['id'] . ", \"" . $row['usuario'] . "\")'>Excluir</button>";

                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    // Se nenhum registro for encontrado, exibir mensagem na tabela
                    echo "<tr>";
                    echo "<td colspan='3'>Nenhum registro encontrado.</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </section>


</body>



</html>
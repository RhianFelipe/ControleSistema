<?php

include "../../db/conexao.php";

$pageTitle = "Lista de Setor/Grupo";
include_once "../../view/src/verificarPermissao.php";

verificarPermissao();

// Consulta SQL para selecionar todos os setores da tabela
$buscaSetor = "SELECT * FROM setores ORDER BY nomeSetor ASC";
$queryBuscaSetor = $mysqli->query($buscaSetor) or die($mysqli->error);



// Obter o número total de usuários
$setores = $queryBuscaSetor->num_rows;


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

    <title>Gerenciar Setor e Grupo</title>

</head>

<style>
    #adicionar-buttons .col {
        display: inline-block;
    }
</style>

<body>
    <header>
        <h1>Gerenciar Setor e Grupo</h1>
    </header>


    <section id="adicionar-buttons">
        <div class="add-setor-grupo">
            <div class="row">
                <!-- 
                <div class="col">
                    <button type="button" class="btn btn-primary btn-sm">Adicionar Grupo</button>
                </div>
                -->

                <div class="col">
                    <button type="button" class="btn btn-primary btn-sm" onclick="criarNomeSetor()">Adicionar Setor</button>
                </div>

            </div>
        </div>
    </section>

    <!-- 

    <section id="dados-conta-section">
        <h2>Grupos</h2>
        <table class="dados-conta" id="dados-conta-table">
            <thead>
                <tr>
                    <th>Nome Grupo</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Verificar se há resultados da consulta
                if ($resultado->num_rows > 0) {
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

   -->
    <section id="dados-conta-section">
        <h2>Setores</h2>
        <table class="dados-conta" id="dados-conta-table">
            <thead>
                <tr>
                    <th>Nome Setor</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>

                <?php
                // Verificar se há resultados da consulta
                if ($queryBuscaSetor->num_rows > 0) {
                    // Loop para exibir os dados dos usuários
                    while ($row = $queryBuscaSetor->fetch_assoc()) {
                        echo "<tr id='linha-usuario-" . $row['id'] . "'>";
                        echo "<td id='mostrar-setor'>" . $row['nomeSetor'] . "</td>";
                        echo "<td>";
                        echo "<button class='button-edit' onclick='editarNomeSetor(" . $row['id'] . ", \"" . $row['nomeSetor'] . "\")'>Editar</button>";
                        echo "<button class='button-excluir' onclick='excluirNomeSetor(" . $row['id'] . ", \"" . $row['nomeSetor'] . "\")'>Excluir</button>";
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
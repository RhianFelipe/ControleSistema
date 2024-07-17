<?php

include "../../db/conexao.php";

$pageTitle = "Lista de Setor/Grupo";
include_once "../../view/src/verificarPermissao.php";

verificarPermissao();

// Consulta SQL para selecionar todos os setores da tabela
$buscaSetor = "SELECT * FROM setores ORDER BY nomeSetor ASC";
$queryBuscaSetor = $mysqli->query($buscaSetor) or die($mysqli->error);

// Obter o número total de setores
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

    <title>Gerenciar Setor</title>
</head>

<body>
    <header>
        <h1>Gerenciar Setor</h1>
    </header>

    <section id="adicionar-buttons">
        <div class="add-setor-grupo">
            <div class="row">
                <div class="col">
                    <button type="button" class="btn btn-success btn-sm" onclick="criarNomeSetor()">
                        Adicionar Setor</button>
                </div>
            </div>
        </div>
    </section>

    <section id="dados-conta-section">
        <h2>Setores</h2>
        <!-- Tabela para mostrar todos os setores criados, podendo excluir ou alterar o nome deles --> 
        <table class="dados-conta" id="dados-conta-table">
            <thead>
                <tr>
                    <th>Nome Setor</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($queryBuscaSetor->num_rows > 0) : ?>
                <?php while ($row = $queryBuscaSetor->fetch_assoc()) : ?>
                <tr id="linha-usuario-<?php echo $row['id']; ?>">
                    <td id="mostrar-setor"><?php echo $row['nomeSetor']; ?></td>
                    <td>
                        <button class="button-edit"
                            onclick="editarNomeSetor(<?php echo $row['id']; ?>, '<?php echo $row['nomeSetor']; ?>')">Editar</button>
                        <button class="button-excluir"
                            onclick="excluirNomeSetor(<?php echo $row['id']; ?>, '<?php echo $row['nomeSetor']; ?>')">Excluir</button>
                    </td>
                </tr>
                <?php endwhile; ?>
                <?php else : ?>
                <tr>
                    <td colspan="3">Nenhum registro encontrado.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>
</body>

</html>
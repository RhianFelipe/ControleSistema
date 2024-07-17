<?php

include "../../db/conexao.php";

$pageTitle = "Lista de Deletados";
include_once "../../view/src/verificarPermissao.php";

verificarPermissao();

// Consulta SQL para selecionar todos os usuários deletados por ordem Alfabética
$buscaDeletados = "SELECT * FROM desativados.usuarios ORDER BY data_delete DESC, nome ASC";
$queryBuscarDeletados = $mysqli->query($buscaDeletados) or die($mysqli->error);

// Obter o número total de usuários
$deletados = $queryBuscarDeletados->num_rows;


?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/style/telaDelete.css?v=<?php echo time(); ?>">
    <link rel="icon" href="../public/assets/img/icon-govpr.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0/dist/pretty-checkbox.min.css">

    <title>Gerenciar Usuários Deletados</title>
</head>

<body>
    <header>
        <h1>Usuários Deletados</h1>
    </header>



    <section id="dados-conta-section">

        <table class="dados-conta" id="dados-conta-table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Grupo</th>
                    <th>Setor</th>
                    <th>Data de Criação</th>
                    <th>Data de Exclusão</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
             
                <?php if ($queryBuscarDeletados->num_rows > 0) : ?>
                <?php while ($row = $queryBuscarDeletados->fetch_assoc()) : ?>
                <tr id="linha-usuario-<?php echo $row['id']; ?>">
                    <td id="mostrar-setor"><?php echo $row['nome']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td id="tdGrupo"><?php echo $row['grupo']; ?></td>
                    <td id="tdSetor"><?php echo $row['setor']; ?></td>
                    <td><?php echo date('d/m/Y H:i:s', strtotime($row['data_create'])); ?></td>
                    <td><?php echo date('d/m/Y H:i:s', strtotime($row['data_delete'])); ?></td>

                    <td>
                        <button class="btn btn-view" onclick="openModalDelete(<?php echo $row['id']; ?>)">
                            <i class="fas fa-eye"></i> Visualizar
                        </button>
                    </td>
                </tr>
                <?php endwhile; ?>
                <?php else : ?>
                <tr>
                    <td colspan="7">Nenhum registro encontrado.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>

    </section>



</body>



</html>
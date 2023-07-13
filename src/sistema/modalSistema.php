<?php
include "./../db/conexao.php";
include "./../db/consulta.php";

// Inclusão do script Swal.fire para exibir mensagens pop-up
echo "<script src='../js/sweetalert2.js'></script>";

// Verifica se o formulário foi submetido via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomeSistema = $_POST['nomeSistema'];

    // Verifica se o nome do sistema já existe no banco de dados
    $existeNomeSistema = verificarExistencia($mysqli, "nomeSistema", "admin", $nomeSistema);
    if ($existeNomeSistema->num_rows > 0) {
        // Exibe mensagem de erro caso o sistema já exista
        echo "<script>
            Swal.fire(
                'Erro!',
                'Esse sistema já existe.',
                'error'
            ).then(function() {
                window.location.href = '".$_SERVER['PHP_SELF']."';
            });
        </script>";
    } else {
        // Insere o novo sistema no banco de dados
        $inserirSistema = "INSERT INTO admin(nomeSistema) VALUES ('$nomeSistema')";
        $queryInserirSistema = $mysqli->query($inserirSistema) or die($mysqli->error);
        
        // Exibe mensagem de sucesso após a inserção do sistema
        echo "<script>
            Swal.fire(
                'Sucesso!',
                'Sistema inserido com sucesso.',
                'success'
            ).then(function() {
                window.location.href = '".$_SERVER['PHP_SELF']."';
            });
        </script>";
    }
}
?>

<script src="../js/sweetalert2.js"></script>
<link rel="stylesheet" href="../public/style/modalSistema.css?v=<?php echo time(); ?>">

<div class="modal fade" id="editSistema" tabindex="-1" aria-labelledby="editUsuarioModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUsuarioModalLabel">Editar Sistema</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" class="row g-3" id="edit-usuario-form">
                    <div class="col-12">
                        <label for="sistema">Adicionar Sistema:</label>
                        <input name="nomeSistema" type="text">
                        <button type="submit">
                            <img src="../public/assets/img/icon-plus.png" alt="Adicionar" class="btn-icon">
                        </button>
                    </div>
                    <?php
                    // Consulta os nomes de sistema existentes no banco de dados
                    $buscaNomeSistema = "SELECT DISTINCT nomeSistema FROM admin";
                    $queryBuscaNomeSistema = $mysqli->query($buscaNomeSistema) or die($mysqli->error);
                    
                    // Verifica se existem resultados da consulta
                    if (mysqli_num_rows($queryBuscaNomeSistema) > 0) {
                        echo "<table>";
                        echo "<tr>
                                    <th>Nome do Sistema</th>
                                    <th>Ações</th>
                                </tr>";

                        // Itera sobre os registros de sistemas
                        while ($row = mysqli_fetch_assoc($queryBuscaNomeSistema)) {
                            $nomeSistema = $row['nomeSistema'];

                            // Verifica se o valor não contém ":" e não está vazio
                            if (strpos($nomeSistema, ":") === false && !empty($nomeSistema)) {
                                echo "<tr>   
                                            <td>" . $nomeSistema . "</td>
                                            <td>
                                                <button class='button-excluir' onclick='excluirSistema(\"" . $nomeSistema . "\")'>Excluir</button>
                                            </td>
                                        </tr>";
                            }
                        }

                        echo "</table>";
                    } else {
                        echo "<p>Nenhum registro de sistema encontrado.</p>";
                    }
                    ?>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function excluirSistema(nomeSistema) {
        if (confirm("Deseja realmente excluir o sistema " + nomeSistema + "?")) {
            // Requisição AJAX para excluir o sistema
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {
                    alert("Sistema excluído com sucesso.");
                    location.reload();
                } else if (this.readyState === 4) {
                    alert("Ocorreu um erro ao excluir o sistema.");
                }
            };
            xhttp.open("GET", "../src/sistema/deleteSistema.php?nomeSistema=" + encodeURIComponent(nomeSistema), true);
            xhttp.send();
        }
    }
</script>

<!-- Incluí comentários para descrever a funcionalidade do código e das partes envolvidas. -->

<?php
include "./../db/conexao.php";
include "./../db/consulta.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomeSistema = $_POST['nomeSistema'];
    $existeNomeSistema = verificarExistencia($mysqli, "nomeSistema", "permissoes", $nomeSistema);
    if ($existeNomeSistema->num_rows > 0) {
        echo "<script>alert('Esse sistema já existe.');</script>";
    } else {
        $inserirSistema = "INSERT INTO permissoes(nomeSistema) VALUES ('$nomeSistema')";
        $queryInserirSistema = $mysqli->query($inserirSistema) or die($mysqli->error);
    }
}

?>

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
                        <label for="sistema">Sistema</label>
                        <input name="nomeSistema" type="text">
                        <input type="submit" class="btn btn-outline-warning btn-sm" id="edit-usuario-btn"
                            value="Salvar">
                    </div>

                    <?php
                    $buscaNomeSistema = "SELECT DISTINCT nomeSistema FROM permissoes";
                    $queryBuscaNomeSistema = $mysqli->query($buscaNomeSistema) or die($mysqli->error);
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
                                                <button class='btn btn-outline-danger btn-sm' onclick='excluirSistema(\"" . $nomeSistema . "\")'>Excluir</button>
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
            // Requisição AJAX
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

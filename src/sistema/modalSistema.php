<?php
include "./../db/conexao.php";
include "./../db/consulta.php";
echo "<script src='../js/sweetalert2.js'></script>";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  

   
    $nomeSistema = $_POST['nomeSistema'];
    $existeNomeSistema = verificarExistencia($mysqli, "nomeSistema", "admin", $nomeSistema);

    $sqlUser = "SELECT id FROM usuarios";
    $queryUserID = $result = mysqli_query($mysqli, $sqlUser);

    if ($existeNomeSistema->num_rows > 0) {
        echo "<script>
                Swal.fire({
                    title: 'Erro!',
                    text: 'Esse sistema já existe.',
                    icon: 'error'
                }).then(function() {
                    window.location.href = '".$_SERVER['PHP_SELF']."';
                });
              </script>";
    } else {
        if (isset($_POST['adicionarParaTodos']) && $_POST['adicionarParaTodos'] === '1') {
            $inserirSistema = "INSERT INTO admin(nomeSistema) VALUES ('$nomeSistema')";
            $queryInserirSistema = $mysqli->query($inserirSistema) or die($mysqli->error);
        
            while ($row = mysqli_fetch_assoc($queryUserID)) {
                $idUsuario = $row['id'];
                $inserirPermissao = "INSERT INTO permissoes(id_usuario, sistemas, permissao) VALUES ($idUsuario, '$nomeSistema', 0)";
                $queryInserirPermissao = $mysqli->query($inserirPermissao) or die($mysqli->error);
            }
            
        echo "<script src='../js/sweetalert2.js'></script>";
        echo "<script>
                Swal.fire({
                    title: 'Sucesso!',
                    text: 'Sistema inserido com sucesso para todos os users.',
                    icon: 'success'
                }).then(function() {
                    window.location.href = '".$_SERVER['PHP_SELF']."';
                });
              </script>";
    }
    
        else {
    
            $inserirSistema = "INSERT INTO admin(nomeSistema) VALUES ('$nomeSistema')";
            $queryInserirSistema = $mysqli->query($inserirSistema) or die($mysqli->error);
          echo "A checkbox não está marcada ou o valor não é 1. Fazendo outra coisa...";
       
          echo "<script src='../js/sweetalert2.js'></script>";
          echo "<script>
                  Swal.fire({
                      title: 'Sucesso!',
                      text: 'Sistema inserido com sucesso.',
                      icon: 'success'
                  }).then(function() {
                      window.location.href = '".$_SERVER['PHP_SELF']."';
                  });
                </script>";
      }
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
                        <input name="nomeSistema"id="nomeSistema" type="text">
                        <button type="submit" onclick="">
                            <img src="../public/assets/img/icon-plus.png" alt="Adicionar" class="btn-icon">
                        </button>
                    </div>
                    <div class="col-12">
                      
                      <label for="adicionarParaTodos">Inserir em todos os usuários:</label>
                      <input type="checkbox" name="adicionarParaTodos" id="adicionarParaTodos" value="1">
                  </div>
                    </form>
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
                            if (!empty($nomeSistema)) {
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
               
            </div>
        </div>
    </div>
</div>

<script src="../js/sweetalert2.js"></script>
<script>


    function excluirSistema(nomeSistema) {
        Swal.fire({
            title: 'Excluir Sistema',
            text: 'Deseja realmente excluir o sistema ' + nomeSistema + '?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Excluir',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Requisição AJAX para excluir o sistema
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState === 4 && this.status === 200) {
                        Swal.fire({
                            title: 'Sucesso!',
                            text: 'Sistema excluído com sucesso.',
                            icon: 'success'
                        }).then(() => {
                            location.reload();
                        });
                    } else if (this.readyState === 4) {
                        Swal.fire({
                            title: 'Erro!',
                            text: 'Ocorreu um erro ao excluir o sistema.',
                            icon: 'error'
                        });
                    }
                };
                xhttp.open("GET", "../src/sistema/deleteSistema.php?nomeSistema=" + encodeURIComponent(nomeSistema), true);
                xhttp.send();
            }
        });
    }
</script>


<!-- Incluí comentários para descrever a funcionalidade do código e das partes envolvidas. -->

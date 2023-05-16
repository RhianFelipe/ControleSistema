<link rel="stylesheet" href="../style/popup.css?v=<?php echo time(); ?>">
<!-- Abertura do elemento HTML que representa o pop-up -->
<div class="popup-wrapper" id="popupWrapper">
  <div class="popup">
    <!-- Botão para fechar o pop-up -->
    <span class="close" onclick="closePopup()">&times;</span>
    <?php
    include "../db/conexao.php";
    // Recebe o nome do usuário do formulário de cadastro
    $nome = $_POST['nome'];
    // ID do usuário a ter as permissões alteradas
    $id_usuario = 1;

    // Consulta os sistemas e as permissões disponíveis no banco de dados
    $buscaSistemas = "SELECT sistemas,permissao FROM permissoes";
    $queryBuscaSistemas =  $mysqli->query($buscaSistemas) or die($mysqli->error);

    // Cria um formulário com uma tabela que exibe os sistemas e as permissões em checkbox
    echo "<form method='post' action=''>";
    echo "<table>";
    echo "<tr><th>Sistema</th><th>Permissão</th></tr>";
    while ($row = mysqli_fetch_assoc($queryBuscaSistemas)) {
      echo "<tr>";
      echo "<td>" . $row['sistemas'] . "</td>";
      echo "<td><input type='checkbox' name='' value='1'> " . $row['permissao'] . "</td>";
      echo "</tr>";
    }
    echo "</table>";
    // Botão para submeter o formulário de permissões
    echo "<input type='submit' value='Salvar'>";
    echo "</form>";
    ?>
  </div>
</div>
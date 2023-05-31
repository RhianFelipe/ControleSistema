<link rel="stylesheet" href="../public/style/popup.css?v=<?php echo time(); ?>">

<!-- Abertura do elemento HTML que representa o pop-up -->
<div class="popup-wrapper" id="popupWrapper">
  <div class="popup">
    <!-- Botão para fechar o pop-up -->
    <span class="close" onclick="closePopup()">&times;</span>
    <?php
    // Obtém o ID do usuário selecionado
    $userId = $_POST['id_usuario'];

    // Conexão com o banco de dados (substitua as informações de conexão com as suas)
    include "../db/conexao.php";

    // Consulta SQL para obter os sistemas e permissões do usuário
    $sql = "SELECT sistemas, permissao FROM permissoes WHERE id_usuario = $userId";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
      // Cria um formulário com uma tabela que exibe os sistemas e as permissões em checkboxes
      echo "<form method='POST' action=''>";
      echo "<input type='hidden' name='userId' value='<?php echo $userId; ?>'>";
      echo "<table>";
      echo "<tr><th>Sistema</th><th>Permissão</th></tr>";

      while ($row = $result->fetch_assoc()) {
        $sistema = $row["sistemas"];
        $permissao = $row["permissao"];
        $isChecked = $permissao == 1 ? "checked" : "";

        echo "<tr>";
        echo "<td>$sistema</td>";
        echo "<td><input type='checkbox' name='permissao[$sistema]' value='1' $isChecked></td>";
        echo "</tr>";
      }

      echo "</table>";
      // Botão para submeter o formulário de permissões
      echo "<input type='submit' value='Salvar'>";
      echo "</form>";
    } else {
      echo "Nenhum sistema encontrado para o usuário.";
    }

    $mysqli->close();
    ?>
  </div>
</div>

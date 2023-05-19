  <link rel="stylesheet" href="../style/popup.css?v=<?php echo time(); ?>">
  <!-- Abertura do elemento HTML que representa o pop-up -->
  <div class="popup-wrapper" id="popupWrapper">
    <div class="popup">
      <!-- Botão para fechar o pop-up -->
      <span class="close" onclick="closePopup()">&times;</span>
      <?php
      include "../db/consulta.php";
      include "../db/conexao.php";
    


      // Cria um formulário com uma tabela que exibe os sistemas e as permissões em checkbox
      echo "<form method='POST' action=''>";
      echo "<table>";
      echo "<tr><th>Sistema</th><th>Permissão</th></tr>";
      while ($row = mysqli_fetch_assoc($queryBuscaSistemas)) {
        echo "<tr>";
        echo "<td>" . $row['sistemas'] . "</td>";
        echo "<td><input type='checkbox' name='permissao[$row[sistemas] ]' value='1'> " . $row['permissao'] . "</td>";
        echo "</tr>";
        
      }


      echo "</table>";
      // Botão para submeter o formulário de permissões
      echo "<input type='submit' value='Salvar'>";
      echo "</form>";
      ?>
    </div>
  </div>
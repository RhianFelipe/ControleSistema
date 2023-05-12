<link rel="stylesheet" href="../style/popup.css?v=<?php echo time(); ?>">
<div class="popup-wrapper" id="popupWrapper">
    <div class="popup">
        <span class="close" onclick="closePopup()">&times;</span> <!--&times === X -->
        <?php

          include "../db/conexao.php";
          if (true) {
             echo "<form method='post' action='salvar_permissao.php'>";
             echo "<table>";
             echo "<tr><th>Sistema</th>                  <th>Permissão</th></tr>";
       
             echo "</table>";
             echo "<input type='submit' value='Salvar'>";
             echo "</form>";
          }
        ?>

    </div>
</div>
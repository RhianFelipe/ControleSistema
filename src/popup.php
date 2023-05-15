<link rel="stylesheet" href="../style/popup.css?v=<?php echo time(); ?>">
<div class="popup-wrapper" id="popupWrapper">
    <div class="popup">
        <span class="close" onclick="closePopup()">&times;</span> <!--&times === X -->
        <?php
          include "../db/conexao.php";
           $nome = $_POST['nome'];
           var_dump($_POST);
          // ID do usuário a ter as permissões alteradas
          $id_usuario = 1;
    
          $buscaSistemas ="SELECT sistemas,permissao FROM permissoes";
         $queryBuscaSistemas =  $mysqli->query($buscaSistemas) or die($mysqli->error);

         if (true) {
          echo "<form method='post' action=''>";
          echo "<table>";
          echo "<tr><th>Sistema</th><th>Permissão</th></tr>";
          while ($row = mysqli_fetch_assoc($queryBuscaSistemas)) {
            echo "<tr>";
            echo "<td>".$row['sistemas']."</td>";
            echo "<td><input type='checkbox' name='' value='1'> ".$row['permissao']."</td>";
            echo "</tr>";
               
          }
          echo "</table>";
          echo "<input type='submit' value='Salvar'>";
          echo "</form>";
        }
       ?>

    </div>
</div>

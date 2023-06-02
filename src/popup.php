<link rel="stylesheet" href="../public/style/popup.css?v=<?php echo time(); ?>">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

<!-- Abertura do elemento HTML que representa o pop-up -->
<div class="popup-wrapper" id="popupWrapper">
  <div class="popup">
    <!-- Botão para fechar o pop-up -->
    <span class="close" onclick="closePopup()">&times;</span>
    <?php
    // Obtém o ID do usuário selecionado
    include "../db/conexao.php";
    $id_usuario = $_GET['id'];

    print $id_usuario;
    // Conexão com o banco de dados (substitua as informações de conexão com as suas)

    if (!empty($id_usuario)) {

      // Consulta SQL para obter os sistemas e permissões do usuário
      $sql = "SELECT sistemas, permissao FROM permissoes WHERE id_usuario = $id_usuario";
      $result = $mysqli->query($sql);

      if ($result->num_rows > 0) {
        // Cria um formulário com uma tabela que exibe os sistemas e as permissões em checkboxes
        echo "<form method='POST' action=''>";
        echo "<input type='hidden' name='userId' value='<?php echo $id_usuario; ?>'>";

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

          // Adicione um elemento div exclusivo para cada usuário com o ID do usuário como parte do ID do elemento
          echo "<div id='popupContent_$id_usuario' style='display: none;'>";
          echo "Informações do usuário $id_usuario";
          echo "</div>";
        }


        echo "</table>";
        // Botão para submeter o formulário de permissões
        echo "<input type='submit' value='Salvar'>";
        echo "</form>";
      } else {
        echo "Nenhum sistema encontrado para o usuário.";
        print $id_usuario;
      }

      $mysqli->close();
    }else{
      echo "ID não existe!";
    }

    ?>
  </div>
</div>
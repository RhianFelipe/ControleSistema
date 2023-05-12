



<link rel="stylesheet" href="../style/popup.css?v=<?php echo time(); ?>">
<div class="popup-wrapper" id="popupWrapper">
        <div class="popup">
            <span class="close" onclick="closePopup()">&times;</span>
            <?php
// Conexão com o banco de dados
include "../db/conexao.php";

// Consulta os sistemas e suas permissões no banco de dados


// Verifica se houve sucesso na consulta
if (true) {
    // Cria uma tabela com os sistemas e suas permissões
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

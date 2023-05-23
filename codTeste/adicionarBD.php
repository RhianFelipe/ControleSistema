<?php

include "conexao.php";

/*
  $sql = 'SELECT * FROM usuarios';
$result = mysqli_query($mysqli,$sql);

while($row = mysqli_fetch_assoc($result)){
echo $row["id"] ." - " .$row["nome"] . "<br>";


}



==================================
<?php

 include "conexao.php";



if(isset($_POST) > 0){
  $sql = 'SELECT * FROM usuarios';
$result = mysqli_query($mysqli,$sql);

while($row = mysqli_fetch_assoc($result)){
echo $row["id"] ." - " .$row["nome"] . "<br>";


}

}
$mysqli->close();

?>
==================================




*/
//$dsn = "mysql:host=$host;dbname=$database";
//$pdo = new PDO($dsn, $user, $password);


// Busca as permissões de um usuário específico
function verificarExistencia($mysqli, $table, $whereClause) {
  $sql = "SELECT COUNT(*) AS count FROM $table WHERE $whereClause";
  $result = $mysqli->query($sql);
  $count = $result->fetch_assoc()['count'];
  return ($count > 0);
}

// Listar todos os usuários e suas permissões
$sql = "SELECT * FROM usuarios,permissoes";
$result = $mysqli->query($sql);

echo "<h2>Usuários e suas permissões:</h2>";
echo "<table><tr><th>ID</th><th>Nome</th><th>Sistemas</th><th>Permissão</th></tr>";
while ($row = mysqli_fetch_assoc($result)) {
  echo "<tr><td>".$row['id_usuario']."</td><td>".$row['nome']."</td><td>".$row['sistemas']."</td><td>".$row['permissao']."</td></tr>";
}
echo "</table>";

// Adicionar um novo usuário e suas permissões
if(count($_POST)>0){ 
  
  $nome = $_POST['nome'];
  $sistema = $_POST['sistemas'];
  $permissao = $_POST['permissao'];

  
 
$usuarioExiste = "SELECT nome FROM usuarios WHERE nome='$nome'";
$resultUsuarioExiste = $mysqli->query($usuarioExiste) or die($mysqli->error);


$sistemaExiste = "SELECT sistemas FROM permissoes WHERE sistemas='$sistema'";
$resultSistemaExiste = $mysqli->query($sistemaExiste) or die($mysqli->error);


if ($resultUsuarioExiste->num_rows >0) {
  echo "Nome já existe no banco de dados!";
  if($resultSistemaExiste->num_rows >  0){

    echo "Sistema já existe no banco de dados!";
    $sql = "UPDATE permissoes INNER JOIN usuarios ON permissoes.id_usuario = usuarios.id SET permissao='$permissao' WHERE nome='$nome' AND sistemas='$sistema'";
    $deu = $mysqli->query($sql);
   
    if ($deu) {
      echo "<p>Permissão atualizada com sucesso.</p>";
      echo 'teste';
      echo $id_usuario;
      var_dump($_POST);
    } else {
      echo "<p>Ocorreu um erro ao atualizar a permissão.</p>";
    }

  echo "Não existe o sistema";
} else {
  
  echo "nao aq";

   
}
}

}


mysqli_close($mysqli); // Fecho a conexão
?>



<script>

   // criar o popup


 // criar a tabela

function openPopup(){

var popup = window.open("", "Permissões", "width=400,height=400");
var table = document.createElement("table");

// adicionar cabeçalho da tabela
var thead = document.createElement("thead");
var headerRow = document.createElement("tr");
var systemHeader = document.createElement("th");
systemHeader.innerText = "Sistema";
var permissionHeader = document.createElement("th");
permissionHeader.innerText = "Permissão";
headerRow.appendChild(systemHeader);
headerRow.appendChild(permissionHeader);
thead.appendChild(headerRow);
table.appendChild(thead);

// adicionar linhas da tabela
var tbody = document.createElement("tbody");
var row = document.createElement("tr");
var systemName = document.createElement("td");
systemName.innerText = "eProtocolo";
var permissionCell = document.createElement("td");
var permissionCheckbox = document.createElement("input");
permissionCheckbox.type = "checkbox";
permissionCell.appendChild(permissionCheckbox);
row.appendChild(systemName);
row.appendChild(permissionCell);
tbody.appendChild(row);
table.appendChild(tbody);

// adicionar botão salvar
var saveButton = document.createElement("button");
saveButton.innerText = "Salvar";
saveButton.onclick = function() {
    // implementar lógica para salvar permissões aqui
    alert("Permissões salvas!");
};
popup.document.body.appendChild(table);
popup.document.body.appendChild(saveButton);


}




</script>




<?php
// Incluir arquivo de conexão com o banco de dados e arquivo de pop-up
include "../db/conexao.php";
include "../db/consulta.php";
include "../src/popup.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém os valores do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $grupo = $_POST['grupo'];
    $sistemas = $_POST['sistemas'];
    var_dump($_POST);
    echo $sistemas;
  
    // Insere o novo usuário na tabela Usuarios
    $query = "INSERT INTO usuarios (nome, email, grupo, data_create) VALUES ('$nome', '$email', '$grupo', NOW())";
    mysqli_query($mysqli, $query);
  
    // Obtém o ID do novo usuário
    $idUsuario = mysqli_insert_id($mysqli);
  
    // Remove as permissões antigas do usuário
    $query = "DELETE FROM Permissoes WHERE id_usuario = $idUsuario";
    mysqli_query($mysqli, $query);
  
    // Insere as permissões selecionadas para o usuário
    foreach ($sistemas as $sistema => $permissao) {
      // Insere apenas se a permissão for 1 (concedida)
      if ($permissao == 1) {
        $query = "INSERT INTO Permissoes (id_usuario, sistemas, permissao) VALUES ($idUsuario, '$sistema', $permissao)";
        mysqli_query($mysqli, $query);
      }
    }
  
    // Fecha a conexão com o banco de dados
    mysqli_close($mysqli);
  
    // Exibe uma mensagem de sucesso
    echo "Usuário criado/alterado com sucesso!";
  }

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Importar folhas de estilo -->
    <link rel="stylesheet" href="../style.css?v=<?php echo time(); ?>"> <!-- Voltar uma pasta e pegar o style.css -->
    <link rel="stylesheet" href="../style/telaCadastro.css?v=<?php echo time(); ?>">
    <title>Cadastrar Usuário</title>
</head>

<body>
    <!-- Criação do Header para logo e navegação-->
    <header>
        <img src="../assets/img/logo-govpr.png" alt="">
        <a href="../index.php">Voltar para Filtro</a>
    </header>

    <!-- Criação formulário para cadastro de Usuário-->
    <div id="area-form">
        <form id="form" method="POST" action="">
            <h1>Cadastrar Usuário</h1><br>
            <label>Nome:</label>
            <input class="input-value" id="nome" placeholder="nome" name="nome" type="text" required><br>
            <label>E-mail:</label>
            <input class="input-value" placeholder="usuario@pge.pr.gov.br" name="email" type="text" required><br>
            <label>Grupo:</label>
            <!-- Obter valores dos grupos do banco de dados e mostrá-los em um menu suspenso -->
            <select class="input-value" name="grupo">
                <?php
                while ($colunaGrupo = mysqli_fetch_array($queryBuscaGrupo)) { ?>
                    <option value="<?= $colunaGrupo['grupo'] ?>"><?php echo $colunaGrupo['grupo']; ?></option> <?php }
                                                                                                                ?>
            </select> <br>
            <label>Gerenciar Permissões:</label>
            <!-- Criação da tabela de permissões -->
            <table id="tabela-permissoes">
            <h3>Permissões:</h3>
    <p>Marque as permissões para cada sistema:</p>
    <input type="checkbox" name="sistemas[SistemaA]" value="1"> SistemaA<br>
    <input type="checkbox" name="sistemas[SistemaB]" value="0"> SistemaB<br>


                <?php /*
                include "../db/consulta.php";
                while ($row = mysqli_fetch_assoc($queryBuscaSistemas)) {
                    echo "<tr>";
                    echo "<td>" . $row['sistemas'] . "</td>";
                    echo "<td><input type='checkbox' name='permissao[" . $row['sistemas'] . "]' value='1'> " . $row['permissao'] . "</td>";
                    echo "</tr>";
                }
                */
                ?>

            </table>
            <!-- Botão para abrir o pop-up de gerenciamento de Permissões-->
            <button onclick="openPopup()" id="button-permissao" type="button">Permissões</button> <br>
            <button id="button-submit" type="submit">Cadastrar</button>

        </form>

    </div>

    <footer></footer>
    <script src="../script/popup.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


</body>

</html>

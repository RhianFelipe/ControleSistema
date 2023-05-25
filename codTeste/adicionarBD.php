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






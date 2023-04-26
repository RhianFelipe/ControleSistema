<?php

include "conexao.php";

/*
  $sql = 'SELECT * FROM usuarios';
$result = mysqli_query($mysqli,$sql);

while($row = mysqli_fetch_assoc($result)){
echo $row["id"] ." - " .$row["nome"] . "<br>";


}
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

  $id_usuario = $mysqli->insert_id;
  echo "ID:" . $id_usuario;
 
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

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
<a href="/">Voltar para Lista</a>
<form method="POST" action="">


  <label >Nome:</label>
  <input name="nome" type="text"><br>
  <label >Sistema:</label>
  <input name="sistemas" type="text"><br>
  <label >permissao:</label>
  <select name="permissao">
  <option selected value="0">0</option>
  <option value="1">1</option>
  </select>
  <button type="submit">Enviar</button>

<?php




?>

</form>
</body>
</html>
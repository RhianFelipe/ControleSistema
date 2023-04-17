<?php
/*
* Change the value of $password if you have set a password on the root userid
* Change NULL to port number to use DBMS other than the default using port 3306
*
*/

 include "conexao.php";



if(isset($_POST) > 0){
  $sql = 'SELECT Nome FROM funcionario';
$result = mysqli_query($mysqli,$sql);

while($row = mysqli_fetch_assoc($result)){
echo $row["Nome"];


}

}

$mysqli->close();

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
<?php ?>
</body>
</html>

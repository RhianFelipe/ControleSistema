<?php
$host = 'localhost';
$user = 'root';
$password = ''; //To be completed if you have set a password to root
$database = 'controlesistema'; //To be completed to connect to a database. The database must exist.
$port = NULL; //Default must be NULL to use default port
$mysqli = new mysqli('127.0.0.1', $user, $password, $database, $port);
//Verificar se ocorreu algum erro ao conectar com o Banco de Dados
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
}

?>

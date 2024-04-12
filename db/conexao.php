<?php
$host = 'localhost';
$user = 'root';
$password = ''; //To be completed if you have set a password to root
$database = 'controlesistema'; //To be completed to connect to a database. The database must exist.
$database1 = 'desativados'; //To be completed to connect to a database. The database must exist.
$port = NULL; //Default must be NULL to use default port

$mysqli = new mysqli('127.0.0.1', $user, $password, $database, $port);
//Verificar se ocorreu algum erro ao conectar com o Banco de Dados
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
}

// Conexão com a segunda base de dados
$mysqli1 = new mysqli($host, $user, $password, $database1, $port);

// Verificar se ocorreu algum erro ao conectar com a segunda base de dados
if ($mysqli1->connect_error) {
    die('Connect Error (' . $mysqli1->connect_errno . ') '
            . $mysqli1->connect_error);
}
<?php 
 include "../db/conexao.php";

// Consulta os sistemas e as permissões disponíveis no banco de dados
$buscaSistemas = "SELECT sistemas FROM permissoes";
$queryBuscaSistemas =  $mysqli->query($buscaSistemas) or die($mysqli->error);


// Consulta os grupos de cada funcionario(procuradores, estags, servidores...)
$buscaGrupo = "SELECT grupo FROM usuarios"; 
$queryBuscaGrupo = $mysqli->query($buscaGrupo) or die($mysqli->error);







/*
Criação de um novo usuario e suas permissões, insere sistemas também

INSERT INTO usuarios (nome, email, grupo, data_create)
VALUES ('NomeDoUsuario', 'email@example.com', 'grupo', NOW());
SET @idUsuario = LAST_INSERT_ID();
INSERT INTO permissoes (id_usuario, sistemas, permissao, data_altere)
VALUES (@idUsuario, 'SistemaA', 0, NOW());

INSERT INTO permissoes (id_usuario, sistemas, permissao, data_altere)
VALUES (@idUsuario, 'SistemaB', 0, NOW());
------------------------
Criação de um novo usuario e suas permissões

-- Insira o novo usuário na tabela `usuarios`
INSERT INTO usuarios (nome, email, grupo, data_create)
VALUES ('NovoUsuario', 'email.novo@example.com', 'grupo', NOW());

-- Recupere o ID do novo usuário
SET @idNovoUsuario = LAST_INSERT_ID();

-- Insira os registros de permissões vinculados aos sistemas A e B para o novo usuário
INSERT INTO permissoes (id_usuario, sistemas, permissao, data_altere)
VALUES (@idNovoUsuario, 'SistemaA', 0, NULL),
       (@idNovoUsuario, 'SistemaB', 0, NULL);
---------------------------
Pesquisa a permissão de cada usuario
SELECT *
FROM usuarios
JOIN permissoes ON usuarios.id = permissoes.id_usuario;


*/




 ?>




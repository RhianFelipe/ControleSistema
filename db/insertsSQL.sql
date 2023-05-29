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


==========================================
INSERT INTO usuarios(grupo) VALUES ('Estagiário');
INSERT INTO usuarios(grupo) VALUES ('Servidor');
INSERT INTO usuarios(grupo) VALUES ('Tercerizado');
INSERT INTO usuarios(grupo) VALUES ('Procurador');
INSERT INTO usuarios(grupo) VALUES ('Advogado');

*/

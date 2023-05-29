<?php
include "../db/conexao.php";

// Verifica se foi feita uma solicitação POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $id_usuario = $mysqli->real_escape_string($_POST["id_usuario"]);

  // Percorre os dados recebidos do formulário e salva as permissões no banco de dados
  foreach ($_POST["permissao"] as $sistema => $valor) {
    $valorPermissao = ($valor == '1') ? 1 : 0; // Converte o valor da checkbox em 1 ou 0

    // Verifica se a permissão já existe no banco de dados para o usuário e sistema em questão
    $selectPermissao = "SELECT id FROM permissoes WHERE id_usuario = $id_usuario AND sistemas = '$sistema'";
    $resultPermissao = $mysqli->query($selectPermissao);
    
    if ($resultPermissao->num_rows > 0) {
      // Atualiza a permissão existente
      $updatePermissao = "UPDATE permissoes SET permissao = $valorPermissao, data_altere = NOW() WHERE id_usuario = $id_usuario AND sistemas = '$sistema'";
      $mysqli->query($updatePermissao);
    } else {
      // Insere uma nova permissão
      $insertPermissao = "INSERT INTO permissoes (id_usuario, sistemas, permissao, data_altere) VALUES ($id_usuario, '$sistema', $valorPermissao, NOW())";
      $mysqli->query($insertPermissao);
    }
  }

  echo "Permissões salvas com sucesso!";
}

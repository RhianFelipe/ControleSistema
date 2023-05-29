<?php
// Incluir arquivo de conexão com o banco de dados e arquivo de pop-up
include "../db/conexao.php";
include "../db/consulta.php";

function verificarExistencia($mysqli, $valor, $tabela, $variavel)
{
    $verificar = "SELECT $valor FROM $tabela WHERE $valor='$variavel'";
    $resultVerificacao = $mysqli->query($verificar) or die($mysqli->error);
    return $resultVerificacao;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém os valores do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $grupo = $_POST['grupo'];
    $sistemas = array(
        "admIntranet" => "ADM/INTRANET",
        "admInternet" => "ADM/INTERNET",
        "arisp" => "ARISP",
        "copel" => "Copel",
        "detran" => "Detran",
        "documentador" => "Documentador",
        "sipro" => "Sipro",
        "eProtocolo" => "eProtocolo"
    );
    
    $existeNome = verificarExistencia($mysqli, "nome", "usuarios", $nome);
    $existeEmail = verificarExistencia($mysqli, "email", "usuarios", $email);

    if ($existeNome->num_rows > 0) {
        echo "Esse nome já existe";
    } else {
        if ($existeEmail->num_rows > 0) {
        } else {
            $query = "INSERT INTO usuarios (nome, email, grupo, data_create) VALUES ('$nome', '$email', '$grupo', NOW())";
            mysqli_query($mysqli, $query);
            // Obtém o ID do novo usuário
            $idUsuario = mysqli_insert_id($mysqli);

            // Inserir as permissões para cada sistema
            foreach ($sistemas as $nomeSistema => $valorPermissao) {
                // Verifica se o sistema está presente nos dados enviados pelo formulário
                if (isset($_POST['sistemas'][$nomeSistema])) {
                    $valorSelecionado = $_POST['sistemas'][$nomeSistema];
        
                    // Insere o valor selecionado no banco de dados
                    $queryPermissao = "INSERT INTO permissoes (id_usuario, sistemas, permissao) VALUES ('$idUsuario', '$nomeSistema', '$valorSelecionado')";
                    mysqli_query($mysqli, $queryPermissao);
                }
            
        }
    }
    }
    // Fecha a conexão com o banco de dados
    mysqli_close($mysqli);

    // Exibe uma mensagem de sucesso
    echo "Usuário criado/alterado com sucesso!";
    header("Location: ../public/telaCadastro.php");
exit();
}

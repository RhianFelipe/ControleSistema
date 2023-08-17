<?php
include "./db/conexao.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém os valores do formulário
    $usuarioC = $_POST['usuarioC'];
    $senhaC = $_POST['senhaC'];

    // Verifica se o usuário já existe
    $consultaUsuario = "SELECT id FROM admin WHERE usuario = '$usuarioC'";
    $resultadoConsulta = $mysqli->query($consultaUsuario);

    if ($resultadoConsulta->num_rows > 0) {
        // O usuário já existe, exibe um alerta de erro usando SweetAlert e redireciona para a página de login
        echo "<script>
                Swal.fire({
                    title: 'Erro!',
                    text: 'Usuário já existe. Por favor, escolha outro nome de usuário.',
                    icon: 'error'
                }).then(function() {
                    window.location.href = './index.php';
                });
              </script>";
    } else {
        // Realiza a inserção dos dados no banco de dados
        $inserirUsuario = "INSERT INTO admin (usuario, senha) VALUES ('$usuarioC', '$senhaC')";
        if ($mysqli->query($inserirUsuario)) {
            // Inserção bem-sucedida, exibe um alerta de sucesso usando SweetAlert e redireciona para a página de login
            echo "<script>
                    Swal.fire({
                        title: 'Sucesso!',
                        text: 'Usuário cadastrado com sucesso!',
                        icon: 'success'
                    }).then(function() {
                        window.location.href = './index.php';
                    });
                  </script>";
        } else {
            // Erro na inserção, exibe um alerta de erro usando SweetAlert e redireciona para a página de login
            echo "<script>
                    Swal.fire({
                        title: 'Erro!',
                        text: 'Ocorreu um erro ao cadastrar o usuário.',
                        icon: 'error'
                    }).then(function() {
                        window.location.href = './index.php';
                    });
                  </script>";
        }
    }

    // Fecha a conexão com o banco de dados (não necessário aqui devido ao redirecionamento)
    $mysqli->close();
}
?>

<div class="modal fade" id="criarContaModal" tabindex="-1" aria-labelledby="criarContaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="criarContaModalLabel">Criar Conta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" class="row g-3" id="criar-conta-form">
                    <div class="col-12">
                        <label for="usuario">Usuário:</label>
                        <input type="text" id="usuarioC" name="usuarioC" class="form-control" required>
                    </div>
                    <div class="col-12">
                        <label for="senha">Senha:</label>
                        <input type="password" id="senhaC" name="senhaC" class="form-control" required>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary" id="criar-conta-btn">Salvar</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
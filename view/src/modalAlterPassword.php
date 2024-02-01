<link rel="stylesheet" href="../../public/style/modalEdit.css?v=<?php echo time(); ?>">
<div class="modal fade" id="alterPasswordModal" tabindex="-1" aria-labelledby="alterPasswordModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="alterPasswordModalLabel">Alterar Senha</h5>
        <h5 style="margin-left: 0.5rem;" class="modal-title" id="nomeTitleModalUser"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="alterPasswordForm">
          <div class="mb-3">
            <label for="newPassword" class="form-label">Nova Senha</label>
            <input type="password" class="form-control" id="newPassword" name="newPassword" required>
          </div>
          <button type="submit" class="btn btn-primary">Alterar Senha</button>
        </form>
      </div>

    </div>
  </div>
</div>

<script>
  document.getElementById('alterPasswordForm').addEventListener('submit', function(event) {
    event.preventDefault();

    // Obtenha o valor da nova senha
    const newPassword = document.getElementById('newPassword').value;

    // Adicione o ID da sessão como parâmetro de consulta
    const url = '../src/alterarSenha.php?newPassword=' + encodeURIComponent(newPassword) + '&userID=' + encodeURIComponent(<?php echo $_SESSION['user']; ?>);

    // Usando SweetAlert para confirmar a alteração de senha
    Swal.fire({
      title: 'Confirmação',
      text: 'Tem certeza de que deseja alterar a senha?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Sim',
      cancelButtonText: 'Não',
    }).then((result) => {
      if (result.isConfirmed) {
        // Use a função fetch para enviar os dados
        fetch(url, {
            method: 'GET',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded',
            },
          })
          .then(response => response.json())
          .then(data => {
            // Exibir SweetAlert informando sobre o sucesso ou falha da alteração da senha
            Swal.fire({
              title: data.status ? 'Sucesso' : 'Erro',
              text: data.msg,
              icon: data.status ? 'success' : 'error',
            });

            // Se a alteração da senha foi bem-sucedida, feche a modal
            if (data.status) {
              const alterSenhaModal = bootstrap.Modal.getInstance(
                document.getElementById("alterPasswordModal")
              );
              alterSenhaModal.hide();
            }
          })
          .catch(error => {
            console.error('Erro ao enviar a solicitação:', error);
          });
      }
    });
  });
</script>
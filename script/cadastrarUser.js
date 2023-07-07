function abrirModalPermissoes() {
    const editSistema = new bootstrap.Modal(document.getElementById('editUsuarioModal'));
    editSistema.show();
  }
  
  // Evento de clique no botão "Permissões"
  document.getElementById('button-permissao').addEventListener('click', abrirModalPermissoes);
  
  // Enviar os dados do formulário para o arquivo PHP
  document.getElementById('form').addEventListener('submit', async function(event) {
    event.preventDefault(); // Impedir o envio padrão do formulário
  
    const formData = new FormData(this);
  
    // Enviar os dados selecionados na modal para o FormData
    const modalForm = document.getElementById('modalForm');
    const selectsModal = modalForm.getElementsByTagName('select');
    for (let i = 0; i < selectsModal.length; i++) {
      const select = selectsModal[i];
      const nomeSistema = select.id;
      const valor = select.value;
      formData.append(`sistemas[${nomeSistema}]`, valor);
    }
  
    try {
      // Enviar os dados do formulário para o arquivo PHP usando Fetch API
      const response = await fetch(this.action, {
        method: this.method,
        body: formData
      });
  
      const data = await response.json();
  
      if (data.status) {
        exibirMensagem(data.msg, 'success');
      } else {
        exibirMensagem(data.msg, 'error');
      }
    } catch (error) {
      console.error(error);
    }
  });
  
  // Evento de clique no botão "Salvar"
  document.getElementById('salvarModal').addEventListener('click', function() {
    exibirMensagem('Os dados foram salvos.', 'success');
  });
  
  // Função para exibir mensagem usando o Swal.fire
  function exibirMensagem(text, icon) {
    return Swal.fire({
      text: text,
      icon: icon,
      showCancelButton: false,
      confirmButtonColor: '#3085d6',
      confirmButtonText: 'Fechar'
    });
  }
  
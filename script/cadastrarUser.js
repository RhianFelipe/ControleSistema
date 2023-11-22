let valoresOriginais = {};

// Função para abrir a modal
function abrirModalPermissoes() {
  const editSistema = new bootstrap.Modal(
    document.getElementById("sistemaCadModal")
  );

  const selectsModal = document.getElementById("modalForm").getElementsByTagName("select");
  for (let i = 0; i < selectsModal.length; i++) {
    const select = selectsModal[i];
    valoresOriginais[select.id] = select.value;
  }

  editSistema.show();
}

// Evento de clique no botão "Permissões"
document.getElementById("button-permissao").addEventListener("click", abrirModalPermissoes);

// Função para salvar os valores dos selects
function salvarValoresSelects() {
  const selectsModal = document.getElementById("modalForm").getElementsByTagName("select");
  for (let i = 0; i < selectsModal.length; i++) {
    const select = selectsModal[i];
    valoresOriginais[select.id] = select.value;
  }
}

// Evento de fechamento da modal
document.getElementById("sistemaCadModal").addEventListener("hidden.bs.modal", function () {
  const selectsModal = document.getElementById("modalForm").getElementsByTagName("select");
  for (let i = 0; i < selectsModal.length; i++) {
    const select = selectsModal[i];
    select.value = valoresOriginais[select.id];
  }
});

document.getElementById("form").addEventListener("submit", async function (event) {
  event.preventDefault();

  // Antes de enviar, exibe um SweetAlert para confirmar o cadastro
  Swal.fire({
    title: 'Tem certeza?',
    text: 'Deseja cadastrar os dados?',
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Sim, cadastrar!',
    cancelButtonText: 'Cancelar'
  }).then(async (result) => {
    if (result.isConfirmed) {
      // Se o usuário confirmar, prossegue com o envio do formulário
      const formData = new FormData(this);

      const modalForm = document.getElementById("modalForm");
      const selectsModal = modalForm.getElementsByTagName("select");
      for (let i = 0; i < selectsModal.length; i++) {
        const select = selectsModal[i];
        const nomeSistema = select.id;
        const valor = select.value;
        formData.append(`sistemas[${nomeSistema}]`, valor);
      }

      try {
        const response = await fetch(this.action, {
          method: this.method,
          body: formData,
        });

        const data = await response.json();

        if (data.status) {
          exibirMensagem("success", "Sucesso", data.msg);
          salvarValoresSelects(); // Salvar os valores dos selects após o sucesso
          const editSistemaModal = new bootstrap.Modal(document.getElementById("sistemaCadModal"));
          editSistemaModal.hide(); // Fechar a modal após salvar os dados
        } else {
          exibirMensagem("error", "Erro", data.msg);
        }
      } catch (error) {
        console.error(error);
      }
    }
  });
});

// Evento de clique no botão "Salvar"
document.getElementById("salvarModal").addEventListener("click", function () {
  exibirMensagem("success", "Sucesso", "Os dados foram salvos.");
  salvarValoresSelects(); // Salvar os valores dos selects ao clicar em "Salvar"
});

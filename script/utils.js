
function limparFiltragem() {
    const urlSemParametros = window.location.pathname;
    history.replaceState(null, null, urlSemParametros);
}

async function openModalSistema(){
    const editSistema = new bootstrap.Modal(
        document.getElementById("editSistema")
      );
      editSistema.show();   
}

function exibirMensagem(text, icon) {
    return Swal.fire({
      text: text,
      icon: icon,
      showCancelButton: false,
      confirmButtonColor: '#3085d6',
      confirmButtonText: 'Fechar'
    });
  }
  
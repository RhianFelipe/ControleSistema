
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


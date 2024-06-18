function limparFiltragem() {
  const urlSemParametros = window.location.pathname;
  history.replaceState(null, null, urlSemParametros);
}

function openEditName() {
  const editName= new bootstrap.Modal(
    document.getElementById("editName")
  );
  editName.show();
}

function exibirMensagem(icon, title, text) {
  return Swal.fire({
    icon: icon,
    title: title,
    text: text,
  });
}



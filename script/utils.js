function limparFiltragem() {
  const urlSemParametros = window.location.pathname;
  history.replaceState(null, null, urlSemParametros);
}

function openModalSistema() {
  const editSistema = new bootstrap.Modal(
    document.getElementById("editSistema")
  );
  editSistema.show();
}
// Função para editar o SID
function openSidModalTur() {
  const editSid = new bootstrap.Modal(document.getElementById("editSidTermoTur"));
  editSid.show();
}

function openSidModalTcc() {
  const editSid = new bootstrap.Modal(document.getElementById("editSidTermoTcc"));
  editSid.show();
}

function openSidModalWifi() {
  const editSid = new bootstrap.Modal(document.getElementById("editSidWi-Fi"));
  editSid.show();
}
function openSidModalVPN() {
  const editSid = new bootstrap.Modal(document.getElementById("editSidVPN"));
  editSid.show();
}
function exibirMensagem(icon, title, text) {
  return Swal.fire({
    icon: icon,
    title: title,
    text: text,
  });
}

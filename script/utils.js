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
function openSidModal() {
  const editSid = new bootstrap.Modal(document.getElementById("editSidTermos"));
  editSid.show();
}

function openSidModalWifi() {
  const editSid = new bootstrap.Modal(document.getElementById("editSidWifi"));
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

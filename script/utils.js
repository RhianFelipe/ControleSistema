function gerenciarPermissoes() {
    var selectsPermissoes = document.getElementById('selects-permissoes');
    var buttonPermissao = document.getElementById('button-permissao');
    var footer = document.querySelector('footer');
  
    if (selectsPermissoes.style.display === 'none') {
      selectsPermissoes.style.display = 'block';
      buttonPermissao.textContent = 'Ocultar Permissões';
      footer.style.marginTop = '50rem'; // Adicione uma margem superior maior ao footer
    } else {
      selectsPermissoes.style.display = 'none';
      buttonPermissao.textContent = 'Permissões';
      footer.style.marginTop = ''; // Remova a margem superior
    }
  }
  

function limparFiltragem() {
    const urlSemParametros = window.location.pathname;
    history.replaceState(null, null, urlSemParametros);
}

async function  openPopupSistema(){

    const editSistema = new bootstrap.Modal(
        document.getElementById("editSistema")
      );
      editSistema.show();

      
}
function gerenciarPermissoes() {
    var selectsPermissoes = document.getElementById('selects-permissoes');
    var buttonPermissao = document.getElementById('button-permissao');
    if (selectsPermissoes.style.display === 'none') {
        selectsPermissoes.style.display = 'block';
        buttonPermissao.textContent = 'Ocultar Permissões';
    } else {
        selectsPermissoes.style.display = 'none';
        buttonPermissao.textContent = 'Permissões';
    }
}

function limparFiltragem() {
    const urlSemParametros = window.location.pathname;
    history.replaceState(null, null, urlSemParametros);
}
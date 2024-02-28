
function resetarSenha(id) {
    const novaSenha = prompt("Digite a nova senha:");
    if (novaSenha !== null && novaSenha !== "") {

        fetch('../src/resetarSenhaConta.php?id=' + id + '&novaSenha=' + encodeURIComponent(novaSenha), {
                method: 'GET'
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    exibirMensagem('success', 'Sucesso!', data.msg);
                } else {
                    exibirMensagem('error', 'Erro!', data.msg);
                }
            })
            .catch(error => {
                console.error('Erro ao redefinir a senha:', error);
                exibirMensagem('error', 'Erro de rede!', 'Ocorreu um erro ao conectar-se ao servidor.');
            });

    }

}

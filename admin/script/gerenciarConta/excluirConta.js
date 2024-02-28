function excluirConta(id, usuario) {
    Swal.fire({
        title: 'Tem certeza?',
        text: "Você realmente deseja excluir a conta de '" + usuario + "'?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim, excluir!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('../src/excluirConta.php?id=' + id + '&usuario=' + encodeURIComponent(usuario), {
                    method: 'GET'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status) {
                        const linhaUsuario = document.getElementById("linha-usuario-" + id);
                        exibirMensagem('success', 'Sucesso!', data.msg).then(() => {

                            linhaUsuario.remove();
                            l
                        });;
                    } else {
                        exibirMensagem('error', 'Erro!', data.msg);
                    }
                })
                .catch(error => {
                    console.error('Erro ao excluir a conta:', error);
                    exibirMensagem('error', 'Erro de rede!', 'Ocorreu um erro ao conectar-se ao servidor.');
                });
        }
    });
}
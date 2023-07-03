async function apagarUsuarioDados(id) {
    console.log("Entrou:", id);
    const confirmar = await Swal.fire({
        title: 'Tem certeza?',
        text: 'Tem certeza que deseja excluir o registro selecionado?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim',
        cancelButtonText: 'Não'
    });

    if (confirmar.isConfirmed) {
        const dados = await fetch('../src/deleteUser.php?id=' + id);
        const resposta = await dados.json();
        console.log(resposta);

        const linhaUsuario = document.getElementById('linha-usuario-' + id);

        if (!resposta.status) {
            Swal.fire({
                title: 'Erro',
                text: 'ERRO: Usuário não deletado!',
                icon: 'error'
            });
        } else {
            Swal.fire({
                title: 'Sucesso',
                text: 'Usuário deletado com sucesso!',
                icon: 'success'
            }).then(() => {
                linhaUsuario.remove();
                location.reload(); // Recarrega a página
            });
        }
    }
}

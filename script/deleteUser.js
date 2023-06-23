async function apagarUsuarioDados(id) {
    console.log("Entrou:", id);
    var confirmar = confirm("Tem certeza que deseja excluir o registro selecionado?");
    if (confirmar == true) {

        const dados = await fetch('../src/deleteUser.php?id=' + id);
        const resposta = await dados.json();
        console.log(resposta);

        const linhaUsuario = document.getElementById('linha-usuario-' + id);

        if (!resposta.status) {
            alert("ERRO: Usuário não deletado!");
        } else {

            alert("Usuario deletado com sucesso!");
            linhaUsuario.remove();
            location.reload(); // Recarrega a página
        }

    }

}
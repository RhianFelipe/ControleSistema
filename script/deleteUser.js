async function apagarUsuarioDados(id, nome) {
  console.log("Entrou:", id);

  // Exibe um diálogo de confirmação usando o Swal.fire
  const confirmar = await Swal.fire({
    title: "Tem certeza?",
    text: `Tem certeza que deseja excluir o usuário '${nome}'?`,
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sim",
    cancelButtonText: "Não",
  });
  if (confirmar.isConfirmed) {
    fetch("../src/deleteUser.php?id=" + id)
      .then((response) => response.json())
      .then((resposta) => {
        console.log(resposta);
        const linhaUsuario = document.getElementById("linha-usuario-" + id);

        if (!resposta.status) {
          // Exibe uma mensagem de erro usando o SweetAlert com a descrição do erro do MySQL
          exibirMensagem("error", "Erro", resposta.msg);
        } else {
          // Exibe uma mensagem de sucesso usando o SweetAlert e executa uma ação após o fechamento do diálogo
          exibirMensagem("success", "Sucesso", resposta.msg).then(() => {
            linhaUsuario.remove();
            location.reload(); // Recarrega a página
          });
        }
      })
      .catch((error) => {
        // Exibe uma mensagem de erro usando o SweetAlert para erros de parsing JSON
        exibirMensagem("error", "Erro", "Erro na resposta do servidor");
        console.error(error);
      });
  }
}

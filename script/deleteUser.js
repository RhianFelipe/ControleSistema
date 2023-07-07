async function apagarUsuarioDados(id) {
    console.log("Entrou:", id);
    
    // Exibe um diálogo de confirmação usando o Swal.fire
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
      try {
        // Envia uma requisição para deletar o usuário usando o método fetch
        const dados = await fetch('../src/deleteUser.php?id=' + id);
        const resposta = await dados.json();
        console.log(resposta);
  
        const linhaUsuario = document.getElementById('linha-usuario-' + id);
  
        if (!resposta.status) {
          // Exibe uma mensagem de erro usando o Swal.fire
          exibirMensagem('ERRO: Usuário não deletado!', 'error');
        } else {
          // Exibe uma mensagem de sucesso usando o Swal.fire e executa uma ação após o fechamento do diálogo
          exibirMensagem('Usuário deletado com sucesso!', 'success').then(() => {
            linhaUsuario.remove();
            location.reload(); // Recarrega a página
          });
        }
      } catch (error) {
        console.error(error);
      }
    }
  }
  
  // Função para exibir mensagem usando o Swal.fire
  function exibirMensagem(text, icon) {
    return Swal.fire({
      text: text,
      icon: icon,
      showCancelButton: false,
      confirmButtonColor: '#3085d6',
      confirmButtonText: 'Fechar'
    });
  }
  
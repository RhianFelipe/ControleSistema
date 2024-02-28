function criarNomeSetor(){

    const novoSetor = prompt(`Digite o nome do setor:`);
   if (novoSetor !== null && novoSetor !== "") {

      fetch('../src/gerenciarSetorGrupo/criarSetor.php?novoSetor=' + encodeURIComponent(novoSetor), {
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
               console.error('Erro ao redefinir o nome do:', error);
               exibirMensagem('error', 'Erro de rede!', 'Ocorreu um erro ao conectar-se ao servidor.');
           });

   }

}

function editarNomeSetor(id, nomeSetor){

    const novoSetor = prompt(` ${nomeSetor}
     Digite o novo nome do setor:`);
    if (novoSetor !== null && novoSetor !== "") {

        fetch('../src/gerenciarSetorGrupo/editarSetor.php?id=' + id + '&novoSetor=' + encodeURIComponent(novoSetor), {
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
                console.error('Erro ao redefinir o nome do:', error);
                exibirMensagem('error', 'Erro de rede!', 'Ocorreu um erro ao conectar-se ao servidor.');
            });

    }

}

function excluirNomeSetor(id, nomeSetor){
    console.log("entrou")
    Swal.fire({
        title: 'Tem certeza?',
        text: `Você realmente deseja excluir o setor "${nomeSetor}"?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim, excluir!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('../src/gerenciarSetorGrupo/excluirSetor.php?id='  + id , {
                    method: 'GET'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status) {
                        const linhaUsuario = document.getElementById("linha-usuario-" + id);
                        exibirMensagem('success', 'Sucesso!', data.msg).then(() => {

                            linhaUsuario.remove();
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






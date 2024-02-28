function criarConta() {
    // Obtém os valores dos campos
    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;
    var permission = document.getElementById('permission').value;

    // Cria um objeto FormData para enviar os dados
    var formData = new FormData();
    formData.append('username', username);
    formData.append('password', password);
    formData.append('permission', permission);

    // Mostra um diálogo de confirmação com o SweetAlert
    Swal.fire({
        title: 'Você tem certeza?',
        text: 'Você deseja criar uma nova conta com os dados fornecidos?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sim',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        // Se o usuário confirmar
        if (result.isConfirmed) {
            // Usa o Fetch API para enviar os dados para o arquivo PHP
            fetch('../src/criarConta.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    // Lida com a resposta do servidor
                    if (data.success) {
                        // Se a operação foi bem-sucedida, exibe um alerta de sucesso com o SweetAlert
                        Swal.fire({
                            icon: 'success',
                            title: 'Sucesso!',
                            text: data.mensagem
                        });
                    } else {
                        // Se houve um erro, exibe um alerta de erro com o SweetAlert
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro!',
                            text: data.mensagem
                        });
                    }
                })
                .catch(error => {
                    // Se ocorreu um erro durante a requisição, exibe um alerta de erro com o SweetAlert
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro!',
                        text: error.message
                    });
                });
        }
    });
}

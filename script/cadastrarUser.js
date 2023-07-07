
       
       function abrirModalPermissoes() {
        const editSistema = new bootstrap.Modal(document.getElementById('editUsuarioModal'));
        editSistema.show();
      }
       
       // Evento de clique no botão "Permissões"
        document.getElementById('button-permissao').addEventListener('click', abrirModalPermissoes);

        // Enviar os dados do formulário para o arquivo PHP
        document.getElementById('form').addEventListener('submit', function(event) {
            event.preventDefault(); // Impedir o envio padrão do formulário

            const formData = new FormData(this);

            // Enviar os dados selecionados na modal para o FormData
            const modalForm = document.getElementById('modalForm');
            const selectsModal = modalForm.getElementsByTagName('select');
            for (let i = 0; i < selectsModal.length; i++) {
                const select = selectsModal[i];
                const nomeSistema = select.id;
                const valor = select.value;
                formData.append(`sistemas[${nomeSistema}]`, valor);
            }

            // Enviar os dados do formulário para o arquivo PHP usando Fetch API
            fetch(this.action, {
                    method: this.method,
                    body: formData
                })
                .then(function(response) {
                    return response.json();
                })
                .then(function(data) {
                    if (data.status) {
                        Swal.fire({
                            text: data.msg,
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Fechar'
                        });
                    } else {
                        Swal.fire({
                            text: data.msg,
                            icon: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Fechar'
                        });
                    }
                })
                .catch(function(error) {
                    console.error(error);
                });
        });

        // Evento de clique no botão "Salvar"
        document.getElementById('salvarModal').addEventListener('click', function() {
            Swal.fire({
                text: 'Os dados foram salvos.',
                icon: 'success',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Fechar'
            });
        });
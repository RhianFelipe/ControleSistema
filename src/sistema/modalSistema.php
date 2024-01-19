<link rel="stylesheet" href="../public/style/modalSistema.css?v=<?php echo time(); ?>">
<div class="modal fade" id="editSistema" tabindex="-1" aria-labelledby="editUsuarioModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUsuarioModalLabel">Editar Sistema</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="GET" class="row g-3" id="edit-usuario-form">
                    <div class="col-12" data-bs-toggle="tooltip" data-bs-placement="top" title="Marque a caixa de seleção para aplicar a ação a todos os usuários: exclusão ou adição.">
                        <label for="adicionarParaTodos">Aplicar em todos os usuários:</label>
                        <input type="checkbox" name="adicionarParaTodos" id="adicionarParaTodos" value="1">
                    </div>
                    <div class="col-12">
                        <label for="sistema">Adicionar Sistema:</label>
                        <input name="nomeSistema" id="nomeSistema" type="text" required>
                        <button type="button" onclick="enviarDados()">
                            <img src="../public/assets/img/icon-plus.png" alt="Adicionar" class="btn-icon">
                        </button>
                    </div>
                </form>

                <table id="tabelaSistemas">
                    <!-- Esta tabela será preenchida dinamicamente -->
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    async function enviarDados() {
        const nomeSistema = document.getElementById('nomeSistema').value;
        const adicionarParaTodos = document.getElementById('adicionarParaTodos').checked ? '1' : '0';

        if (nomeSistema.trim() === '') {
            Swal.fire({
                title: 'Erro!',
                text: 'Por favor, insira um nome de sistema válido.',
                icon: 'error'
            });
            return; // Não prossegue se o nome do sistema estiver vazio
        }

        const confirmacao = await Swal.fire({
            title: 'Confirmar adição',
            text: `Deseja realmente adicionar o sistema ${nomeSistema}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sim',
            cancelButtonText: 'Cancelar'
        });

        if (confirmacao.isConfirmed) {
            try {
                const url = `../src/sistema/updateSistema.php?nomeSistema=${encodeURIComponent(nomeSistema)}&adicionarParaTodos=${adicionarParaTodos}`;

                const response = await fetch(url, {
                    method: 'GET'
                });

                if (!response.ok) {
                    throw new Error('Erro ao enviar os dados');
                }

                const data = await response.json();

                // Exibir o SweetAlert com base na resposta do servidor
                if (data.status === true) {
                    Swal.fire({
                        title: 'Sucesso!',
                        text: data.msg,
                        icon: 'success'
                    });
                    // Fechar o modal após o sucesso
                    const editSistemaModal = bootstrap.Modal.getInstance(
                        document.getElementById('editSistema')
                    );
                    editSistemaModal.hide();
                    openModalSistema();
                    // Faça o que for necessário com os dados recebidos
                } else {
                    Swal.fire({
                        title: 'Erro!',
                        text: data.msg,
                        icon: 'error'
                    });
                }
            } catch (error) {
                console.error('Houve um erro:', error);
                // Exibir um alerta caso ocorra um erro
                Swal.fire({
                    title: 'Erro!',
                    text: 'Erro ao enviar os dados.',
                    icon: 'error'
                });
            }
        }
    }



    async function excluirSistema(nomeSistema) {
        const adicionarParaTodos = document.getElementById('adicionarParaTodos').checked ? '1' : '0';

        const confirmacao = await Swal.fire({
            title: 'Tem certeza?',
            text: 'Você realmente deseja excluir este sistema?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sim',
            cancelButtonText: 'Cancelar'
        });

        if (confirmacao.isConfirmed) {
            try {
                const url = `../src/sistema/deleteSistema.php?nomeSistema=${encodeURIComponent(nomeSistema)}&adicionarParaTodos=${adicionarParaTodos}`;

                const response = await fetch(url, {
                    method: 'DELETE'
                });

                if (!response.ok) {
                    throw new Error('Erro ao excluir o sistema');
                }

                const data = await response.json();

                // Manipular a resposta JSON aqui
                if (data.status === true) {
                    Swal.fire({
                        title: 'Sucesso!',
                        text: data.message,
                        icon: 'success'
                    });
                    // Fechar o modal após o sucesso
                    const editSistemaModal = bootstrap.Modal.getInstance(
                        document.getElementById('editSistema')
                    );
                    editSistemaModal.hide();
                    openModalSistema();
                } else {
                    Swal.fire({
                        title: 'Erro!',
                        text: data.message,
                        icon: 'error'
                    });
                }
            } catch (error) {
                console.error('Houve um erro:', error);
                Swal.fire({
                    title: 'Erro!',
                    text: 'Erro ao excluir o sistema',
                    icon: 'error'
                });
            }
        }
    }
</script>

<script src="../js/sweetalert2.js"></script>
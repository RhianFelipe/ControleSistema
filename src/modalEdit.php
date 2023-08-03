<link rel="stylesheet" href="../public/style/modalEdit.css?v=<?php echo time(); ?>">
<div class="modal fade" id="editUsuarioModal" tabindex="-1" aria-labelledby="editUsuarioModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUsuarioModalLabel">Editar Usuário</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" id="edit-usuario-form">
                    <input type="hidden" name="id" id="editid">

                    <div class="col-12">
                        <label for="edit-grupo" class="form-label">Grupo</label>
                        <span class="tooltip-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Selecione um valor caso queira mudar o grupo do usuário">
                            <select id="input-value" name="grupo" class="form-select">
                                <option value="">Selecione o grupo</option>
                                <?php
                                $gruposPermitidos = array("Procurador", "Servidor", "Terceirizado", "Estagiário", "Advogado");
                                foreach ($gruposPermitidos as $grupoPermitido) {
                                    echo "<option value='$grupoPermitido'>$grupoPermitido</option>";
                                }
                                ?>
                            </select>
                        </span>
                    </div>
                    <!-- Nova tabela para os termos -->
                    <div class="col-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Termo</th>
                                    <th>Assinado</th>
                                </tr>
                            </thead>
                            <tbody id="termosEdit">
                                <!-- Os termos serão adicionados dinamicamente aqui -->
                            </tbody>
                        </table>
                    </div>

                    <div class="col-12">
                        <label for="inputSistemaPersonalizado" class="form-label">Sistema Personalizado</label>
                        <input type="text" class="form-control" id="inputSistemaPersonalizado">
                        <button type="button" class="btn btn-primary mt-2" onclick="adicionarSistemaPersonalizado()">Adicionar</button>
                    </div>


                    <div class="col-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Sistemas</th>
                                    <th>Permissão</th>

                                </tr>
                            </thead>
                            <tbody id="sistemasPermissoesEdit">
                                <tr>
                                    <td class="sistema-list" id="sistemasEdit"></td>
                                    <td class="permissao-list" id="permissaoEdit"></td>
                                    <td id="sistemaDelete"></td>

                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-12">
                        <input type="submit" class="" id="edit-usuario-btn" value="Salvar">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
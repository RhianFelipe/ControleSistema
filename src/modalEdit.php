<link rel="stylesheet" href="../public/style/modalEdit.css?v=<?php echo time(); ?>">
<div class="modal fade" id="editUsuarioModal" tabindex="-1" aria-labelledby="editUsuarioModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editUsuarioModalLabel">Editar Usuário -</h5>
        <h5 style="margin-left: 0.5rem;" class="modal-title" id="nomeTitleModalUser"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="row g-3" id="edit-usuario-form">
          <input type="hidden" name="id" id="editid">

          <div class="col-12">

            <span class="tooltip-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Selecione um valor caso queira mudar o grupo do usuário">
              <select id="input-value" name="grupo" class="form-select">
                <option value="">Selecione o grupo</option>
                <?php
                $gruposPermitidos = array("Procurador", "Servidor", "Servidor(Comissão)", "Terceirizado", "Estagiário", "Advogado", "Externo");
                foreach ($gruposPermitidos as $grupoPermitido) {
                  echo "<option value='$grupoPermitido'>$grupoPermitido</option>";
                }
                ?>
              </select>
            </span>
          </div>

          <div class="col-12">

            <span class="tooltip-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Selecione um valor caso queira mudar o setor do usuário">
              <select id="input-setor" name="setor" class="form-select">
                <option value="">Selecione o setor</option>
                <?php
                include_once "../db/consulta.php";
                foreach ($setores as $setor) {
                  echo "<option value='$setor'>$setor</option>";
                }
                ?>
              </select>
            </span>
          </div>
          <!-- Nova tabela para os termos -->
          <div class="col-12">
            <table class="table">

              <tbody id="termosEdit">
                <!-- Os termos serão adicionados dinamicamente aqui -->
              </tbody>
            </table>
          </div>
          <!-- Inclua a referência ao SweetAlert -->

          <div id="divSidTUR" style="display: inline-block; margin: 0; margin-left: 10px;">
            <p id="sidText" style="display: inline-block; margin: 0; margin-left: 10px;">SID TUR:
              <a href="" style="display: inline-block; margin: 0;" title="Clique para copiar SID e ser redirecionado ao site do eProtocolo" id="sidValueTermoTur" target="_blank" onclick="copyAndRedirect('sidValueTermoTur', 'https://www.eprotocolo.pr.gov.br/spiweb/consultarProtocoloDigital.do?action=pesquisar'); return false;">Clique aqui</a>
            </p>
            <button id="editarSidButton" onclick="openSidModalTur()" type="button"><img src="../public/assets/img/pen.svg" alt=""></button>
          </div>

          <div id="divSidTCC" style="display: inline-block; margin: 0; margin-left: 10px;">
            <p id="sidText" style="display: inline-block; margin: 0; margin-left: 10px;">SID TCC:
              <a href="" style="display: inline-block; margin: 0;" title="Clique para copiar SID e ser redirecionado ao site do eProtocolo" id="sidValueTermoTcc" target="_blank" onclick="copyAndRedirect('sidValueTermoTcc', 'https://www.eprotocolo.pr.gov.br/spiweb/consultarProtocoloDigital.do?action=pesquisar'); return false;">Clique aqui</a>
            </p>
            <button id="editarSidButton" onclick="openSidModalTcc()" type="button"><img src="../public/assets/img/pen.svg" alt=""></button>
          </div>
          <div id="divSidWiFi" style="display: inline-block; margin: 0; margin-left: 10px;">
            <p id="sidText" style="display: inline-block; margin: 0; margin-left: 10px; text-decoration: none;">
              SID Wi-Fi:
              <a id="sidValueWi-Fi" target="_blank" style="text-decoration: none; color: inherit; cursor: inherit;">Texto do link</a>
            </p>
            <button id="editarSidButton" onclick="openSidModalWifi()" type="button"><img src="../public/assets/img/pen.svg" alt=""></button>
          </div>

          <div id="divSidVPN" style="display: inline-block; margin: 0; margin-left: 10px;">
            <p id="sidText" style="display: inline-block; margin: 0; margin-left: 10px;">SID VPN:
              <a href="" title="Clique para copiar SID e ser redirecionado ao site do eProtocolo" id="sidValueVPN" target="_blank" onclick="copyAndRedirect('sidValueVPN', 'https://www.eprotocolo.pr.gov.br/spiweb/consultarProtocoloDigital.do?action=pesquisar'); return false;"></a>
            </p>
            <button id="editarSidButton" onclick="openSidModalVPN()" type="button"><img src="../public/assets/img/pen.svg" alt=""></button>
          </div>

          <script>
            function copyAndRedirect(elementId, redirectUrl) {
              var dynamicContent = document.getElementById(elementId).textContent;
              if (dynamicContent) {
                // Copie o conteúdo para a área de transferência
                navigator.clipboard.writeText(dynamicContent).then(function() {
                  Swal.fire({
                    icon: 'success',
                    title: 'Copiado com sucesso!',
                    text: 'O conteúdo foi copiado para a área de transferência.',
                  }).then(function() {
                    // Redirecione para o site desejado
                    window.open(redirectUrl, '_blank');
                  });
                }).catch(function(err) {
                  Swal.fire({
                    icon: 'error',
                    title: 'Erro ao copiar',
                    text: 'Ocorreu um erro ao copiar o conteúdo para a área de transferência.',
                  });
                });
              }
            }
          </script>

          <!-- 

                    <div class="col-12">
                        <div class="input-group input-sistema">
                            <input type="text" class="form-control" id="inputSistemaPersonalizado" placeholder="Adicionar sistema personalizado">
                            <button type="button" class="btn btn-primary" onclick="adicionarSistemaPersonalizado()">
                                +
                            </button>
                        </div>
                    </div>

                    -->

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
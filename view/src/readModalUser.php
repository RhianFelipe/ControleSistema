<link rel="stylesheet" href="../../public/style/modalEdit.css?v=<?php echo time(); ?>">
<div class="modal fade" id="viewUsuarioModal" tabindex="-1" aria-labelledby="viewUsuarioModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewUsuarioModalLabel">Usuário -</h5>
        <h5 style="margin-left: 0.5rem;" class="modal-title" id="nomeTitleModalUser"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <input type="hidden" name="id" id="editid">


        <style>
          .col-12 {
            margin-bottom: 10px;
          }

          .label {
            font-weight: bold;
            margin-right: 5px;
          }

          .value {
            color: #555;
            /* Cor mais escura para os valores */
          }
        </style>

        <div class="col-12">
          <span class="label">Grupo:</span>
          <span class="value" id="input-value">Procuradora</span>
        </div>

        <div class="col-12">
          <span class="label">Setor:</span>
          <span class="value" id="input-setor">T.I</span>
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
        <!-- Este é o contêiner onde as divs serão adicionadas dinamicamente -->

        <div id="divContainer"></div>
        <style>
          #divContainer {
            display: flex;
            flex-direction: column;
            /* Empilhar elementos verticalmente */
            align-items: flex-start;
            /* Alinhar à esquerda */
          }
        </style>

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
        <style>
          .table {
            width: 100%;
            border-collapse: collapse;
            /* Mescla as bordas das células para evitar espaços entre elas */
          }

          .table td,
          .table th {
            border-bottom: 1px solid #ddd;
            /* Ajuste a largura da borda conforme necessário */

            text-align: left;
            /* Alinha o texto à esquerda nas células */
          }
        </style>



      </div>
    </div>
  </div>
</div>
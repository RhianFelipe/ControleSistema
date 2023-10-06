<div class="modal fade" id="editSidWi-Fi" tabindex="-1" aria-labelledby="editUsuarioModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #f8f9fa; display: flex; align-items: center;">
        <input required name="sid" id="sidInputWi-Fi" placeholder="SID" class="form-control" type="text"  style="flex: 1; margin-right: 10px;" maxlength="12" oninput="formatarSid(this)">

        <button type="button" class="btn btn-primary" onclick="atualizarSid('Wi-Fi')">Salvar</button>

        <!--<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
      </div>
    </div>
  </div>
</div>

<style>
  #sidInput::placeholder {
    opacity: 0.6;
    /* Ajuste a opacidade conforme necessário */
  }

  /* Estilize o texto do SID */
  #sidText {
    font-weight: bold;
    font-size: 16px;
  }

  /* Estilize o valor do SID */
  #sidValue {
    color: #007bff;
    /* Cor azul para destaque */
  }

  /* Estilize o botão de edição do SID */
  #editarSidButton {

    border: none;
    color: white;

    cursor: pointer;
    transition: background-color 0.3s ease;
  }
</style>
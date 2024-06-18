<!-- Modal compacta -->
<div class="modal fade" id="editSidModal" tabindex="-1" aria-labelledby="editSidModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #f8f9fa;">
                <h5 class="modal-title" id="editSidModalLabel">Editar SID</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex align-items-center">
                <input required name="sid" id="sidInput" placeholder="" class="form-control me-2" type="text" maxlength="12" oninput="formatarSid(this)">
                <button type="button" class="btn btn-primary">Salvar</button>
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

<script>
//idModal, idInput, placeholder, eventoOnClick
function criarModalSid(idModal, idInput, placeholder, eventoOnClick) {
    // Clonar o modelo da modal genérica
    var modalTemplate = document.getElementById('editSidModal').cloneNode(true);

    // Atribuir um novo ID para a modal clonada
    modalTemplate.id = idModal;

    // Selecionar o input dentro da modal clonada pelo ID passado como parâmetro
    var input = modalTemplate.querySelector('#sidInput');

    // Atualizar o ID e o placeholder do input
    input.id = idInput;
    input.placeholder = placeholder;

    // Atualizar o evento onclick do botão 'Salvar'
    var buttonSalvar = modalTemplate.querySelector('.btn-primary');
    buttonSalvar.addEventListener('click', function() {
        eval(eventoOnClick); // Executa o evento passado como string
    });

    // Adicionar a modal clonada ao body do documento
    document.body.appendChild(modalTemplate);


}






</script>
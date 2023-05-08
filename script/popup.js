//Usado para criar o pop-up, é preciso criar um botão para fechar


/*<script>
function openPopup() {
  // Criar elemento de popup
  var popup = document.createElement("div");
  popup.classList.add("popup");

  // Adicionar coluna Nome do Sistema
  var nomeSistema = document.createElement("div");
  nomeSistema.innerHTML = "Nome do Sistema";
  popup.appendChild(nomeSistema);

  // Adicionar coluna Permissão
  var permissao = document.createElement("div");
  permissao.innerHTML = "Permissão";
  popup.appendChild(permissao);

  // Adicionar botão Salvar
  var salvarBtn = document.createElement("button");
  salvarBtn.innerHTML = "Salvar";
  popup.appendChild(salvarBtn);

  // Adicionar popup à página
  document.body.appendChild(popup);
}

salvarBtn.addEventListener("click", function() {
  // Lógica de salvamento de permissões aqui
  // ...
  
  // Fechar o popup após salvar
  popup.remove();
});

 </script>


<style>
.popup {
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background-color: #fff;
  padding: 20px;
  border: 1px solid #ccc;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
  z-index: 9999;
}

.popup div {
  display: inline-block;
  width: 200px;
  text-align: center;
}

.popup button {
  display: block;
  margin-top: 20px;
  padding: 10px;
  background-color: #4CAF50;
  color: #fff;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}


</style>


        <button onclick="openPopup()">Editar Permissões</button> */
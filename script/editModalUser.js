// Função para exibir mensagem usando o Swal.fire
function exibirMensagem(text, icon) {
  return Swal.fire({
    text: text,
    icon: icon,
    showCancelButton: false,
    confirmButtonColor: '#3085d6',
    confirmButtonText: 'Fechar'
  });
}

// Função para abrir o modal de edição de usuário
async function openModalEdit(id) {
  console.log(id);

  try {
    // Requisição assíncrona para obter dados do usuário com base no ID
    const dados = await fetch("../src/viewUser.php?id=" + id);
    const resposta = await dados.json();

    console.log(resposta);

    if (!resposta["status"]) {
      // Se a resposta não tiver um status válido, exibe uma mensagem de alerta
      document.getElementById("msgAlerta").innerHTML = resposta["msg"];
    } else {
      // Mostrar o modal de edição
      const editModel = new bootstrap.Modal(document.getElementById("editUsuarioModal"));
      editModel.show();

      const idUsuario = resposta["dados"][0].id_usuario;
      document.getElementById("editid").value = idUsuario;
      console.log("ID:", idUsuario);

      const sistemasEdit = document.getElementById("sistemasEdit");
      sistemasEdit.innerHTML = "";

      const sistemasData = resposta["dados"];
      const sistemas = [];
      const permissoes = [];

      // Iterar sobre os dados dos sistemas e permissões
      sistemasData.forEach((sistemaData) => {
        const sistema = sistemaData.sistemas;
        const permissao = sistemaData.permissao;

        sistemas.push(sistema);
        permissoes.push(permissao);

        const li = document.createElement("li");
        li.textContent = sistema;
        sistemasEdit.appendChild(li);
      });

      const permissaoEdit = document.getElementById("permissaoEdit");
      permissaoEdit.innerHTML = "";

      // Cria checkboxes com as permissões
      permissoes.forEach((permissao) => {
        const checkbox = document.createElement("input");
        checkbox.type = "checkbox";
        checkbox.checked = permissao === "1";

        const td = document.createElement("td");
        td.style.padding = "4.3";

        const label = document.createElement("label");
        label.style.margin = "0";
        label.appendChild(checkbox);

        td.appendChild(label);

        const tr = document.createElement("tr");
        tr.appendChild(td);

        permissaoEdit.appendChild(tr);
      });

      const inputsSistema = editForm.querySelectorAll('[name="sistema[]"]');
      inputsSistema.forEach((inputSistema) => {
        inputSistema.remove();
      });

      const inputsPermissao = editForm.querySelectorAll('[name="permissao[]"]');
      inputsPermissao.forEach((inputPermissao) => {
        inputPermissao.remove();
      });

      // Cria inputs ocultos atualizados
      sistemas.forEach((sistema) => {
        const inputSistema = document.createElement("input");
        inputSistema.type = "hidden";
        inputSistema.name = "sistema[]";
        inputSistema.value = sistema;
        editForm.appendChild(inputSistema);
      });

      permissoes.forEach((permissao) => {
        const inputPermissao = document.createElement("input");
        inputPermissao.type = "hidden";
        inputPermissao.name = "permissao[]";
        inputPermissao.value = permissao;
        editForm.appendChild(inputPermissao);
      });
    }
  } catch (error) {
    console.error(error);
    // Se ocorrer um erro ao obter os dados do usuário, exibe uma mensagem de erro
    exibirMensagem('Erro ao obter dados do usuário.', 'error');
  }
}

// Função para enviar o formulário de edição
async function submitForm(event) {
  event.preventDefault();
  console.log("Entrou aqui");

  const idUsuario = document.getElementById("editid").value;
  const sistemas = [];
  const permissoes = [];

  const checkboxes = editForm.querySelectorAll('input[type="checkbox"]');
  checkboxes.forEach((checkbox) => {
    const permissao = checkbox.checked ? "1" : "0";
    permissoes.push(permissao);
  });

  const sistemasElements = editForm.querySelectorAll('[name="sistema[]"]');
  sistemasElements.forEach((sistemaElement) => {
    const sistema = sistemaElement.value;
    sistemas.push(sistema);
  });

  const dadosForm = new FormData();
  dadosForm.append("id", idUsuario);
  
  // Obtém o valor selecionado do campo de seleção
  const selectGrupo = document.getElementById("input-value");
  const grupoSelecionado = selectGrupo.value;
  console.log("Grupo enviado:", grupoSelecionado);
  dadosForm.append("grupo", grupoSelecionado);

  sistemas.forEach((sistema) => {
    dadosForm.append("sistema[]", sistema);
  });
  permissoes.forEach((permissao) => {
    dadosForm.append("permissao[]", permissao);
  });

  console.log("ID:", idUsuario);
  console.log("Sistemas:", sistemas);
  console.log("Permissões:", permissoes);

  try {
    // Envio assíncrono dos dados do formulário para o servidor
    const dados = await fetch("../src/updateUser.php", {
      method: "POST",
      body: dadosForm,
    });

    const resposta = await dados.json();
    if (resposta.status) {
      exibirMensagem('As alterações foram salvas corretamente!', 'success');
    } else {
      exibirMensagem('ERRO: As alterações não foram salvas!', 'error');
    }
  } catch (error) {
    console.error(error);
    // Se ocorrer um erro durante o envio do formulário, exibe uma mensagem de erro
    exibirMensagem('Erro ao processar a requisição.', 'error');
  }
}

// Obtém o formulário de edição
const editForm = document.getElementById("edit-usuario-form");

if (editForm) {
  // Adiciona um ouvinte de evento para o envio do formulário
  editForm.addEventListener("submit", submitForm);
}

async function openPopup(id) {
  console.log(id); // Exibe o ID recebido

  // Faz uma requisição assíncrona para obter dados do usuário com base no ID
  const dados = await fetch("../src/viewUser.php?id=" + id);
  const resposta = await dados.json(); // Converte a resposta para JSON

  console.log(resposta); // Exibe a resposta recebida

  // Verifica se a resposta não contém um status válido
  if (!resposta["status"]) {
    document.getElementById("msgAlerta").innerHTML = resposta["msg"]; // Exibe uma mensagem de alerta
  } else {
    const editModel = new bootstrap.Modal(
      document.getElementById("editUsuarioModal")
    );
    editModel.show(); // Mostra um modal de edição de usuário

    const idUsuario = resposta["dados"][0].id_usuario;
    document.getElementById("editid").value = idUsuario;
    console.log("ID:", idUsuario); // Exibe o ID do usuário

    const sistemasEdit = document.getElementById("sistemasEdit");
    sistemasEdit.innerHTML = ""; // Limpa o conteúdo existente

    console.log("Dados:", resposta["dados"]);
    const sistemasData = resposta["dados"];

    console.log("Sistemas Mapeados: ", sistemasData);

    const sistemas = [];
    const permissoes = [];

    // Itera sobre os dados de sistemas e permissões
    sistemasData.forEach((sistemaData) => {
      const sistema = sistemaData.sistemas;
      const permissao = sistemaData.permissao;

      sistemas.push(sistema);
      permissoes.push(permissao);

      const li = document.createElement("li");
      li.textContent = sistema;
      sistemasEdit.appendChild(li); // Adiciona um item de lista com o nome do sistema
    });

    const permissaoEdit = document.getElementById("permissaoEdit");
    permissaoEdit.innerHTML = ""; // Limpa o conteúdo existente

    // Cria checkboxes com as permissões
    permissoes.forEach((permissao) => {
      const checkbox = document.createElement("input");
      checkbox.type = "checkbox";
      checkbox.checked = permissao === "1"; // Marca o checkbox se a permissão for igual a '1'

      const td = document.createElement("td");
      td.style.padding = "4.3"; // Ajusta o espaçamento interno da célula

      const label = document.createElement("label");
      label.style.margin = "0"; // Ajusta o espaçamento externo do rótulo
      label.appendChild(checkbox);

      td.appendChild(label);

      const tr = document.createElement("tr");
      tr.appendChild(td);

      permissaoEdit.appendChild(tr); // Adiciona a linha da tabela de permissões
    });

    // Remove os inputs ocultos antigos, se houver
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
}

const editForm = document.getElementById("edit-usuario-form");

// Verifica se o formulário de edição existe
if (editForm) {
  // Adiciona um ouvinte de evento para o envio do formulário
  editForm.addEventListener("submit", async (e) => {
    e.preventDefault();
    console.log("Entrou aqui");

    // Obtém o ID do usuário a ser editado
    const idUsuario = document.getElementById("editid").value;
    const sistemas = [];
    const permissoes = [];

    // Itera sobre os checkboxes de permissões
    const checkboxes = editForm.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach((checkbox) => {
      const permissao = checkbox.checked ? "1" : "0";
      permissoes.push(permissao);
    });

    // Obtém os elementos de sistemas do formulário
    const sistemasElements = editForm.querySelectorAll('[name="sistema[]"]');
    sistemasElements.forEach((sistemaElement) => {
      const sistema = sistemaElement.value;
      sistemas.push(sistema);
    });

    const dadosForm = new FormData();
    dadosForm.append("id", idUsuario);

    // Adiciona os sistemas e permissões ao objeto FormData
    sistemas.forEach((sistema) => {
      dadosForm.append("sistema[]", sistema);
    });
    permissoes.forEach((permissao) => {
      dadosForm.append("permissao[]", permissao);
    });

    console.log("ID:", idUsuario);
    console.log("Sistemas:", sistemas);
    console.log("Permissões:", permissoes);

    const dados = await fetch("../src/updateUser.php", {
      method: "POST",
      body: dadosForm,
    });

    try {
      const resposta = await dados.json();
      alert("As alterações foram salvas corretamente!");
      return;
    } catch (error) {
      console.log("Erro ao processar a resposta:", error);
      alert(
        "Ocorreu um erro ao processar a resposta. Verifique o console para mais detalhes."
      );
    }
  });
}

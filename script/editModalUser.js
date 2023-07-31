

  // Função para exibir uma mensagem usando o SweetAlert
  function exibirMensagem(text, icon) {
    return Swal.fire({
      text: text,
      icon: icon,
      showCancelButton: false,
      confirmButtonColor: '#3085d6',
      confirmButtonText: 'Fechar'
    });
  }

  // Função para preencher a lista de sistemas
  function preencherSistemas(sistemasData) {
    const sistemasEdit = document.getElementById("sistemasEdit");
    sistemasEdit.innerHTML = "";

    const sistemas = [];
    const permissoes = [];

    sistemasData.forEach((sistemaData) => {
      const sistema = sistemaData.sistemas;
      const permissao = sistemaData.permissao;

      sistemas.push(sistema);
      permissoes.push(permissao);

      const li = document.createElement("li");
      li.textContent = sistema;
      sistemasEdit.appendChild(li);
    });

    return { sistemas, permissoes };
  }

  // Função para preencher a lista de permissões com checkboxes
  function preencherPermissoes(permissoes) {
    const permissaoEdit = document.getElementById("permissaoEdit");
    permissaoEdit.innerHTML = "";

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
  }

  // Função para preencher a tabela de termos assinados com checkboxes
  function preencherTermos(termosData) {
    const termosEdit = document.getElementById("termosEdit");
    termosEdit.innerHTML = "";

    termosData.forEach((termoData) => {
      const nomeTermo = termoData.nome_termo;
      const assinado = termoData.assinado;

      const tr = document.createElement("tr");

      const tdNomeTermo = document.createElement("td");
      tdNomeTermo.textContent = nomeTermo;
      tr.appendChild(tdNomeTermo);

      const tdAssinado = document.createElement("td");
      const checkboxTermo = document.createElement("input");
      checkboxTermo.type = "checkbox";
      checkboxTermo.checked = assinado === "1";
      tdAssinado.appendChild(checkboxTermo);
      tr.appendChild(tdAssinado);

      termosEdit.appendChild(tr);
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
        const editModel = new bootstrap.Modal(
          document.getElementById("editUsuarioModal")
        );
        editModel.show();

        const idUsuario = resposta.dados.id_usuario;
        console.log("ID do usuário:", idUsuario);
        document.getElementById("editid").value = idUsuario;

        // Preencher a lista de sistemas e permissões
        const { sistemas, permissoes } = preencherSistemas(resposta.dados.permissoes);
        preencherPermissoes(permissoes);

        // Preencher a tabela de termos assinados
        preencherTermos(resposta.dados.termos);
      }
    } catch (error) {
      console.error(error);
      // Se ocorrer um erro ao obter os dados do usuário, exibe uma mensagem de erro
      exibirMensagem("Erro ao obter dados do usuário.", "error");
    }
  }

  // Função para enviar o formulário de edição
  async function submitForm(event) {
    event.preventDefault();
    console.log("Entrou aqui");

    const idUsuario = document.getElementById("editid").value;

    // Obter os valores das checkboxes de termos e seus nomes
    const valoresTermos = [];
    const nomesTermos = [];
    const termosEdit = document.getElementById("termosEdit");
    const checkboxesTermos = termosEdit.querySelectorAll('input[type="checkbox"]');

    checkboxesTermos.forEach((checkbox) => {
      const valorCheckbox = checkbox.checked ? "1" : "0";
      valoresTermos.push(valorCheckbox);

      const nomeTermo = checkbox.parentElement.previousElementSibling.textContent.trim();
      nomesTermos.push(nomeTermo);
    });

    console.log("Valores das checkboxes dos termos:", valoresTermos);
    console.log("Nomes dos termos:", nomesTermos);

    // Obter os valores das checkboxes de permissões
    const permissoes = [];
    const permissaoEdit = document.getElementById("permissaoEdit");
    const checkboxes = permissaoEdit.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach((checkbox) => {
      const permissao = checkbox.checked ? "1" : "0";
      permissoes.push(permissao);
    });

    // Obter os sistemas selecionados
    const sistemas = Array.from(document.getElementById("sistemasEdit").children)
      .map(elemento => elemento.textContent.trim());

    console.log("ID:", idUsuario);
    console.log("Sistemas:", sistemas);
    console.log("Permissões:", permissoes);
    console.log("Valores dos termos:", valoresTermos);
    console.log("Nomes dos termos:", nomesTermos);

    // Crie o objeto FormData e adicione os dados do formulário
    const dadosForm = new FormData();
    dadosForm.append("id", idUsuario);
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
    valoresTermos.forEach((valor) => {
      dadosForm.append("termo[]", valor);
    });
    nomesTermos.forEach((nomeTermo) => {
      dadosForm.append("nome_termo[]", nomeTermo);
    });

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


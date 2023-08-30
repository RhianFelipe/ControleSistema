// Função para criar o botão de excluir sistema
function criarBotaoExcluir(idUsuario, sistema) {
  // Cria um novo elemento <td> que conterá o botão de excluir
  const tdExcluir = document.createElement("td");
  const btnExcluirSistema = document.createElement("button");
  btnExcluirSistema.type = "button";
  btnExcluirSistema.className = "btn-excluir";
  btnExcluirSistema.style.width = "25px"; // Define a largura do botão
  btnExcluirSistema.style.height = "25px"; // Define a altura do botão

  // Cria uma imagem para ser o ícone do botão
  const imgIcon = document.createElement("img");
  imgIcon.src = "../public/assets/img/excluir.png";
  imgIcon.alt = "Ícone X"; // Texto alternativo para acessibilidade
  imgIcon.style.width = "50%"; // Redimensiona a imagem para preencher todo o botão
  imgIcon.style.height = "50%"; // Redimensiona a imagem para preencher todo o botão
  imgIcon.style.objectFit = "contain"; // Ajusta a imagem dentro do botão
  imgIcon.style.marginTop = "-5px"; // Margem superior para ajustar a posição do ícone

  // Adiciona a imagem como filho do botão de excluir
  btnExcluirSistema.appendChild(imgIcon);

  // Define a ação que será executada ao clicar no botão de excluir
  btnExcluirSistema.onclick = () => excluirSistemaUser(idUsuario, sistema);

  // Adiciona o botão de excluir na célula da tabela (<td>)
  tdExcluir.appendChild(btnExcluirSistema);

  // Retorna a célula da tabela com o botão de excluir
  return tdExcluir;
}

// Função para preencher a tabela de sistemas
function preencherSistemas(sistemasData, idUsuario) {
  const sistemasEdit = document.getElementById("sistemasEdit");
  sistemasEdit.innerHTML = "";

  const sistemas = [];
  const permissoes = [];

  // Percorre os dados de sistemas recebidos e cria as linhas da tabela
  sistemasData.forEach((sistemaData) => {
    const sistema = sistemaData.sistemas;
    const permissao = sistemaData.permissao;

    sistemas.push(sistema);
    permissoes.push(permissao);

    // Cria uma nova linha (<tr>) para cada sistema
    const tr = document.createElement("tr");

    // Adiciona o botão de excluir como a primeira célula da linha
    tr.appendChild(criarBotaoExcluir(idUsuario, sistema));

    // Cria uma célula da tabela (<td>) para o nome do sistema e adiciona o nome
    const tdNomeSistema = document.createElement("td");
    tdNomeSistema.textContent = sistema;
    tr.appendChild(tdNomeSistema);

    // Adiciona a linha à tabela de sistemas
    sistemasEdit.appendChild(tr);
  });

  // Retorna os arrays de sistemas e permissões preenchidos
  return { sistemas, permissoes };
}

// Função para preencher as permissões da tabela de edição
function preencherPermissoes(permissoes, termosAssinados, grupoSelecionado, sistemas) {
  const permissaoEdit = document.getElementById("permissaoEdit");
  permissaoEdit.innerHTML = "";

  const primeiroTermoAssinado =
    grupoSelecionado === "Terceirizado" &&
    isTermoAssinado(termosAssinados, "Termo de Uso e Responsabilidade");

  permissoes.forEach((permissao, index) => {
    const checkbox = document.createElement("input");
    checkbox.type = "checkbox";
    checkbox.checked = permissao === "1";

    if (sistemas[index] === "VPN" || sistemas[index] === "Wi-Fi") {
      checkbox.addEventListener("change", function () {
        if (checkbox.checked) {
          Swal.fire({
            title: `Informe o valor para ${sistemas[index]}:`,
            input: "text",
            showCancelButton: true,
            confirmButtonText: "Salvar",
            preConfirm: (valor) => {
              if (!valor || valor.trim() === "") {
                Swal.showValidationMessage(`Informe um valor válido para ${sistemas[index]}`);
              }
              // Aqui você pode fazer algo com o valor inserido, como salvá-lo ou exibi-lo
              console.log(`Valor para ${sistemas[index]}: ${valor}`);
            },
          });
        }
      });
    }

    if (grupoSelecionado === "Terceirizado" && primeiroTermoAssinado) {
      checkbox.disabled = false;
    } else if (
      !termosAssinados ||
      !termosAssinados.every((termo) => termo.assinado === "1")
    ) {
      checkbox.disabled = true;
    }

    checkbox.style.width = "16px";
    checkbox.style.height = "16px";
    checkbox.style.borderRadius = "50%";
    checkbox.style.border = "2px solid #555";
    checkbox.style.outline = "none";
    checkbox.style.cursor = "pointer";

    const td = document.createElement("td");
    td.style.padding = "0.5px";

    const label = document.createElement("label");
    label.style.margin = "0";
    label.appendChild(checkbox);

    td.appendChild(label);

    const tr = document.createElement("tr");
    tr.appendChild(td);

    permissaoEdit.appendChild(tr);
  });
}

// Função para verificar se o termo foi assinado
function isTermoAssinado(termosAssinados, nomeTermo) {
  return termosAssinados.some(
    (termo) => termo.nome_termo === nomeTermo && termo.assinado === "1"
  );
}

// Função para preencher os termos na tabela de edição
function preencherTermos(termosData, grupoSelecionado, sidTermos) {
  const termosEdit = document.getElementById("termosEdit");
  termosEdit.innerHTML = "";

  // Verifica se o primeiro termo foi assinado no caso de um usuário terceirizado
  const primeiroTermoAssinado =
    grupoSelecionado === "Terceirizado" &&
    isTermoAssinado(termosData, "Termo de Uso e Responsabilidade");

  // Percorre os dados dos termos e cria as linhas da tabela de edição
  termosData.forEach((termoData, index) => {
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

    // Define a lógica de habilitar ou desabilitar os checkboxes com base no grupo selecionado e nos termos assinados
    if (index === 1 && grupoSelecionado === "Terceirizado") {
      checkboxTermo.disabled = true;
    } else {
      if (grupoSelecionado === "Terceirizado" && primeiroTermoAssinado) {
        checkboxTermo.disabled = false;
      }
    }

    tdAssinado.appendChild(checkboxTermo);
    tr.appendChild(tdAssinado);

    // Adiciona a linha com o termo à tabela de edição
    termosEdit.appendChild(tr);
  });
}

async function atualizarSidTermos() {
  const idUsuario = document.getElementById("editid").value;
  const novoSid = document.getElementById("sidInput").value;

  if (!idUsuario) {
    console.error("ID do usuário não encontrado.");
    return;
  }

  if (!novoSid.trim()) {
    Swal.fire({
      icon: "error",
      title: "Erro",
      text: "O SID não pode ser vazio.",
    });
    return;
  }

  const url = `../src/sid/updateSid.php?id=${idUsuario}&novoSid=${novoSid}`;

  try {
    const response = await fetch(url, {
      method: "GET",
    });

    if (response.ok) {
      Swal.fire({
        icon: "success",
        title: "Sucesso",
        text: "SID atualizado com sucesso.",
      });

      // Fechar o modal editSid
      const editSidModal = bootstrap.Modal.getInstance(
        document.getElementById("editSid")
      );
      editSidModal.hide();

      // Fechar a modal atual
      const editModel = bootstrap.Modal.getInstance(
        document.getElementById("editUsuarioModal")
      );
      editModel.hide();

      // Abrir a modal novamente para atualizar os dados
      openModalEdit(idUsuario);
    } else {
      Swal.fire({
        icon: "error",
        title: "Erro",
        text: "Erro ao atualizar o SID.",
      });
    }
  } catch (error) {
    console.error("Erro ao enviar a requisição:", error);
  }
}

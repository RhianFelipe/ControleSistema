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

    // Cria uma célula da tabela (<td>) para o nome do sistema
    const tdNomeSistema = document.createElement("td");

    // Adiciona o nome do sistema
    tdNomeSistema.textContent = sistema;

    tr.appendChild(tdNomeSistema);

    // Adiciona a linha à tabela de sistemas
    sistemasEdit.appendChild(tr);
  });

  // Retorna os arrays de sistemas e permissões preenchidos
  return { sistemas, permissoes };
}

// Função para preencher as permissões da tabela de edição
function preencherPermissoes(
  permissoes,
  termosAssinados,
  grupoSelecionado,
  sistemas
) {
  const permissaoEdit = document.getElementById("permissaoEdit");
  permissaoEdit.innerHTML = "";

  // Verifica se o primeiro termo foi assinado
  const primeiroTermoAssinado = termosAssinados.some(
    (termo) =>
      termo.nome_termo === "Termo de Uso e Responsabilidade" &&
      termo.assinado === "1"
  );

  permissoes.forEach((permissao, index) => {
    const checkbox = document.createElement("input");
    checkbox.type = "checkbox";
    checkbox.checked = permissao === "1";
  /*
  
  
 
    // Verifica se sistemas[index] é igual a "Wi-Fi" ou "VPN" para desabilitar o checkbox
    if (sistemas[index] === "Wi-Fi" || sistemas[index] === "VPN") {
      checkbox.disabled = true;
    } else {
      // Define a lógica de habilitar ou desabilitar os checkboxes com base no grupo selecionado e nos termos assinados
      if (grupoSelecionado === "Terceirizado") {
        // Para terceirizados, habilitar todas as checkboxes se o primeiro termo foi assinado
        checkbox.disabled = !primeiroTermoAssinado;
      } else {
        // Para outros grupos, habilitar todas as checkboxes se ambos os dois primeiros termos foram assinados
        checkbox.disabled = !(
          termosAssinados[0]?.assinado === "1" &&
          termosAssinados[1]?.assinado === "1"
        );
      }
    }
 */
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
function preencherTermos(termosData, grupoSelecionado) {
  const termosEdit = document.getElementById("termosEdit");
  termosEdit.innerHTML = "";

  const divSidWiFi = document.getElementById('divSidWiFi');
  const divSidVPN = document.getElementById('divSidVPN');
  const divSidTCC = document.getElementById('divSidTCC');
  const divSidTUR = document.getElementById('divSidTUR');


  // Oculta inicialmente as divs do Wi-Fi e VPN
  divSidWiFi.style.display = 'none';
  divSidVPN.style.display = 'none';
  divSidTUR.style.display = 'none';
  divSidTCC.style.display = 'none';

  // Verifica se o primeiro termo foi assinado no caso de um usuário terceirizado
  const primeiroTermoAssinado =
    grupoSelecionado === "Terceirizado" &&
    isTermoAssinado(termosData, "Termo de Uso e Responsabilidade");

    

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

    // Verifica se o termo está assinado e desabilita a checkbox
    if (assinado === "1") {
      checkboxTermo.disabled = true; // Desabilita a checkbox se o termo estiver assinado
    } else if (grupoSelecionado === "Terceirizado") {
      // Se for um usuário terceirizado, mantém a lógica existente
      if (index === 1) {
        checkboxTermo.disabled = true;
      } else if (primeiroTermoAssinado) {
        checkboxTermo.disabled = false;
      }
    }

    tdAssinado.appendChild(checkboxTermo);
    tr.appendChild(tdAssinado);

    // Adiciona a linha com o termo à tabela de edição
    termosEdit.appendChild(tr);

    // Verifica e exibe a div correspondente ao termo assinado
    if (nomeTermo === 'Termo de Wi-Fi' && assinado === '1') {
      divSidWiFi.style.display = 'inline-block';
    }

    if (nomeTermo === 'Termo de VPN' && assinado === '1') {
      divSidVPN.style.display = 'inline-block';
    }

    if (nomeTermo === 'Termo de Uso e Responsabilidade' && assinado === '1') {
      divSidTUR.style.display = 'inline-block';
    }

    if (nomeTermo === 'Termo de Compromisso e Confidencialidade' && assinado === '0' && grupoSelecionado === "Terceirizado" ) {
      divSidTCC.style.display = 'none';
    }else if(nomeTermo === 'Termo de Compromisso e Confidencialidade' && assinado === '1'){
      divSidTCC.style.display = 'inline-block';
    }

  });
}

// Função para criar uma div com os elementos desejados
function createSidDiv(id, labelText, onClickFunction, linkId, linkText) {
  const div = document.createElement('div');
  div.id = id;
  div.style.display = 'inline-block';
  div.style.margin = '0';
  div.style.marginLeft = '10px';

  const paragraph = document.createElement('p');
  paragraph.id = 'sidText';
  paragraph.style.display = 'inline-block';
  paragraph.style.margin = '0';
  paragraph.style.marginLeft = '10px';
  paragraph.textContent = labelText;

  const link = document.createElement('a');
  link.id = linkId;
  link.href = '#'; // Defina o href conforme necessário
  link.style.display = 'inline-block';
  link.style.marginLeft = '3px';
  link.title = 'Clique para copiar SID e ser redirecionado ao site do eProtocolo';
  link.target = '_blank';
  link.textContent = linkText;
  link.onclick = function() {
    copyAndRedirect(linkId, 'https://www.eprotocolo.pr.gov.br/spiweb/consultarProtocoloDigital.do?action=pesquisar');
    return false;
  };

  const button = document.createElement('button');
  button.id = 'editarSidButton';
  button.onclick = onClickFunction;
  button.type = 'button';

  const image = document.createElement('img');
  image.src = '../public/assets/img/pen.svg';
  image.alt = '';

  button.appendChild(image);
  paragraph.appendChild(link);
  paragraph.appendChild(button);
  div.appendChild(paragraph);

  return div;
}

function openSidModalTur() {
  const editSid = new bootstrap.Modal(
    document.getElementById("editSidTermoTur")
  );
  editSid.show();
}

function openSidModalTcc() {
  const editSid = new bootstrap.Modal(
    document.getElementById("editSidTermoTcc")
  );
  editSid.show();
}

function openSidModalWifi() {
  const editSid = new bootstrap.Modal(document.getElementById("editSidWi-Fi"));
  editSid.show();
}
function openSidModalVPN() {
  const editSid = new bootstrap.Modal(document.getElementById("editSidVPN"));
  editSid.show();
}

// Função para adicionar as divs ao contêiner
function addDivsToContainer() {
  const container = document.getElementById('divContainer');

  const divSidTUR = createSidDiv('divSidTUR', 'SID TUR:', openSidModalTur, 'sidValueTermoTur', '');
  const divSidTCC = createSidDiv('divSidTCC', 'SID TCC:', openSidModalTcc, 'sidValueTermoTcc', '');
  const divSidWiFi = createSidDiv('divSidWiFi', 'SID Wi-Fi:', openSidModalWifi, 'sidValueWi-Fi', '');
  const divSidVPN = createSidDiv('divSidVPN', 'SID VPN:', openSidModalVPN, 'sidValueVPN', '');


  container.appendChild(divSidTUR);
  container.appendChild(divSidTCC);
  container.appendChild(divSidWiFi);
  container.appendChild(divSidVPN);
}

// Chama a função para adicionar as divs ao carregar a página
addDivsToContainer();




async function atualizarSid(nomeSid) {
  const idUsuario = document.getElementById("editid").value;
  const novoSid = document.getElementById(`sidInput${nomeSid}`).value;

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

  const url = `../src/sid/updateSID.php?id=${idUsuario}&novoSid=${novoSid}&nomeSid=${nomeSid}`;

  try {
    const response = await fetch(url, {
      method: "GET",
    });
    const data = await response.json(); // Analisa a resposta JSON
    console.log(data)
    if (data.status == true) {
      exibirMensagem("success", "Sucesso", data.msg);
      // Fechar o modal editSid
      const linkElement = document.getElementById(`sidValue${nomeSid}`);
    
      linkElement.textContent = novoSid;
      const editSidModal = bootstrap.Modal.getInstance(
        document.getElementById(`editSid${nomeSid}`)
      );
      editSidModal.hide();


    } else {
      exibirMensagem("error", "Erro", data.msg);
    }
  } catch (error) {
    console.error("Erro ao enviar a requisição:", error);
  }
}

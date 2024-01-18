
// Função para preencher a tabela de sistema
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
) {
    const permissaoEdit = document.getElementById("permissaoEdit");
    permissaoEdit.innerHTML = "";

    permissoes.forEach((permissao, index) => {
        const textoPermissao = permissao === "1" ? "Sim" : "Não";
        const classePermissao = permissao === "1" ? "verde" : "vermelha";

        const td = document.createElement("td");
       
        td.textContent = textoPermissao;
        td.classList.add(classePermissao); // Adiciona a classe à célula

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
        checkboxTermo.disabled = true; // Desabilita todas as checkboxes

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

        if (nomeTermo === 'Termo de Compromisso e Confidencialidade' && assinado === '0' && grupoSelecionado === "Terceirizado") {
            divSidTCC.style.display = 'none';
        } else if (nomeTermo === 'Termo de Compromisso e Confidencialidade' && assinado === '1') {
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
    link.onclick = function () {
        copyAndRedirect(linkId, 'https://www.eprotocolo.pr.gov.br/spiweb/consultarProtocoloDigital.do?action=pesquisar');
        return false;
    };
    paragraph.appendChild(link);
    div.appendChild(paragraph);
    return div;
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

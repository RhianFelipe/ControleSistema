function criarBotaoExcluir(idUsuario, sistema) {
    const tdExcluir = document.createElement("td");
    const btnExcluirSistema = document.createElement("button");
    btnExcluirSistema.type = "button";
    btnExcluirSistema.className = "btn-excluir";
    btnExcluirSistema.style.width = "25px"; // Largura do botão
    btnExcluirSistema.style.height = "25px"; // Altura do botão
  
    const imgIcon = document.createElement("img");
    imgIcon.src = "../public/assets/img/excluir.png";
    imgIcon.alt = "Ícone X"; // Texto alternativo para acessibilidade
    imgIcon.style.width = "50%"; // Redimensiona a imagem para preencher todo o botão
    imgIcon.style.height = "50%"; // Redimensiona a imagem para preencher todo o botão
    imgIcon.style.objectFit = "contain"; // Ajusta a imagem dentro do botão
    imgIcon.style.marginTop = "-5px"; // Margem superior para ajustar a posição do ícone
  
    btnExcluirSistema.appendChild(imgIcon);
    btnExcluirSistema.onclick = () => excluirSistema(idUsuario, sistema);
    tdExcluir.appendChild(btnExcluirSistema);
  
    btnExcluirSistema.setAttribute("data-bs-toggle", "tooltip");
    btnExcluirSistema.setAttribute("data-bs-placement", "top");
    btnExcluirSistema.setAttribute("title", "Excluir Sistema");
    new bootstrap.Tooltip(btnExcluirSistema);
  
    return tdExcluir;
  }
  
  function preencherSistemas(sistemasData, idUsuario) {
    const sistemasEdit = document.getElementById("sistemasEdit");
    sistemasEdit.innerHTML = "";
  
    const sistemas = [];
    const permissoes = [];
  
    sistemasData.forEach((sistemaData) => {
      const sistema = sistemaData.sistemas;
      const permissao = sistemaData.permissao;
  
      sistemas.push(sistema);
      permissoes.push(permissao);
  
      const tr = document.createElement("tr");
      tr.appendChild(criarBotaoExcluir(idUsuario, sistema));
  
      const tdNomeSistema = document.createElement("td");
      tdNomeSistema.textContent = sistema;
      tr.appendChild(tdNomeSistema);
  
      sistemasEdit.appendChild(tr);
    });
  
    return { sistemas, permissoes };
  }
  
  function preencherPermissoes(permissoes, termosAssinados, grupoSelecionado) {
    const permissaoEdit = document.getElementById("permissaoEdit");
    permissaoEdit.innerHTML = "";
  
    const primeiroTermoAssinado = grupoSelecionado === "Terceirizado" && isTermoAssinado(termosAssinados, "Termo de Uso e Responsabilidade");
  
    permissoes.forEach((permissao, index) => {
      const checkbox = document.createElement("input");
      checkbox.type = "checkbox";
      checkbox.checked = permissao === "1";
  
      if (grupoSelecionado === "Terceirizado" && primeiroTermoAssinado) {
        checkbox.disabled = false;
      } else if (!termosAssinados || !termosAssinados.every(termo => termo.assinado === "1")) {
        checkbox.disabled = true;
      }
  
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

  
function isTermoAssinado(termosAssinados, nomeTermo) {
    return termosAssinados.some(termo => termo.nome_termo === nomeTermo && termo.assinado === "1");
  }
  
  function preencherTermos(termosData, grupoSelecionado) {
    const termosEdit = document.getElementById("termosEdit");
    termosEdit.innerHTML = "";
  
    const primeiroTermoAssinado = grupoSelecionado === "Terceirizado" && isTermoAssinado(termosData, "Termo de Uso e Responsabilidade");
  
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
  
      if (index === 1 && grupoSelecionado === "Terceirizado") {
        checkboxTermo.disabled = true;
      } else {
        if (grupoSelecionado === "Terceirizado" && primeiroTermoAssinado) {
          checkboxTermo.disabled = false;
        }
      }
  
      tdAssinado.appendChild(checkboxTermo);
      tr.appendChild(tdAssinado);
  
      termosEdit.appendChild(tr);
    });
  }
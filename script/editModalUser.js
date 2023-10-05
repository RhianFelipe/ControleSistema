async function adicionarSistemaPersonalizado() {
  const inputSistemaPersonalizado = document.getElementById(
    "inputSistemaPersonalizado"
  ).value;
  const idUsuario = document.getElementById("editid").value;

  if (!idUsuario) {
    console.error("ID do usuário não encontrado.");
    return;
  }

  try {
    // Construir a URL com os parâmetros, incluindo o ID do usuário
    const url = `../src/addSistemaPerson.php?sistema=${encodeURIComponent(
      inputSistemaPersonalizado
    )}&idUsuario=${idUsuario}`;

    // Requisição fetch para enviar os dados via método GET
    const resposta = await fetch(url);
    const resultado = await resposta.json();

    // Verifica se a adição foi bem-sucedida
    if (resultado.status) {
      exibirMensagem("success", "Sucesso", resultado.msg);
      // Fechar a modal atual
      const editModel = bootstrap.Modal.getInstance(
        document.getElementById("editUsuarioModal")
      );
      editModel.hide();

      // Abrir a modal novamente para atualizar os dados
      openModalEdit(idUsuario);
    } else {
      exibirMensagem("error", "Erro", resultado.msg);
    }
  } catch (error) {
    console.error("Erro ao enviar requisição de adição:", error);
  }
}

async function excluirSistemaUser(idUsuario, nomeSistema) {
  try {
    console.log(idUsuario, nomeSistema);

    const confirmacao = await Swal.fire({
      title: "Tem certeza?",
      text: `Você está prestes a excluir o sistema "${nomeSistema}". Esta ação não poderá ser desfeita.`,
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Sim",
      cancelButtonText: "Não",
    });

    if (confirmacao.isConfirmed) {
      const url = `../src/deleteUserSistema.php?idUsuario=${idUsuario}&nomeSistema=${nomeSistema}`;
      const resposta = await fetch(url);
      const resultado = await resposta.json();

      if (resultado.status) {
        exibirMensagem("success", "Sucesso", resultado.msg);
        // Fechar a modal atual
        const editModel = bootstrap.Modal.getInstance(
          document.getElementById("editUsuarioModal")
        );
        editModel.hide();

        // Abrir a modal novamente para atualizar os dados
        openModalEdit(idUsuario);
      } else {
        exibirMensagem("error", "Erro", resultado.msg);
      }
    } else {
      console.log("Exclusão cancelada pelo usuário.");
    }
  } catch (error) {
    console.error("Erro ao enviar requisição de exclusão:", error);
  }
}

async function openModalEdit(id) {
  console.log(id);

  try {
    const dados = await fetch("../src/viewUser.php?id=" + id);
    const resposta = await dados.json();

    console.log(resposta);

    if (!resposta["status"]) {
      document.getElementById("msgAlerta").innerHTML = resposta["msg"];
    } else {
      const editModel = new bootstrap.Modal(
        document.getElementById("editUsuarioModal")
      );
      editModel.show();

      const idUsuario = resposta.dados.id_usuario;
      console.log("ID do usuário:", idUsuario);
      document.getElementById("editid").value = idUsuario;

      const { sistemas, permissoes } = preencherSistemas(
        resposta.dados.permissoes,
        idUsuario
      );

      const grupoSelecionado = resposta.dados.grupo;
      console.log("Grupo que veio:", grupoSelecionado);
      const termosAssinados = resposta.dados.termos;
      console.log("Termos:", resposta.dados.termos);

      const sidTermoTur = resposta.dados.sidTermoTur;
      const sidTermoTcc = resposta.dados.sidTermoTcc;
      const sidWifi =  resposta.dados.sidWifi;
      const sidVPN = resposta.dados.sidVPN;
      console.log("Sid Tur: ", sidTermoTur);
      console.log("Sid Tcc: ", sidTermoTcc);
    
      preencherPermissoes(
        permissoes,
        termosAssinados,
        grupoSelecionado,
        sistemas
      );

      preencherTermos(termosAssinados, grupoSelecionado);

      const sidValueTur = document.getElementById("sidValueTur");
      sidValueTur.textContent = sidTermoTur ; 

      const sidValueTcc = document.getElementById("sidValueTcc");
      sidValueTcc.textContent = sidTermoTcc; 

      const sidValueWifi = document.getElementById("sidValueWifi");
      sidValueWifi.textContent = sidWifi; 

      const sidValueVPN = document.getElementById("sidValueVPN");
      sidValueVPN.textContent = sidVPN; 

    }
  } catch (error) {
    console.error(error);
    exibirMensagem("error", "Erro", "Erro ao obter dados do usuário.");
  }
}

async function submitForm(event) {
  event.preventDefault();
  console.log("Entrou aqui");

  const idUsuario = document.getElementById("editid").value;
  const valoresTermos = [];
  const nomesTermos = [];
  const termosEdit = document.getElementById("termosEdit");
  const checkboxesTermos = termosEdit.querySelectorAll(
    'input[type="checkbox"]'
  );

  checkboxesTermos.forEach((checkbox) => {
    const valorCheckbox = checkbox.checked ? "1" : "0";
    valoresTermos.push(valorCheckbox);

    const nomeTermo =
      checkbox.parentElement.previousElementSibling.textContent.trim();
    nomesTermos.push(nomeTermo);
  });

  console.log("Valores das checkboxes dos termos:", valoresTermos);
  console.log("Nomes dos termos:", nomesTermos);

  const permissoes = [];
  const permissaoEdit = document.getElementById("permissaoEdit");
  const checkboxes = permissaoEdit.querySelectorAll('input[type="checkbox"]');
  checkboxes.forEach((checkbox) => {
    const permissao = checkbox.checked ? "1" : "0";
    permissoes.push(permissao);
  });

  const sistemas = Array.from(
    document.getElementById("sistemasEdit").children
  ).map((elemento) => elemento.textContent.trim());

  console.log("ID:", idUsuario);
  console.log("Sistemas:", sistemas);
  console.log("Permissões:", permissoes);
  console.log("Valores dos termos:", valoresTermos);
  console.log("Nomes dos termos:", nomesTermos);

  const dadosForm = new FormData();
  dadosForm.append("id", idUsuario);
  const selectGrupo = document.getElementById("input-value");
  const grupoSelecionado = selectGrupo.value;
  console.log("Grupo enviado:", grupoSelecionado);
  dadosForm.append("grupo", grupoSelecionado);

  const selectSetor = document.getElementById("input-setor");
  const setorSelecionado = selectSetor.value;
  console.log("Setor enviado:", setorSelecionado);
  dadosForm.append("setor", setorSelecionado);

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
    const dados = await fetch("../src/updateUser.php", {
      method: "POST",
      body: dadosForm,
    });

    const resposta = await dados.json();
    if (resposta.status) {
      exibirMensagem("success", "Sucesso", resposta.msg);
      // Fechar a modal atual
      const editModel = bootstrap.Modal.getInstance(
        document.getElementById("editUsuarioModal")
      );
      editModel.hide();

      // Abrir a modal novamente para atualizar os dados
      openModalEdit(idUsuario);
    } else {
      exibirMensagem("ERRO: As alterações não foram salvas!", "error");
    }
  } catch (error) {
    console.error(error);
    exibirMensagem("Erro ao processar a requisição.", "error");
  }
}

const editForm = document.getElementById("edit-usuario-form");
if (editForm) {
  editForm.addEventListener("submit", submitForm);
}

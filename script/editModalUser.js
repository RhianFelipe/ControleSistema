
async function adicionarSistemaPersonalizado() {
  const inputSistemaPersonalizado = document.getElementById("inputSistemaPersonalizado").value;
  const idUsuario = document.getElementById("editid").value;

  if (!idUsuario) {
    console.error("ID do usuário não encontrado.");
    return;
  }

  try {
    // Construir a URL com os parâmetros, incluindo o ID do usuário
    const url = `../src/addSistemaPerson.php?sistema=${encodeURIComponent(inputSistemaPersonalizado)}&idUsuario=${idUsuario}`;

    // Requisição fetch para enviar os dados via método GET
    const resposta = await fetch(url);

    const resultado = await resposta.json();

    // Verifica se a adição foi bem-sucedida
    if (resultado.status === true) {
      // Aqui você pode fazer alguma ação adicional, como recarregar os dados da página
      // ou exibir uma mensagem de sucesso.
      console.log("Sistema personalizado adicionado com sucesso!");

      // Exemplo de mensagem de sucesso usando SweetAlert manualmente
      Swal.fire({
        title: 'Sucesso!',
        text: 'O sistema personalizado foi adicionado com sucesso!',
        icon: 'success',
      });
    } else {
      console.error("Erro ao adicionar sistema personalizado:", resultado.msg);

      // Exemplo de mensagem de erro usando SweetAlert manualmente
      Swal.fire({
        title: 'Erro!',
        text: resultado.msg,
        icon: 'error',
      });
    }
  } catch (error) {
    console.error("Erro ao enviar requisição de adição:", error);
  }
}




async function excluirSistemaUser(idUsuario, nomeSistema) {
  try {
    console.log(idUsuario,nomeSistema)
    const confirmacao = await Swal.fire({
      title: 'Tem certeza?',
      text: `Você está prestes a excluir o sistema "${nomeSistema}". Esta ação não poderá ser desfeita.`,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Sim, excluir',
      cancelButtonText: 'Cancelar',
      reverseButtons: true,
    });

    if (confirmacao.isConfirmed) {
      const url = `../src/deleteUserSistema.php?idUsuario=${idUsuario}&nomeSistema=${nomeSistema}`;
      const resposta = await fetch(url);
      const resultado = await resposta.json();

      if (resultado.status === true) {
        console.log("Sistema excluído com sucesso!");
        Swal.fire('Sucesso!', 'O sistema foi excluído com sucesso!', 'success');
      } else {
        console.error("Erro ao excluir sistema:", resultado.msg);
        Swal.fire('Erro!', 'Erro ao excluir o sistema.', 'error');
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

      const { sistemas, permissoes } = preencherSistemas(resposta.dados.permissoes,idUsuario);
      const grupoSelecionado = resposta.dados.grupo;
      console.log("é oq veio?:",grupoSelecionado);
      const termosAssinados = resposta.dados.termos;
      console.log("AAA?:",resposta.dados.termos)

      preencherPermissoes(permissoes, termosAssinados, grupoSelecionado);

      preencherTermos(termosAssinados, grupoSelecionado);
    }
  } catch (error) {
    console.error(error);
    exibirMensagem("Erro ao obter dados do usuário.", "error");
  }
}


async function submitForm(event) {
  event.preventDefault();
  console.log("Entrou aqui");

  const idUsuario = document.getElementById("editid").value;
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

  const permissoes = [];
  const permissaoEdit = document.getElementById("permissaoEdit");
  const checkboxes = permissaoEdit.querySelectorAll('input[type="checkbox"]');
  checkboxes.forEach((checkbox) => {
    const permissao = checkbox.checked ? "1" : "0";
    permissoes.push(permissao);
  });

  const sistemas = Array.from(document.getElementById("sistemasEdit").children)
    .map(elemento => elemento.textContent.trim());

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
      exibirMensagem('As alterações foram salvas corretamente!', 'success');
    } else {
      exibirMensagem('ERRO: As alterações não foram salvas!', 'error');
    }
  } catch (error) {
    console.error(error);
    exibirMensagem('Erro ao processar a requisição.', 'error');
  }
}

const editForm = document.getElementById("edit-usuario-form");
if (editForm) {
  editForm.addEventListener("submit", submitForm);
}

async function openModalView(id) {
  console.log(id);

  try {
    const dados = await fetch("../../src/viewUser.php?id=" + id);
    const resposta = await dados.json();

    console.log(resposta);

    if (!resposta["status"]) {
      document.getElementById("msgAlerta").innerHTML = resposta["msg"];
    } else {
      const editModel = new bootstrap.Modal(
        document.getElementById("viewUsuarioModal")
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
      const setorSelecionado = resposta.dados.setor;
      console.log("Setor que veio:", setorSelecionado);

      // Suponha que 'grupoSelecionado' e 'setorSelecionado' sejam os valores retornados pelo fetch

      // Definir valor selecionado para o select do grupo
      document.getElementById("input-value").textContent = grupoSelecionado;

      // Definir valor selecionado para o select do setor
      document.getElementById("input-setor").textContent = setorSelecionado;

      // Verificar se o valor retornado é 'Padrão' e definir o valor do select de acordo
      if (grupoSelecionado === "Padrão") {
        document.getElementById("input-value").value = "";
      }

      if (setorSelecionado === "Padrão") {
        document.getElementById("input-setor").value = "";
      }

      const termosAssinados = resposta.dados.termos;
      console.log("Termos:", resposta.dados.termos);
      const sidTermoTur = resposta.dados.sidTermoTur;
      const sidTermoTcc = resposta.dados.sidTermoTcc;
      const sidWifi = resposta.dados.sidWifi;
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

      const nomeUsuarioTitle = document.getElementById("nomeTitleModalUser");
      nomeUsuarioTitle.textContent = resposta.dados.nome;
      console.log("Nome do Usuário:", resposta.dados.nome);

      const sidValueTur = document.getElementById("sidValueTermoTur");
      sidValueTur.textContent = sidTermoTur;

      const sidValueTcc = document.getElementById("sidValueTermoTcc");
      sidValueTcc.textContent = sidTermoTcc;

      const sidValueWifi = document.getElementById("sidValueWi-Fi");
      sidValueWifi.textContent = sidWifi;

      const sidValueVPN = document.getElementById("sidValueVPN");
      sidValueVPN.textContent = sidVPN;
    }
  } catch (error) {
    console.error(error);
    exibirMensagem("error", "Erro", "Erro ao obter dados do usuário.");
  }
}

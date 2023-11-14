async function openModalSistema() {
    const editSistema = new bootstrap.Modal(document.getElementById('editSistema'));
    try {
        const resposta = await fetch('../src/sistema/viewSistema.php');
        const dados = await resposta.json();

        const tabelaSistemas = document.getElementById('tabelaSistemas');
        tabelaSistemas.innerHTML = ''; // Limpa a tabela antes de atualizá-la

        if (!dados.status) {
            const newRow = tabelaSistemas.insertRow();
            const cell = newRow.insertCell(0);
            cell.colSpan = 2;
            cell.textContent = 'Nenhum sistema cadastrado'; // Mensagem para nenhum sistema cadastrado
        } else {
            dados.dados.forEach(nomeSistema => {
                const newRow = tabelaSistemas.insertRow();
                const cellNomeSistema = newRow.insertCell(0);
                cellNomeSistema.textContent = nomeSistema;

                const cellBotaoExcluir = newRow.insertCell(1);
                const botaoExcluir = document.createElement('button');
                botaoExcluir.textContent = 'Excluir';
                botaoExcluir.className = 'button-excluir';
                botaoExcluir.addEventListener('click', () => excluirSistema(nomeSistema));
                cellBotaoExcluir.appendChild(botaoExcluir);
            });
        }
    } catch (error) {
        console.error('Houve um erro:', error);
    } finally {
        editSistema.show();
    }
}


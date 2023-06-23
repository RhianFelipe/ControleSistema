 async function openPopup(id) {
        console.log(id)

        const dados = await fetch('../src/viewUser.php?id=' + id);
        const resposta = await dados.json();

        console.log(resposta);
        if (!resposta['status']) {
            document.getElementById("msgAlerta").innerHTML = resposta['msg']
        } else {
            const editModel = new bootstrap.Modal(document.getElementById("editUsuarioModal"))
            editModel.show()
            const idUsuario = resposta['dados'][0].id_usuario;
            document.getElementById("editid").value = idUsuario;
            console.log("ID:", idUsuario);
            const sistemasEdit = document.getElementById('sistemasEdit');
            sistemasEdit.innerHTML = ""; // Limpar o conteúdo existente, se houver
            console.log("Dados:", resposta['dados'])


            const sistemas = resposta['dados'].map(obj => obj.sistemas);
      

            console.log("Sistemas Mapeados: ", sistemas);
            
            sistemas.forEach(sistema => {
                const li = document.createElement('li');
                li.textContent = sistema;
                sistemasEdit.appendChild(li);

                // Criar input oculto para o sistema
                const inputSistema = document.createElement('input');
                inputSistema.type = 'hidden';
                inputSistema.name = 'sistema[]';
                inputSistema.value = sistema;
                editForm.appendChild(inputSistema);
            });

            const permissaoEdit = document.getElementById('permissaoEdit');
            permissaoEdit.innerHTML = ""; // Limpar o conteúdo existente, se houver

            const permissoes = resposta['dados'].map(obj => obj.permissao);
            console.log("Permissões Mapeadas: ", permissoes);

            permissoes.forEach(permissao => {
                const checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.checked = permissao === '1'; // Marca o checkbox se a permissao for igual a '1'

                const td = document.createElement('td');
                td.style.padding = '4.3'; // Ajustar o espaçamento interno da célula

                const label = document.createElement('label');
                label.style.margin = '0'; // Ajustar o espaçamento externo do rótulo
                label.appendChild(checkbox);

                td.appendChild(label);

                const tr = document.createElement('tr');
                tr.appendChild(td);

                permissaoEdit.appendChild(tr);

                // Criar input oculto para a permissao
                const inputPermissao = document.createElement('input');
                inputPermissao.type = 'hidden';
                inputPermissao.name = 'permissao[]';
                inputPermissao.value = permissao;
                editForm.appendChild(inputPermissao);
            });
        }
    }
    const editForm = document.getElementById("edit-usuario-form");
    if (editForm) {
        editForm.addEventListener("submit", async (e) => {
            e.preventDefault();
            console.log("Entrou aqui");
            const idUsuario = document.getElementById("editid").value;
            const sistemas = [];
            const permissoes = [];
            const checkboxes = editForm.querySelectorAll('input[type="checkbox"]');

            checkboxes.forEach(checkbox => {
                const permissao = checkbox.checked ? '1' : '0';
                permissoes.push(permissao);
            });
            const sistemasElements = editForm.querySelectorAll('[name="sistema[]"]');
            sistemasElements.forEach(sistemaElement => {
                const sistema = sistemaElement.value;
                sistemas.push(sistema);
            });

            const dadosForm = new FormData();
            dadosForm.append('id', idUsuario);
            sistemas.forEach(sistema => {
                dadosForm.append('sistema[]', sistema);
            });
            permissoes.forEach(permissao => {
                dadosForm.append('permissao[]', permissao);
            });

            console.log("ID:", idUsuario);
            console.log("Sistemas:", sistemas);
            console.log("Permissões:", permissoes);
            const dados = await fetch("../src/updateUser.php", {
                method: "POST",
                body: dadosForm
            });
            const resposta = await dados.json();
            console.log("Resposta do edit form:", resposta);
            if (resposta.status === true) {
                alert('As alterações foram salvas corretamente!');
            } else {
                alert('Ocorreu um erro ao salvar as alterações.');
            }
        });

    }
  
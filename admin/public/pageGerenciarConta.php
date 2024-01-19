<h1>Criar Contas</h1>
<form id="accountForm" method="post">
    <label for="username">Nome de Usuário:</label>
    <input type="text" id="username" required>

    <label for="password">Senha:</label>
    <input type="password" id="password" required>

    <label for="permission">Permissão:</label>
    <select id="permission" required>
        <option value="Sim">Sim</option>
        <option value="Não">Não</option>
    </select>

    <button type="button" onclick="submitForm()">Criar Conta</button>
</form>
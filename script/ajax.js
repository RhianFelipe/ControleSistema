// Intercepta o envio do formulário
$('form').submit(function(event) {
    event.preventDefault(); // Evita o envio do formulário
  
    // Obtém o nome do usuário
    var nome = $('#nome').val();
  
    // Obtém as permissões selecionadas
    var permissoes = [];
    $('input[name="permissoes[]"]:checked').each(function() {
      permissoes.push($(this).val());
    });
  
    // Cria um objeto com os dados a serem enviados via AJAX
    var dados = {
      nome: nome,
      permissoes: permissoes
    };
  
    // Envia os dados para o arquivo cadastrar.php usando AJAX
    $.ajax({
      url: 'cadastrarUser.php',
      method: 'POST',
      data: dados,
      success: function(response) {
        // Manipula a resposta do servidor, se necessário
        console.log(response);
        // Redireciona ou exibe uma mensagem de sucesso, por exemplo
      },
      error: function(xhr, status, error) {
        // Manipula o erro, se ocorrer
        console.log(error);
        // Exibe uma mensagem de erro, por exemplo
      }
    });
  });
  
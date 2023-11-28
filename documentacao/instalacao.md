# Guia de Instalação e Uso do WAMP

Este guia oferece instruções para instalação do WampServer e algumas orientações básicas de uso.

## Instalação do WampServer

### 1. Baixar o instalador do WampServer

- Acesse o site oficial do WampServer: [WampServer](https://www.wampserver.com/en/).
- Faça o download da versão mais recente compatível com seu sistema operacional (32 bits ou 64 bits).

### 2. Executar o instalador

- Após o download, execute o arquivo do instalador (.exe) que foi baixado.
- Quando solicitado pelo assistente de instalação, selecione o idioma desejado e clique em "Next".

### 3. Aceitar os termos de licença

- Leia os termos de licença do WampServer.
- Se você concorda com os termos, marque a caixa de seleção "I accept the agreement" (Eu aceito o acordo) e clique em "Next".

### 4. Escolher o local de instalação

- Escolha o diretório de instalação para o WampServer.
- O diretório padrão é geralmente `C:\wamp`. Você pode alterar o local de instalação se desejar.
- Clique em "Next" para prosseguir.

### 5. Selecionar componentes

- Selecione os componentes que deseja instalar (Apache, MySQL, PHP e phpMyAdmin). Normalmente, é recomendado deixar todas as opções marcadas.
- Clique em "Next".

### 6. Configurar o servidor de email (opcional)

- Se desejar configurar o servidor de email no WampServer, siga as instruções do assistente.
- Caso contrário, desmarque a opção "Send email" (Enviar e-mail) e clique em "Next".

### 7. Concluir a instalação

- Revise as opções selecionadas.
- Clique em "Install" para iniciar o processo de instalação.

### 8. Concluir a configuração

- Ao término da instalação, você pode ser solicitado a selecionar seu navegador padrão para o WampServer. Escolha o navegador desejado e clique em "Open".

### 9. Verificar a instalação

- Após a conclusão, abra seu navegador web e digite `http://localhost/` na barra de endereços.
- Se tudo estiver configurado corretamente, você deve ver a página inicial do WampServer ou uma mensagem de boas-vindas.

## Uso do WampServer

### Acessar o phpMyAdmin

- Abra um navegador web.
- Digite `http://localhost/phpmyadmin` na barra de endereços.
- Faça login usando o usuário e senha padrão (geralmente usuário: `root` e senha em branco ou 'root' também).

### Acessar a Página Principal .php

- Para criar e visualizar arquivos PHP, coloque seus arquivos na pasta `www` localizada no diretório de instalação do WAMP (por padrão, `C:\wamp\www`).
- Para acessar um arquivo PHP específico, digite `http://localhost/nome_do_arquivo.php` na barra de endereços do seu navegador.

## Uso do Visual Studio Code para PHP

O Visual Studio Code (VS Code) é uma ferramenta popular para desenvolvimento que oferece suporte para codificação em PHP. Para começar:

### 1. Instale a extensão PHP no VS Code

- Abra o VS Code.
- Na barra lateral esquerda, clique no ícone de extensões (ou use o atalho `Ctrl+Shift+X`).
- Pesquise por "PHP" na barra de pesquisa.
- Instale a extensão chamada "PHP" oferecida pela editora "Felix Becker" ou outra de sua preferência.

### 2. Configuração do ambiente PHP

- Certifique-se de que o PHP está instalado e configurado corretamente no seu sistema (o WampServer já inclui o PHP).
- Abra as configurações do VS Code (`Ctrl+,`) e pesquise por "PHP".
- Configure o caminho do executável PHP para apontar para a instalação do PHP no WAMP (geralmente em `C:\wamp\bin\php\phpX.Y.Z`).

### 3. Comece a codificar em PHP

- Crie ou abra um projeto no VS Code.
- Crie arquivos `.php` e comece a codificar.
- Utilize recursos como sugestões de código, depuração, snippets e outras funcionalidades oferecidas pela extensão PHP.

## Conclusão

Com o WampServer instalado e o Visual Studio Code configurado para PHP, você pode desenvolver e testar aplicativos web PHP localmente em um ambiente de desenvolvimento.

Lembre-se de consultar a documentação oficial do WampServer e da extensão PHP para mais detalhes e suporte.

[Documentação WampServer](https://www.wampserver.com/en/documentation.php)
[Extensão PHP para VS Code](https://marketplace.visualstudio.com/items?itemName=felixfbecker.php)

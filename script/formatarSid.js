function formatarSid(input) {
    // Remove qualquer caractere não numérico
    var valor = input.value.replace(/\D/g, '');

    // Verifica se o valor tem mais de 2 caracteres, que é o ponto onde colocaremos o primeiro ponto
    if (valor.length > 2) {
        valor = valor.substring(0, 2) + '.' + valor.substring(2);
    }

    // Verifica se o valor tem mais de 6 caracteres, que é onde colocaremos o segundo ponto
    if (valor.length > 6) {
        valor = valor.substring(0, 6) + '.' + valor.substring(6);
    }

    // Verifica se o valor tem mais de 10 caracteres, que é onde colocaremos o traço
    if (valor.length > 10) {
        valor = valor.substring(0, 10) + '-' + valor.substring(10);
    }

    // Define o valor formatado de volta no campo
    input.value = valor;
}





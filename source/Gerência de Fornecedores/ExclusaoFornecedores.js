function validarCNPJ(event) {
	var cnpj = document.querySelector("#campoCNPJValidacao").value;
	// Recebe o CNPJ digitado no textbox.
	
	cnpj = cnpj.replace(/[^\d]+/g, '');
	// Retira qualquer pontuação, deixando apenas números.
 
    if (cnpj == '') {
		// Valida CNPJ vazio.
		alert("CNPJ falso!");
		return false;
	}
    else if (cnpj.length != 14) {
		// Valida CNPJ maior do que pode ser.
        alert("CNPJ falso!");
		return false;
	}
	else if (cnpj == "00000000000000" || cnpj == "11111111111111" ||
        cnpj == "22222222222222" || cnpj == "33333333333333" ||
        cnpj == "44444444444444" || cnpj == "55555555555555" ||
        cnpj == "66666666666666" || cnpj == "77777777777777" ||
        cnpj == "88888888888888" || cnpj == "99999999999999") {
			
		// Valida CNPJs falsos mas que passariam pela validação.
        alert("CNPJ falso!");
		return false;
	}
	
    var tamanho = cnpj.length - 2
    var numeros = cnpj.substring(0, tamanho);
    var digitos = cnpj.substring(tamanho);
    var soma = 0;
    var pos = tamanho - 7;
    
    for (var i = tamanho; i >= 1; i--) {
		soma += numeros.charAt(tamanho - i) * pos--;
		if (pos < 2) {
			pos = 9;
		}
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(0)) {
        alert("CNPJ falso!");
		return false;
	}
         
    tamanho = tamanho + 1;
    numeros = cnpj.substring(0, tamanho);
    soma = 0;
    pos = tamanho - 7;
    
    for (i = tamanho; i >= 1; i--) {
		soma += numeros.charAt(tamanho - i) * pos--;
		if (pos < 2) {
			pos = 9;
		}
    }
    
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(1)) {
		alert("CNPJ falso!");
		return false;
	}
     
    alert("CNPJ verdadeiro!");
	return true;
};

var botaoExcluir = document.querySelector("#botaoExcluir");

botaoExcluir.onclick = function() {
	var cnpj = document.querySelector("#campoCNPJValidacao").innerHTML;
	
	cnpj = cnpj.replace(/[^\d]+/g, '');
 
    if (cnpj == '') {
		alert("CNPJ falso!");
	}
    else if (cnpj.length != 14) {
        alert("CNPJ falso!");
	}
	else if (cnpj == "00000000000000" || cnpj == "11111111111111" ||
        cnpj == "22222222222222" || cnpj == "33333333333333" ||
        cnpj == "44444444444444" || cnpj == "55555555555555" ||
        cnpj == "66666666666666" || cnpj == "77777777777777" ||
        cnpj == "88888888888888" || cnpj == "99999999999999") {
        alert("CNPJ falso!");
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
	}
           
    alert("CNPJ verdadeiro!");
};

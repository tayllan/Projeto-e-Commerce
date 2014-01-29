var emptyRule = {
    type: "empty",  
    prompt: "O campo não pode estar vazio!"
};

var emailRule = {
    type: "email",
    prompt: "Insira um e-mail válido."
};

var twoCharacterRule = {
    type: "length[2]",
    prompt: "O campo deve possuir ao menos 2 caracteres."
};

var fiveCharacterRule = {
    type: "length[5]",
    prompt: "O campo deve possuir ao menos 5 caracteres."
};

var eightCharacterRule = {
    type: "length[8]",
    prompt: "O campo deve conter 8 dígitos (sem nenhuma pontuação)."
};

var elevenCharacterRule = {
    type: "length[11]",
    prompt: "O campo deve possuir 11 dígitos (sem nenhuma pontuação)."
};

function validarSenha() {
    var senha = document.querySelector("[name=usuario_senha]");
    var confirmarSenha = document.querySelector("[name=confirmarSenha]");
    var confirmarSenhaError = document.querySelector("#confirmarSenhaError");
    var confirmarSenhaDiv = document.querySelector("#confirmarSenha");
    
    if (senha.value === confirmarSenha.value) {
        confirmarSenhaError.className = '';
        confirmarSenhaDiv.className = 'ui left labeled icon input field';
        
        return true;
    }
    else {
        confirmarSenhaError.className = 'ui red pointing prompt label transition visible';
        confirmarSenhaDiv.className += ' error'
        
        return false;
    }
};

function confirmarDelecao() {
    var resultado = confirm("Deseja mesmo deletar ?");
    
    if (resultado) {
        return true;
    }
    else {
        return false;
    }
};
<?php

function construirFormulario($usuario) {
    $generoSexualController = new GeneroSexualController();
    $unidadeFederativaController = new UnidadeFederativaController();
    $conteudo = '<form class="ui form" action="realizarCadastroView.php" 
            method="POST" onsubmit="return validarSenha()">
	<fieldset class="ui form segment">
            <legend>Informações Gerais:</legend>
		
            <div>
                <label>E-Mail</label>
                <div class="ui left labeled icon input field">
                    <input type="text" placeholder="E-Mail" name="' . Colunas::USUARIO_LOGIN . '"
                        value="' . $usuario->login . '">
                    <i class="mail icon"></i>
                    <div class="ui red corner label">
                        <i class="icon asterisk"></i>
                    </div>
                </div>
            </div>
            
            <div>
                <label>Senha</label>
                <div class="ui left labeled icon input field">
                    <input type="password" name="' . Colunas::USUARIO_SENHA . '"
                        value="' . $usuario->senha . '">
                    <i class="lock icon"></i>
                    <div class="ui red corner label">
                        <i class="icon asterisk"></i>
                    </div>
                </div>
            </div>
            
            <div>
                <label>Confirmar Senha</label>
                <div id="confirmarSenha" class="ui left labeled icon input field">
                    <input type="password" name="confirmarSenha" value="' . $usuario->senha . '">
                    <i class="lock icon"></i>
                    <div class="ui red corner label">
                        <i class="icon asterisk"></i>
                    </div>
                </div>
            </div>
            
            <div id="confirmarSenhaError" hidden>
                O campo Confirmar Senha deve ser igual ao campo Senha.
            </div>
	</fieldset>
	
	<fieldset class="ui form segment">
            <legend>Informações Pessoais:</legend>
		
            <div>
                <label>Nome Completo</label>
                <div class="ui left labeled icon input field">
                    <input type="text" name="' . Colunas::USUARIO_NOME . '"
                        value="' . $usuario->nome . '">
                    <i class="user icon"></i>
                    <div class="ui red corner label">
                        <i class="icon asterisk"></i>
                    </div>
                </div>
            </div>
            
            <div>
                <label>CPF</label>
                <div class="ui left labeled icon input field">
                    <input type="text" name="' . Colunas::USUARIO_CPF . '" maxlength="11"
                        value="' . $usuario->cpf . '">
                    <i class=" icon"></i>
                    <div class="ui red corner label">
                        <i class="icon asterisk"></i>
                    </div>
                </div>
            </div>
            
            <div>
                <label>Telefone</label>
                <div class="ui left labeled icon input field">
                    <input type="tel" name="' . Colunas::USUARIO_TELEFONE . '"
                        value="' . $usuario->telefone . '">
                    <i class="phone icon"></i>
                    <div class="ui red corner label">
                        <i class="icon asterisk"></i>
                    </div>
                </div>
            </div>
            
            <div>
                <label>Data de Nascimento</label>
                <div class="ui left labeled icon input field">
                    <input type="date" name="' . Colunas::USUARIO_DATA_DE_NASCIMENTO . '"
                        value="' . $usuario->dataDeNascimento . '">
                    <i class="calendar icon"></i>
                    <div class="ui red corner label">
                        <i class="icon asterisk"></i>
                    </div>
                </div>
            </div>
		
            <div class="ui segment">
                <i class="female icon"></i>
                /
                <i class="male icon"></i>
                <label>Gênero Sexual</label>
                <select name="' . Colunas::USUARIO_FK_GENERO_SEXUAL . '" size="1">';
    $arrayGeneroSexual = $generoSexualController->listar(Colunas::GENERO_SEXUAL);
    foreach ($arrayGeneroSexual as $linha) {
        if ($linha[Colunas::GENERO_SEXUAL_NOME] != 'GENERO_SEXUAL_ANONIMO') {
            $conteudo .= '<option value="' . $linha[Colunas::GENERO_SEXUAL_ID] . '" ';
                    
            if ($linha[Colunas::GENERO_SEXUAL_ID] == $usuario->generoSexual->id) {
                 $conteudo .= 'selected';
            }
            $conteudo .= '>' . $linha[Colunas::GENERO_SEXUAL_NOME] . '</option>';
        }
    }
    $conteudo .= '</select>
                <div class="ui red corner label">
                    <i class="icon asterisk"></i>
                </div>
            </div>
	</fieldset>
	
	<fieldset class="ui form segment">
            <legend>Informações de Endereço:</legend>
		
            <div>
                <label>CEP</label>
                <div class="ui left labeled icon input field">
                    <input type="text" name="' . Colunas::ENDERECO_CEP . '" maxlength="8"
                        value="' . $usuario->endereco->cep . '">
                    <i class="map icon"></i>
                    <div class="ui red corner label">
                        <i class="icon asterisk"></i>
                    </div>
                </div>
            </div>
		
            <div>
                <label>Rua</label>
                <div class="ui left labeled icon input field">
                    <input type="text" name="' . Colunas::ENDERECO_RUA . '"
                        value="' . $usuario->endereco->rua . '">
                    <i class="map icon"></i>
                    <div class="ui red corner label">
                        <i class="icon asterisk"></i>
                    </div>
                </div>
            </div>
		
            <div>
                <label>Numero</label>
                <div class="ui left labeled icon input field">
                    <input type="number" name="' . Colunas::ENDERECO_NUMERO . '"
                        value="' . $usuario->endereco->numero . '">
                    <i class="map icon"></i>
                    <div class="ui red corner label">
                        <i class="icon asterisk"></i>
                    </div>
                </div>
            </div>
		
            <div>
                <label>Bairro</label>
                <div class="ui left labeled icon input field">
                    <input type="text" name="' . Colunas::ENDERECO_BAIRRO . '"
                        value="' . $usuario->endereco->bairro . '">
                    <i class="map icon"></i>
                    <div class="ui red corner label">
                        <i class="icon asterisk"></i>
                    </div>
                </div>
            </div>
	
            <div>
                <label>Cidade</label>
                <div class="ui left labeled icon input field">
                    <input type="text" name="' . Colunas::CIDADE_NOME . '"
                        value="' . $usuario->endereco->cidade->nome . '">
                    <i class="map icon"></i>
                    <div class="ui red corner label">
                        <i class="icon asterisk"></i>
                    </div>
                </div>
            </div>
                
            <div class="ui segment">
                <i class="map icon"></i>
                <label>Unidade Federativa</label>
                <select name="' . Colunas::CIDADE_FK_UNIDADE_FEDERATIVA . '" size="1">';
    $arrayUnidadeFederativa = $unidadeFederativaController->listar(Colunas::UNIDADE_FEDERATIVA);
    foreach ($arrayUnidadeFederativa as $linha) {
        if ($linha[Colunas::UNIDADE_FEDERATIVA_NOME] != 'UNIDADE_FEDERATIVA_ANONIMA') {
            $conteudo .= '<option value="' . $linha[Colunas::UNIDADE_FEDERATIVA_ID] . '"';
            if ($linha[Colunas::UNIDADE_FEDERATIVA_ID] == $usuario->endereco->cidade->unidadeFederativa->id) {
                $conteudo .= 'selected';
            }
            $conteudo .= '>' . $linha[Colunas::UNIDADE_FEDERATIVA_NOME] . ' - '
                . $linha[Colunas::UNIDADE_FEDERATIVA_SIGLA] . '</option>';
        }
    }
    $conteudo .= '</select>
                <div class="ui red corner label">
                    <i class="icon asterisk"></i>
                </div>
            </div>
	</fieldset>
        
        <div>
            <button type="submit" name="submeter" class="ui black submit button small">
                <i class="signup icon"></i>
                Reperar Conta
            </button>
        </div>
        
        <div hidden>
            <input type="hidden" name="' . Colunas::USUARIO_ID . '" value="' . $usuario->id . '">
        </div>
</form>
<script>
$(\'.ui.form\').form(
    {
        email: {
            identifier: "' . Colunas::USUARIO_LOGIN . '",
            rules: [
                emailRule
          ]
        },
        senha: {
            identifier: "' . Colunas::USUARIO_SENHA . '",
            rules: [
                fiveCharacterRule
          ]
        },
        nomaCompleto: {
            identifier: "' . Colunas::USUARIO_NOME . '",
            rules: [
                emptyRule
          ]
        },
        cpf: {
            identifier: "' . Colunas::USUARIO_CPF . '",
            rules: [
                elevenCharacterRule
          ]
        },
        telefone: {
            identifier: "' . Colunas::USUARIO_TELEFONE . '",
            rules: [
                emptyRule
          ]
        },
        dataDeNascimento: {
            identifier: "' . Colunas::USUARIO_DATA_DE_NASCIMENTO . '",
            rules: [
                emptyRule
          ]
        },
        cep: {
            identifier: "' . Colunas::ENDERECO_CEP . '",
            rules: [
                eightCharacterRule
          ]
        },
        rua: {
            identifier: "' . Colunas::ENDERECO_RUA . '",
            rules: [
                emptyRule
          ]
        },
        numero: {
            identifier: "' . Colunas::ENDERECO_NUMERO . '",
            rules: [
                emptyRule
          ]
        },
        bairro: {
            identifier: "' . Colunas::ENDERECO_BAIRRO . '",
            rules: [
                emptyRule
          ]
        },
        cidade: {
            identifier: "' . Colunas::CIDADE_NOME . '",
            rules: [
                emptyRule
          ]
        }
    },
    {
        inline: true
    }
);
</script>';

    return $conteudo;
}

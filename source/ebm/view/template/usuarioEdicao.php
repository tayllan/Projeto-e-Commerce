<?php

function construirFormulario($usuario) {
    $generoSexualController = new GeneroSexualController();
    $unidadeFederativaController = new UnidadeFederativaController();
    $conteudo = '<form class="ui form segment" action="usuarioView.php" method="POST">
	<fieldset class="ui form segment">
            <legend>Informações Gerais:</legend>
		
            <div>
                <label>E-Mail</label>
                <div class="ui left labeled icon input">
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
                <div class="ui left labeled icon input">
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
                <div class="ui left labeled icon input">
                    <input type="password" name="confirmarSenha"
                        value="' . $usuario->senha . '">
                    <i class="lock icon"></i>
                    <div class="ui red corner label">
                        <i class="icon asterisk"></i>
                    </div>
                </div>
            </div>
            
            <div class="ui segment">
                <i class="icon"></i>
                <label>Administrador ?</label>
                <select size="1" name="' . Colunas::USUARIO_ADMINISTRADOR . '">';
    if ($usuario->administrador) {
        $conteudo .= '<option value="true" selected>SIM</option>
                    <option value="false">NÃO</option>';
    }
    else {
        $conteudo .= '<option value="true">SIM</option>
                    <option value="false" selected>NÃO</option>';
    }

    $conteudo .= '</select>
                <div class="ui red corner label">
                    <i class="icon asterisk"></i>
                </div>
            </div>
	</fieldset>
	
	<fieldset class="ui form segment">
            <legend>Informações Pessoais:</legend>
		
            <div>
                <label>Nome Completo</label>
                <div class="ui left labeled icon input">
                    <input type="text" name="' . Colunas::USUARIO_NOME . '" value="' . $usuario->nome . '">
                    <i class="user icon"></i>
                    <div class="ui red corner label">
                        <i class="icon asterisk"></i>
                    </div>
                </div>
            </div>
            
            <div>
                <label>CPF</label>
                <div class="ui left labeled icon input">
                    <input type="text" name="' . Colunas::USUARIO_CPF . '" maxlength="11"
                        value="' . $usuario->cpf . '">
                    <div class="ui red corner label">
                        <i class="icon asterisk"></i>
                    </div>
                </div>
            </div>
            
            <div>
                <label>Telefone</label>
                <div class="ui left labeled icon input">
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
                <div class="ui left labeled icon input">
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
            $conteudo .= '<option value="' . $linha[Colunas::GENERO_SEXUAL_ID]
                . '">' . $linha[Colunas::GENERO_SEXUAL_NOME] . '</option>';
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
                <div class="ui left labeled icon input">
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
                <div class="ui left labeled icon input">
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
                <div class="ui left labeled icon input">
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
                <div class="ui left labeled icon input">
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
                <div class="ui left labeled icon input">
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
            $conteudo .= '<option value="' . $linha[Colunas::UNIDADE_FEDERATIVA_ID]
                . '">' . $linha[Colunas::UNIDADE_FEDERATIVA_NOME] . ' - '
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
            <br>
            <input type="submit" name="submeter" value="Salvar" class="ui black submit button small">
        </div>
        
        <div hidden>
            <input type="hidden" name="' . Colunas::USUARIO_ID . '" value="' . $usuario->id . '">
        </div>
</form>';

    return $conteudo;
}

function ajustarPermissao($administrador) {
    if ($administrador) {
        return 'SIM';
    }
    else {
        return 'NÃO';
    }
}

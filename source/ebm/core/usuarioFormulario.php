<?php

function construirFormulario($usuario) {
    $conteudo = '<form>
	<fieldset>
		<legend>Informações Gerais:</legend>
		
		<div>
			<label for="email">E-Mail:</label>
			<input type="email" id="email" name="' . Colunas::USUARIO_LOGIN . '" value="'
        . $usuario->login . '">
		</div>
		
		<div>
			<label for="senha">Senha:</label>
			<input type="password" id="senha" name="' . Colunas::USUARIO_SENHA . '" value="'
        . $usuario->senha . '">
		</div>
	</fieldset>
	
	<fieldset>
		<legend>Informações Pessoais:</legend>
		
		<div>
			<label for="nome">Nome Completo:</label>
			<input type="text" id="nome" name="' . Colunas::USUARIO_NOME . '" value="'
        . $usuario->nome . '">
		</div>
		
		<div>
			<label for="cpf">CPF:</label>
			<input type="text" id="cpf" name="' . Colunas::USUARIO_CPF . '" value="'
        . $usuario->cpf . '">
		</div>
		
		<div>
			<label for="telefone">Telefone:</label>
			<input type="tel" id="telefone" name="' . Colunas::USUARIO_TELEFONE . '" value="'
        . $usuario->telefone . '">
		</div>
		
		<div>
			<label for="nascimento">Data de Nascimento:</label>
			<input type="date" id="nascimento" name="' . Colunas::USUARIO_DATA_DE_NASCIMENTO
        . '" value="' . $usuario->dataDeNascimento . '">
		</div>
		
		<div>
			<label for="genero">Gênero Sexual:</label>
			<select id="genero" name="' . Colunas::USUARIO_FK_GENERO_SEXUAL . '">
				<option value="feminino">Feminino</option>
				<option value="masculino">Masculino</option>
				<option value="outro">Outro</option>
			</select>
		</div>
	</fieldset>
	
	<fieldset>
		<legend>Informações de Endereço:</legend>
		
		<div>
			<label for="cep">CEP:</label>
			<input type="text" id="cep" name="' . Colunas::ENDERECO_CEP . '" value="'
        . $usuario->endereco->cep . '">
		</div>
		
		<div>
			<label for="rua">Rua:</label>
			<input type="text" id="rua" name="' . Colunas::ENDERECO_RUA . '" value="'
        . $usuario->endereco->rua . '">
		</div>
		
		<div>
			<label for="numero">Número:</label>
			<input type="number" id="numero" name="' . Colunas::ENDERECO_NUMERO . '" value="'
        . $usuario->endereco->numero . '">
		</div>
		
		<div>
			<label for="bairro">Bairro:</label>
			<input type="text" id="bairro" name="' . Colunas::ENDERECO_BAIRRO . '" value="'
        . $usuario->endereco->bairro . '">
		</div>
		
		<div>
			<label for="cidade">Cidade:</label>
			<input type="text" id="cidade" name="' . Colunas::CIDADE_NOME . '" value="'
        . $usuario->endereco->cidade->nome . '">
		</div>
		
		<div>
			<label for="unidadeFederativa">Unidade Federativa (sigla):</label>
			<input type="text" id="unidadeFederativa" name="' . Colunas::UNIDADE_FEDERATIVA_NOME
        . '" value="' . $usuario->endereco->cidade->unidadeFederativa->nome . '" maxlength="2" size="2">
		</div>
	</fieldset>
</form>';
    
    return $conteudo;
}
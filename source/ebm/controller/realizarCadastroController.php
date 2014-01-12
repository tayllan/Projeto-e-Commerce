<?php

require_once '../config.php';
require_once ROOT . 'controller/unidadeFederativaController.php';
require_once ROOT . 'controller/cidadeController.php';
require_once ROOT . 'controller/enderecoController.php';
require_once ROOT . 'controller/usuarioController.php';
require_once ROOT . 'controller/generoSexualController.php';

class RealizarCadastroController {

    private $unidadeFederativaController;
    private $cidadeController;
    private $enderecoController;
    private $usuarioController;
    private $generoSexualController;
    
    public function __construct() {
        $this->unidadeFederativaController = new UnidadeFederativaController();
        $this->cidadeController = new CidadeController();
        $this->enderecoController = new EnderecoController();
        $this->usuarioController = new UsuarioController();
        $this->generoSexualController = new GeneroSexualController();
    }

    public function inserir() {
        $unidadeFederativa = new UnidadeFederativa(
            NULL, $_POST[Colunas::UNIDADE_FEDERATIVA_NOME],
            $_POST[Colunas::UNIDADE_FEDERATIVA_SIGLA], Regiao::getNullObject()
        );
        $cidade = new Cidade(
            NULL, $_POST[Colunas::CIDADE_NOME],
            $unidadeFederativa
        );
        $endereco = new Endereco(
            NULL, $_POST[Colunas::ENDERECO_BAIRRO],
            $_POST[Colunas::ENDERECO_CEP], $_POST[Colunas::ENDERECO_RUA],
            $_POST[Colunas::ENDERECO_NUMERO], $cidade
        );
        $generoSexual = new GeneroSexual(
            NULL, $_POST[Colunas::USUARIO_FK_GENERO_SEXUAL]
        );
        $usuario = new Usuario(
            NULL, $_POST[Colunas::USUARIO_NOME],
            $_POST[Colunas::USUARIO_LOGIN], $_POST[Colunas::USUARIO_SENHA],
            $_POST[Colunas::USUARIO_CPF], $_POST[Colunas::USUARIO_TELEFONE],
            $_POST[Colunas::USUARIO_DATA_DE_NASCIMENTO], FALSE,
            $endereco, $generoSexual
        );
        
        $this->unidadeFederativaController->rotearInsercao($unidadeFederativa);
        $this->cidadeController->rotearInsercao($cidade);
        $this->enderecoController->rotearInsercao($endereco);
        $this->generoSexualController->rotearInsercao($generoSexual);
        $this->usuarioController->rotearInsercao($usuario);
    }

    public function construirFormulario($usuario) {
        $conteudo = '<form action="realizarCadastroView.php" method="POST">
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
			<label for="unidadeFederativa">Unidade Federativa:</label>
			<input type="text" id="unidadeFederativa" name="' . Colunas::UNIDADE_FEDERATIVA_NOME
            . '" value="' . $usuario->endereco->cidade->unidadeFederativa->nome . '">
		</div>
		
		<div>
			<label for="ufSigla">Unidade Federativa (sigla):</label>
			<input type="text" id="ufSigla" name="' . Colunas::UNIDADE_FEDERATIVA_SIGLA
            . '" value="' . $usuario->endereco->cidade->unidadeFederativa->sigla . '" maxlength="2" size="2">
		</div>
	</fieldset>
        
        <div>
            <input type="submit" name="submeter" value="Cadastrar">
        </div>
</form>';

        return $conteudo;
    }

}

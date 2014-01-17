<?php

require_once '../config.php';
require_once DIR_ROOT . 'controller/unidadeFederativaController.php';
require_once DIR_ROOT . 'controller/cidadeController.php';
require_once DIR_ROOT . 'controller/enderecoController.php';
require_once DIR_ROOT . 'controller/usuarioController.php';
require_once DIR_ROOT . 'controller/generoSexualController.php';

class RealizarCadastroController {

    private $regiaoController;
    private $unidadeFederativaController;
    private $cidadeController;
    private $enderecoController;
    private $usuarioController;
    private $generoSexualController;
    
    public function __construct() {
        $this->regiaoController = new RegiaoController();
        $this->unidadeFederativaController = new UnidadeFederativaController();
        $this->cidadeController = new CidadeController();
        $this->enderecoController = new EnderecoController();
        $this->usuarioController = new UsuarioController();
        $this->generoSexualController = new GeneroSexualController();
    }

    public function inserir() {
        $regiao = $this->construirObjetoRegiao();
        $unidadeFederativa = $this->construirObjetoUnidadeFederativa($regiao);
        $cidade = $this->construirObjetoCidade($unidadeFederativa);
        $endereco = $this->construirObjetoEndereco($cidade);
        $generoSexual = $this->construirObjetoGeneroSexual();
        $usuario = $this->construirObjetoUsuario($endereco, $generoSexual);
        
        return true;
    }
    
    private function construirObjetoRegiao() {
        $regiao = new Regiao(
            NULL, $_POST[Colunas::REGIAO_NOME]
        );
        $this->regiaoController->rotearInsercao($regiao);
        $array = $this->regiaoController->getId($regiao);
        $regiao->id = $array[Colunas::REGIAO_ID];
        
        return $regiao;
    }
    
    private function construirObjetoUnidadeFederativa($regiao) {
        $unidadeFederativa = new UnidadeFederativa(
            NULL, $_POST[Colunas::UNIDADE_FEDERATIVA_NOME],
            $_POST[Colunas::UNIDADE_FEDERATIVA_SIGLA], $regiao
        );
        $this->unidadeFederativaController->rotearInsercao($unidadeFederativa);
        $array = $this->unidadeFederativaController->getId($unidadeFederativa);
        $unidadeFederativa->id = $array[Colunas::UNIDADE_FEDERATIVA_ID];
        
        return $unidadeFederativa;
    }
    
    private function construirObjetoCidade($unidadeFederativa) {
        $cidade = new Cidade(
            NULL, $_POST[Colunas::CIDADE_NOME],
            $unidadeFederativa
        );
        $this->cidadeController->rotearInsercao($cidade);
        $array = $this->cidadeController->getId($cidade);
        $cidade->id = $array[Colunas::CIDADE_ID];
        
        return $cidade;
    }
    
    private function construirObjetoEndereco($cidade) {
        $endereco = new Endereco(
            NULL, $_POST[Colunas::ENDERECO_BAIRRO],
            $_POST[Colunas::ENDERECO_CEP], $_POST[Colunas::ENDERECO_RUA],
            $_POST[Colunas::ENDERECO_NUMERO], $cidade
        );
        $this->enderecoController->rotearInsercao($endereco);
        $array = $this->enderecoController->getId($endereco);
        $endereco->id = $array[Colunas::ENDERECO_ID];
        
        return $endereco;
    }
    
    private function construirObjetoGeneroSexual() {
        $generoSexual = new GeneroSexual(
            NULL, $_POST[Colunas::GENERO_SEXUAL_NOME]
        );
        $this->generoSexualController->rotearInsercao($generoSexual);
        $array = $this->generoSexualController->getId($generoSexual);
        $generoSexual->id = $array[Colunas::GENERO_SEXUAL_ID];
        
        return $generoSexual;
    }
    
    private function construirObjetoUsuario($endereco, $generoSexual) {
        $usuario = new Usuario(
            NULL, $_POST[Colunas::USUARIO_NOME],
            $_POST[Colunas::USUARIO_LOGIN], $_POST[Colunas::USUARIO_SENHA],
            $_POST[Colunas::USUARIO_CPF], $_POST[Colunas::USUARIO_TELEFONE],
            $_POST[Colunas::USUARIO_DATA_DE_NASCIMENTO], FALSE,
            $endereco, $generoSexual
        );
        
        /*
         * TODO: Tá dando algum erro nas próximas linhas.
         */
        $this->usuarioController->rotearInsercao($usuario);
        $array = $this->usuarioController->getId($usuario);
        $usuario->id = $array[Colunas::USUARIO_ID];
        
        return $usuario;
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
			<select id="genero" name="' . Colunas::GENERO_SEXUAL_NOME . '">
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
                
                <div>
			<label for="regiao">Região:</label>
			<input type="text" id="regiao" name="' . Colunas::REGIAO_NOME . '"'
            . 'value="' . $usuario->endereco->cidade->unidadeFederativa->regiao->nome . '">
		</div>
	</fieldset>
        
        <div>
            <input type="submit" name="submeter" value="Cadastrar">
        </div>
</form>';

        return $conteudo;
    }

}

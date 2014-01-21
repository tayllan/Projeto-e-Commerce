<?php

require_once '../config.php';
require_once DIR_ROOT . 'controller/unidadeFederativaController.php';
require_once DIR_ROOT . 'controller/cidadeController.php';
require_once DIR_ROOT . 'controller/enderecoController.php';
require_once DIR_ROOT . 'controller/usuarioController.php';
require_once DIR_ROOT . 'controller/generoSexualController.php';

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
        $unidadeFederativa = $this->construirObjetoUnidadeFederativa();
        $cidade = $this->construirObjetoCidade($unidadeFederativa);
        $endereco = $this->construirObjetoEndereco($cidade);
        $generoSexual = $this->construirObjetoGeneroSexual();
        $trueFalse = $this->construirObjetoUsuario($endereco, $generoSexual);
        
        return $trueFalse;
    }
    
    private function construirObjetoUnidadeFederativa() {
        $unidadeFederativa = $this->unidadeFederativaController->construirObjetoPorId(
            $_POST[Colunas::CIDADE_FK_UNIDADE_FEDERATIVA]
        );
        
        return $unidadeFederativa;
    }
    
    private function construirObjetoCidade($unidadeFederativa) {
        $cidade = new Cidade(
            NULL, $_POST[Colunas::CIDADE_NOME], $unidadeFederativa
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
        $generoSexual = $this->generoSexualController->construirObjetoPorId(
            $_POST[Colunas::USUARIO_FK_GENERO_SEXUAL]
        );
        
        return $generoSexual;
    }
    
    private function construirObjetoUsuario($endereco, $generoSexual) {
        $usuario = new Usuario(
            NULL, $_POST[Colunas::USUARIO_NOME],
            $_POST[Colunas::USUARIO_LOGIN], $_POST[Colunas::USUARIO_SENHA],
            $_POST[Colunas::USUARIO_CPF], $_POST[Colunas::USUARIO_TELEFONE],
            $_POST[Colunas::USUARIO_DATA_DE_NASCIMENTO], 'false',
            $endereco, $generoSexual
        );
        
        $trueFalse = $this->usuarioController->rotearInsercao($usuario);
        
        return $trueFalse;
    }

    public function construirFormulario() {
        $conteudo = '<form action="realizarCadastroView.php" method="POST">
	<fieldset>
            <legend>Informações Gerais:</legend>
		
            <div>
                <label for="email">E-Mail:</label>
		<input type="email" id="email" name="' . Colunas::USUARIO_LOGIN . '">
            </div>
		
            <div>
                <label for="senha">Senha:</label>
		<input type="password" id="senha" name="' . Colunas::USUARIO_SENHA . '">
            </div>
                
            <div>
                <label for="senhaDois">Confirmar Senha:</label>
		<input type="password" id="senhaDois" name="confirmarSenha">
            </div>
	</fieldset>
	
	<fieldset>
            <legend>Informações Pessoais:</legend>
		
            <div>
		<label for="nome">Nome Completo:</label>
		<input type="text" id="nome" name="' . Colunas::USUARIO_NOME . '">
            </div>
		
            <div>
		<label for="cpf">CPF:</label>
		<input type="text" id="cpf" name="' . Colunas::USUARIO_CPF . '" maxlength="11" size="11">
            </div>
		
            <div>
            	<label for="telefone">Telefone:</label>
		<input type="tel" id="telefone" name="' . Colunas::USUARIO_TELEFONE . '">
            </div>
		
            <div>
		<label for="nascimento">Data de Nascimento:</label>
		<input type="date" id="nascimento" name="' . Colunas::USUARIO_DATA_DE_NASCIMENTO . '">
            </div>
		
            <div>
                <label for="generoSexual">Gênero Sexual:</label>
                <select id="generoSexual" name="' . Colunas::USUARIO_FK_GENERO_SEXUAL . '" size="1">';
        $arrayGenero = $this->generoSexualController->listar(Colunas::GENERO_SEXUAL);
        foreach ($arrayGenero as $linha) {
            $conteudo .= '<option value="' . $linha[Colunas::GENERO_SEXUAL_ID]
                . '">' . $linha[Colunas::GENERO_SEXUAL_NOME] . '</option>';
        }
        $conteudo .= '</select>
                </div>
	</fieldset>
	
	<fieldset>
            <legend>Informações de Endereço:</legend>
		
            <div>
                <label for="cep">CEP:</label>
		<input type="text" id="cep" name="' . Colunas::ENDERECO_CEP . '" maxlength="8" size="8">
            </div>
		
            <div>
		<label for="rua">Rua:</label>
		<input type="text" id="rua" name="' . Colunas::ENDERECO_RUA . '">
            </div>
		
            <div>
		<label for="numero">Número:</label>
		<input type="number" id="numero" name="' . Colunas::ENDERECO_NUMERO . '">
            </div>
		
            <div>
            	<label for="bairro">Bairro:</label>
		<input type="text" id="bairro" name="' . Colunas::ENDERECO_BAIRRO . '">
            </div>
	
            <div>
		<label for="cidade">Cidade:</label>
		<input type="text" id="cidade" name="' . Colunas::CIDADE_NOME . '">
            </div>
                
            <div>
                <label for="unidadeFederativa">Unidade Federativa:</label>
                <select id="unidadeFederativa" name="' . Colunas::CIDADE_FK_UNIDADE_FEDERATIVA . '" size="1">';
        $array = $this->unidadeFederativaController->listar(Colunas::UNIDADE_FEDERATIVA);
        foreach ($array as $linha) {
            $conteudo .= '<option value="' . $linha[Colunas::UNIDADE_FEDERATIVA_ID]
                . '">' . $linha[Colunas::UNIDADE_FEDERATIVA_NOME] . ' - '
                . $linha[Colunas::UNIDADE_FEDERATIVA_SIGLA] . '</option>';
        }
        $conteudo .= '</select>
                </div>
	</fieldset>
        
        <div>
            <input type="submit" name="submeter" value="Cadastrar">
        </div>
</form>';

        return $conteudo;
    }

}

<?php

require_once '../config.php';
require_once DIR_ROOT . 'controller/usuarioController.php';
require_once DIR_ROOT . 'view/template/html.php';

class Login {
    
    private $controller;
    private $usuario;
    
    public function __construct() {
        $this->controller = new UsuarioController();
        $this->rotear();
    }

    private function rotear() {
        if (isset($_POST[Colunas::USUARIO_LOGIN])) {
            $this->validarLoginComPermissao();
        }
        if (isset($_POST['erro'])) {
            $this->exibirConteudo(
                '<div id="mensagem"><strong>Login e/ou Senha inválidos</strong></div><br>'
                . $this->construirFormulario()
            );
        }
        else if (isset($_POST['logout'])) {
            $this->realizarLogout();
            header('Location: ../index.php');
        }
        else {
            $this->exibirConteudo($this->construirFormulario());
        }
    }
    
    private function realizarLogin($id, $login) {
        $_SESSION[SESSAO_LOGADO] = true;
        $_SESSION[SESSAO_USUARIO_ID] = $id;
        $_SESSION[SESSAO_USUARIO_LOGIN] = $login;
    }
    
    private function realizarLogout() {
        $_SESSION[SESSAO_LOGADO] = NULL;
        $_SESSION[SESSAO_USUARIO_ID] = NULL;
        $_SESSION[SESSAO_USUARIO_LOGIN] = NULL;
        $_SESSION[SESSAO_USUARIO_PERMISSAO] = NULL;
        echo 'aqui';
    }

    private function testarLogin() {
        if (isset($_SESSION['logado'])) {
            return true;
        }
        else {
            return false;
        }
    }
    
    private function validarLoginComPermissao() {
        if ($this->validarLogin()) {
            $this->realizarLogin(
                $_POST[Colunas::USUARIO_ID],
                $_POST[Colunas::USUARIO_LOGIN]
            );
            if ($this->validarPermissao()) {
                $_SESSION[SESSAO_USUARIO_PERMISSAO] = true;
                header('Location: paginaDoAdministrador.php');
            }
            else {
                header('Location: ../index.php');
            }
        }
        else {
            $_POST['erro'] = 'true';
        }
    }
    
    private function validarLogin() {
        $this->usuario = Usuario::getNullObject();
        $this->usuario->login = $_POST[Colunas::USUARIO_LOGIN];
        $this->usuario->senha = $_POST[Colunas::USUARIO_SENHA];
        $array = $this->controller->getId($this->usuario);

        if (!empty($array)) {
            return true;
        }
        else {
            return false;
        }
    }
    
    private function validarPermissao() {
        $array = $this->controller->getId($this->usuario);
        $this->usuario->id = $array[Colunas::USUARIO_ID];
        $array = $this->controller->getById($this->usuario->id);

        if (!empty($array) && $array[Colunas::USUARIO_ADMINISTRADOR]) {
            return true;
        }
        else {
            return false;
        }
    }
    
    private function construirFormulario() {
        $conteudo = '<form action="/core/login.php" method="POST">
    <fieldset>
        <legend>Login:</legend>

        <div>
            <label for="email">E-Mail:</label>
            <input type="text" id="email" name="' . Colunas::USUARIO_LOGIN . '">
        </div>

        <div>
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="' . Colunas::USUARIO_SENHA . '">
        </div>

        <div>
            <input type="submit" name="submeter" value="Logar">
        </div>
    </fieldset>
</form>';
        
        return $conteudo;
    }
    
    private function exibirConteudo($conteudo) {
        cabecalhoHTML('Tela de Login');
        cabecalho('Super Cabeçalho');
        echo $conteudo;
        rodape('Super Rodapé');
        rodapeHTML();
    }

}

new Login();
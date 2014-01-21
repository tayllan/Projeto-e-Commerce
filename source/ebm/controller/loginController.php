<?php

require_once '../config.php';
require_once DIR_ROOT . 'controller/usuarioController.php';
require_once DIR_ROOT . 'view/template/html.php';

class LoginController {

    public static $controller;
    public static $usuario;

    private function __construct() {
        
    }

    public static function realizarLogin($usuario) {
        $_SESSION[SESSAO_LOGADO] = true;
        $_SESSION[SESSAO_USUARIO_ID] = $usuario->id;
        $_SESSION[SESSAO_USUARIO_LOGIN] = $usuario->login;
    }

    public static function realizarLogout() {
        $_SESSION[SESSAO_LOGADO] = NULL;
        $_SESSION[SESSAO_USUARIO_ID] = NULL;
        $_SESSION[SESSAO_USUARIO_LOGIN] = NULL;
        $_SESSION[SESSAO_USUARIO_PERMISSAO] = NULL;
    }

    public static function testarLogin() {
        if (isset($_SESSION[SESSAO_LOGADO])) {
            return true;
        }
        else {
            return false;
        }
    }

    public static function testarLoginAdministrador() {
        if (isset($_SESSION[SESSAO_USUARIO_PERMISSAO])) {
            return true;
        }
        else {
            return false;
        }
    }

    public static function validarLoginComPermissao($usuario) {
        LoginController::$controller = new UsuarioController();
        if (LoginController::validarLogin($usuario)) {
            LoginController::realizarLogin(LoginController::$usuario);
            if (LoginController::validarPermissao()) {
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

    private static function validarLogin($usuario) {
        $array = LoginController::$controller->getId($usuario);

        if (!empty($array)) {
            LoginController::$usuario->id = $array[Colunas::USUARIO_ID];
            return true;
        }
        else {
            return false;
        }
    }

    private static function validarPermissao() {
        $array = LoginController::$controller->getId(LoginController::$usuario);
        LoginController::$usuario->id = $array[Colunas::USUARIO_ID];
        $array = LoginController::$controller->getById(LoginController::$usuario->id);

        if (!empty($array) && $array[Colunas::USUARIO_ADMINISTRADOR]) {
            return true;
        }
        else {
            return false;
        }
    }

    public static function construirFormulario() {
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

    public static function exibirConteudo($conteudo) {
        cabecalhoHTML('Tela de Login');
        cabecalho('Super Cabeçalho');
        echo $conteudo;
        rodape('Super Rodapé');
        rodapeHTML();
    }

}
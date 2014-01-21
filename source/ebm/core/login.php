<?php

require_once '../config.php';
require_once DIR_ROOT . 'controller/usuarioController.php';
require_once DIR_ROOT . 'controller/loginController.php';
require_once DIR_ROOT . 'view/template/html.php';

class Login {

    public function __construct() {
        $this->rotear();
    }

    private function rotear() {
        if (isset($_POST[Colunas::USUARIO_LOGIN])) {
            LoginController::$usuario = Usuario::getNullObject();
            LoginController::$usuario->login = $_POST[Colunas::USUARIO_LOGIN];
            LoginController::$usuario->senha = $_POST[Colunas::USUARIO_SENHA];
            LoginController::validarLoginComPermissao(LoginController::$usuario);
        }
        if (isset($_POST['erro'])) {
            LoginController::exibirConteudo(
                '<p class="erro">Login e/ou Senha inválidos</p><br>'
                . LoginController::construirFormulario()
            );
        }
        else if (isset($_POST['logout'])) {
            LoginController::realizarLogout();
            header('Location: ../index.php');
        }
        else {
            LoginController::exibirConteudo(LoginController::construirFormulario());
        }
    }

}

new Login();

<?php

require_once '../config.php';
#require_once DIR_ROOT . 'core/login.php';
require_once DIR_ROOT . 'view/template/html.php';
require_once DIR_ROOT . 'controller/realizarCadastroController.php';
require_once DIR_ROOT . 'entity/usuarioModel.php';

class RealizarCadastroView {
    
    private $controller;

    public function __construct() {
        $this->controller = new RealizarCadastroController();
        $this->rotear();
    }

    public function rotear() {
        if (isset($_POST[Colunas::USUARIO_NOME])) {
            if ($this->controller->inserir()) {
                echo 'deu certo';
            }
            else {
                echo 'deu ERRADO';
            }
        }
        else {
            $formulario = $this->controller->construirFormulario();
            $this->exibirConteudo($formulario);
        }
    }
    
    public function exibirConteudo($conteudo) {
        cabecalhoHTML('Cadastro de Usuários');
        cabecalho('Super Cabeçalho');
        echo $conteudo;
        rodape('Super Rodapé');
        rodapeHTML();
    }

}

new RealizarCadastroView();

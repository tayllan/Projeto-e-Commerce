<?php

require_once '../config.php';
require_once DIR_ROOT . 'controller/loginController.php';
require_once DIR_ROOT . 'controller/boletoBancarioController.php';

class BoletoBancarioView {
    
    private $controller;
    
    public function __construct() {
        $this->controller = new BoletoBancarioController();
        if (LoginController::testarLogin()) {
            $this->rotear();
        }
    }
    
    private function rotear() {
        $this->exibirConteudo($this->controller->contruirBoletoBancario());
    }

    private function exibirConteudo($conteudo) {
        cabecalhoHTML('Boleto Bancário');
        cabecalho('Super Cabeçalho');
        echo '<div id="divBoleto">' . $conteudo . '</div>';
        rodape('Super Rodapé');
        rodapeHTML();
    }
    
}

new BoletoBancarioView();
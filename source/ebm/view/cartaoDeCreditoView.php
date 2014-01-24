<?php

require_once '../config.php';
require_once DIR_ROOT . 'controller/loginController.php';
require_once DIR_ROOT . 'controller/cartaoDeCreditoController.php';

class CartaoDeCreditoView {
    
    private $controller;
    
    public function __construct() {
        $this->controller = new CartaoDeCreditoController();
        if (LoginController::testarLogin()) {
            $this->rotear();
        }
    }
    
    private function rotear() {
        $this->exibirConteudo('Aqui. Falta tudo sobre Cartão de Crédito');
    }

    private function exibirConteudo($conteudo) {
        cabecalhoHTML('Pagamento com Cartão de Crédito');
        cabecalho('Super Cabeçalho');
        echo '<div>' . $conteudo . '</div>';
        rodape('Super Rodapé');
        rodapeHTML();
    }
    
}

new CartaoDeCreditoView();
<?php

require_once '../config.php';
require_once DIR_ROOT . 'controller/carrinhoDeComprasController.php';

class CarrinhoDeComprasView {
    
    private $controller;
    
    public function __construct() {
        $this->controller = new CarrinhoDeComprasController();
        $this->rotear();
    }
    
    private function rotear() {
        $this->controller->inserir();
    }
    
}

new CarrinhoDeComprasView();
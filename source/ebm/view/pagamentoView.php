<?php

require_once '../config.php';
require_once DIR_ROOT . 'controller/pagamentoController.php';

class PagamentoView {

    public function __construct() {
        $this->rotear();
    }
    
    private function rotear() {
        var_dump($_POST);
    }

}

new PagamentoView();

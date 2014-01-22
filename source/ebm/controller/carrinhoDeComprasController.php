<?php

require_once DIR_ROOT . 'controller/database.php';
require_once DIR_ROOT . 'controller/produtoController.php';
require_once DIR_ROOT . 'controller/compraController.php';
require_once DIR_ROOT . 'controller/usuarioController.php';
require_once DIR_ROOT . 'controller/itemDeProdutoController.php';

class CarrinhoDeComprasController extends DAO {
    
    private $usuarioController;
    private $produtoController;
    private $compraController;
    private $itemDeProdutoController;
    
    public function __construct() {
        parent::__construct();
        
        $this->usuarioController = new UsuarioController();
        $this->produtoController = new ProdutoController();
        $this->compraController = new CompraController();
        $this->itemDeProdutoController = new ItemDeProdutoController();
    }

    public function inserir() {
        var_dump($_POST);
    }

}

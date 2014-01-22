<?php

require_once DIR_ROOT . 'controller/loginController.php';
require_once DIR_ROOT . 'controller/database.php';
require_once DIR_ROOT . 'controller/produtoController.php';
require_once DIR_ROOT . 'controller/compraController.php';
require_once DIR_ROOT . 'controller/usuarioController.php';
require_once DIR_ROOT . 'controller/itemDeProdutoController.php';
require_once DIR_ROOT . 'entity/produtoModel.php';
require_once DIR_ROOT . 'entity/compraModel.php';
require_once DIR_ROOT . 'entity/usuarioModel.php';
require_once DIR_ROOT . 'entity/itemDeProdutoModel.php';

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
    
    public function rotearInsercao($produtoId) {
        $compraId = LoginController::getIdCompra();
        
        /*
         * Se um outro usuário logar no sistema ele não vai interferir na compra do usuário anterior.
         * Mas se o mesmo usuário deslogar e logar denovo, é feita uma nova compra, ao invés
         * de atualizar a compra anterir (ainda não concluída).
         */
        
        $compra = $this->compraController->construirObjetoPorId($compraId[Colunas::COMPRA_ID]);
        $usuario = LoginController::getUsuarioLogado();
        
        if ($compraId && $compra->usuario->id === $usuario->id) {
            $this->alterarCompra($produtoId, $compraId[Colunas::COMPRA_ID]);
            
            echo 'Compra sendo realizada';
        }
        else {
            $compraId = $this->inserirCompra($produtoId);
            LoginController::setIdCompra($compraId);
            
            echo 'Nova compra';
        }
    }

    private function inserirCompra($produtoId) {
        $usuario = LoginController::getUsuarioLogado();
        $compra = new Compra(
            NULL, date('d/m/Y h:i:s', time()),
            0, $usuario
        );
        $this->compraController->rotearInsercao($compra);
        $compraId = $this->compraController->getId($compra);
        $compra->id = $compraId[Colunas::COMPRA_ID];
        
        $produto = $this->produtoController->construirObjetoPorId($produtoId);
        
        $itemDeProduto = new ItemDeProduto(
            NULL, 1,
            floatval($produto->preco), $compra,
            $produto
        );
        
        $this->itemDeProdutoController->rotearInsercao($itemDeProduto);
        
        $compra->total += $itemDeProduto->preco * $itemDeProduto->quantidade;
        $this->compraController->rotearInsercao($compra);
        
        return $compraId;
    }
    
    private function alterarCompra($produtoId, $compraId) {
        $compra = $this->compraController->construirObjetoPorId($compraId);
        $produto = $this->produtoController->construirObjetoPorId($produtoId);
        
        $itemDeProduto = new ItemDeProduto(
            NULL, 1,
            floatval($produto->preco), $compra,
            $produto
        );
        
        $this->itemDeProdutoController->rotearInsercao($itemDeProduto);
        
        $compra->total += $itemDeProduto->preco * $itemDeProduto->quantidade;
        $this->compraController->rotearInsercao($compra);
        
        return $compraId;
    }

    private function listar() {
        
    }

}

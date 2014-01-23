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
    public $produtoController;
    public $compraController;
    public $itemDeProdutoController;

    public function __construct() {
        parent::__construct();

        $this->usuarioController = new UsuarioController();
        $this->produtoController = new ProdutoController();
        $this->compraController = new CompraController();
        $this->itemDeProdutoController = new ItemDeProdutoController();
    }

    public function rotearInsercao($produtoId) {
        $usuario = LoginController::getUsuarioLogado();
        $compraId = $this->compraController->getIdByUser($usuario);
        
        if ($compraId) {
            $compra = $this->compraController->construirObjetoPorId($compraId);
            $produto = $this->produtoController->construirObjetoPorId($produtoId);
            if ($compraId && !$compra->concluida) {
                $this->inserirItemDeProdutoAlterarCompra($produto, $compra);
            }
        }
        else {
            $compraId = $this->inserirCompra($produtoId);
        }
    }

    private function inserirCompra($produtoId) {
        $usuario = LoginController::getUsuarioLogado();
        $compra = new Compra(
            NULL, date('d/m/Y h:i:s', time()),
            0, $usuario,
            'false'
        );
        $this->compraController->rotearInsercao($compra);
        $compraId = $this->compraController->getId($compra);
        $compra->id = $compraId[Colunas::COMPRA_ID];

        $produto = $this->produtoController->construirObjetoPorId($produtoId);

        return $this->inserirItemDeProdutoAlterarCompra(
            $produto, $compra
        );
    }

    private function inserirItemDeProdutoAlterarCompra($produto, $compra) {
        $itemDeProduto = new ItemDeProduto(
            NULL, 1,
            floatval($produto->preco), $compra,
            $produto
        );

        $this->itemDeProdutoController->rotearInsercao($itemDeProduto);

        $compra->total += $itemDeProduto->preco * $itemDeProduto->quantidade;
        $compra->concluida = 'false';
        $this->compraController->rotearInsercao($compra);

        return $compra->id;
    }

    public function listar($usuario) {
        $sqlQuery = $this->conexao->prepare(
            'SELECT ' . Colunas::PRODUTO_ID . ', ' . Colunas::MARCA_DE_PRODUTO_NOME . ', '
            . Colunas::CATEGORIA_DE_PRODUTO_NOME . ', ' . Colunas::ITEM_DE_PRODUTO_ID . ' FROM '
            . Colunas::USUARIO . ', ' . Colunas::COMPRA . ', '
            . Colunas::ITEM_DE_PRODUTO . ', ' . Colunas::PRODUTO . ', '
            . Colunas::CATEGORIA_DE_PRODUTO . ', ' . Colunas::MARCA_DE_PRODUTO . ' WHERE '
            . Colunas::USUARIO_ID . ' = ? AND ' . Colunas::USUARIO_ID . ' = '
            . Colunas::COMPRA_FK_USUARIO . ' AND ' . Colunas::COMPRA_ID . ' = '
            . Colunas::ITEM_DE_PRODUTO_FK_COMPRA . ' AND ' . Colunas::ITEM_DE_PRODUTO_FK_PRODUTO . ' = '
            . Colunas::PRODUTO_ID . ' AND ' . Colunas::COMPRA_CONCLUIDA . ' = FALSE AND '
            . Colunas::PRODUTO_FK_MARCA . ' = ' . Colunas::MARCA_DE_PRODUTO_ID . ' AND '
            . Colunas::PRODUTO_FK_CATEGORIA . ' = ' . Colunas::CATEGORIA_DE_PRODUTO_ID
        );
        
        $sqlQuery->execute(
            array($usuario->id)
        );
        
        if ($sqlQuery->rowCount() > 0) {
            return $sqlQuery->fetchAll(PDO::FETCH_ASSOC);
        }
        else {
            return array();
        }
    }

}

<?php

require_once DIR_ROOT . 'entity/produtoModel.php';
require_once DIR_ROOT . 'controller/marcaDeProdutoController.php';
require_once DIR_ROOT . 'controller/categoriaDeProdutoController.php';
require_once 'baseController.php';

class ProdutoController extends BaseController {
    
    private $marcaController;
    private $categoriaController;
    
    public function __construct() {
        parent::__construct();
        $this->marcaController = new MarcaDeProdutoController();
        $this->categoriaController = new CategoriaDeProdutoController();
    }

    protected function inserir($produto) {
        $sqlQuery = $this->conexao->prepare(
            'INSERT INTO ' . Colunas::PRODUTO . ' (' . Colunas::PRODUTO_FK_MARCA . ', '
            . Colunas::PRODUTO_FK_CATEGORIA . ', ' . Colunas::PRODUTO_NOME . ', '
            . Colunas::PRODUTO_DESCRICAO . ', ' . Colunas::PRODUTO_PRECO . ', '
            . Colunas::PRODUTO_QUANTIDADE . ') VALUES (?, ?, ?, ?, ?, ?)'
        );
        
        return $sqlQuery->execute(
            array(
                $produto->marca->id, $produto->categoria->id,
                $produto->nome, $produto->descricao,
                $produto->preco, $produto->quantidade
            )
        );
    }

    protected function alterar($produto) {
        $sqlQuery = $this->conexao->prepare(
            'UPDATE ' . Colunas::PRODUTO . ' SET ' . Colunas::PRODUTO_FK_MARCA . ' = ?, '
            . Colunas::PRODUTO_FK_CATEGORIA . ' = ?, ' . Colunas::PRODUTO_NOME . ' = ?, '
            . Colunas::PRODUTO_DESCRICAO . ' = ?, ' . Colunas::PRODUTO_PRECO . ' = ?, '
            . Colunas::PRODUTO_QUANTIDADE . ' = ? WHERE ' . Colunas::PRODUTO_ID . ' = ?'
        );
        
        return $sqlQuery->execute(
            array(
                $produto->marca->id, $produto->categoria->id,
                $produto->nome, $produto->descricao,
                $produto->preco, $produto->quantidade, $produto->id
            )
        );
    }

    public function getById($id) {
        $sqlQuery = $this->conexao->prepare(
            'SELECT * FROM ' . Colunas::PRODUTO . ' WHERE ' . Colunas::PRODUTO_ID . ' = ?'
        );
        
        $sqlQuery->execute(
            array($id)
        );
        
        if ($sqlQuery->rowCount() > 0) {
            return $sqlQuery->fetch(PDO::FETCH_ASSOC);
        }
        else {
            return array();
        }
    }

    public function getId($produto) {
        $sqlQuery = $this->conexao->prepare(
            'SELECT ' . Colunas::PRODUTO_ID . ' FROM ' . Colunas::PRODUTO . ' WHERE '
            . Colunas::PRODUTO_FK_MARCA . ' = ? AND ' . Colunas::PRODUTO_FK_CATEGORIA . ' = ? AND '
            . Colunas::PRODUTO_NOME . ' LIKE ? AND ' . Colunas::PRODUTO_DESCRICAO . ' LIKE ? AND '
            . Colunas::PRODUTO_PRECO . ' = ? AND ' . Colunas::PRODUTO_QUANTIDADE . ' = ?'
        );
        
        $sqlQuery->execute(
            array(
                $produto->marca->id, $produto->categoria->id,
                $produto->nome, $produto->descricao,
                $produto->preco, $produto->quantidade
            )
        );
        
        if ($sqlQuery->rowCount() > 0) {
            return $sqlQuery->fetch(PDO::FETCH_ASSOC);
        }
        else {
            return array();
        }
    }
    
    public function construirObjeto(array $codigosIdentificadores = NULL) {
        $marcaDeProduto = $this->marcaController->construirObjetoPorId(
            $codigosIdentificadores[Colunas::PRODUTO_FK_MARCA]
        );
        $categoriaDeProduto = $this->categoriaController->construirObjetoPorId(
            $codigosIdentificadores[Colunas::PRODUTO_FK_CATEGORIA]
        );
        $produto = new Produto(
            $codigosIdentificadores[Colunas::PRODUTO_ID],
            $codigosIdentificadores[Colunas::PRODUTO_NOME],
            $marcaDeProduto, $categoriaDeProduto,
            $codigosIdentificadores[Colunas::PRODUTO_DESCRICAO],
            $codigosIdentificadores[Colunas::PRODUTO_PRECO],
            $codigosIdentificadores[Colunas::PRODUTO_QUANTIDADE]
        );       
        
        return $produto;
    }
    
    public function construirObjetoPorId($id) {
        $arrayProduto = $this->getById($id);
        $marcaDeProduto = $this->marcaController->construirObjetoPorId(
            $arrayProduto[Colunas::PRODUTO_FK_MARCA]
        );
        $categoriaDeProduto = $this->categoriaController->construirObjetoPorId(
            $arrayProduto[Colunas::PRODUTO_FK_CATEGORIA]
        );

        $produto = new Produto(
            $arrayProduto[Colunas::PRODUTO_ID],
            $arrayProduto[Colunas::PRODUTO_NOME],
            $marcaDeProduto, $categoriaDeProduto,
            $arrayProduto[Colunas::PRODUTO_DESCRICAO],
            $arrayProduto[Colunas::PRODUTO_PRECO],
            $arrayProduto[Colunas::PRODUTO_QUANTIDADE]
        );       
        
        return $produto;
    }

}

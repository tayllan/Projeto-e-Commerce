<?php

require_once DIR_ROOT . 'controller/database.php';
require_once DIR_ROOT . 'controller/produtoController.php';
require_once DIR_ROOT . 'controller/itemDeProdutoController.php';
require_once DIR_ROOT . 'controller/compraController.php';
require_once DIR_ROOT . 'boleto/autoloader.php';

use OpenBoleto\Banco\Itau;
use OpenBoleto\Agente;

class BoletoBancarioController extends DAO {

    private $usuario;
    private $produtoController;
    private $itemDeProdutoController;
    private $compraController;

    public function __construct() {
        parent::__construct();
        $this->usuario = LoginController::getUsuarioLogado();
        $this->produtoController = new ProdutoController();
        $this->itemDeProdutoController = new ItemDeProdutoController();
        $this->compraController = new CompraController();
    }

    private function getValorTotalDaCompra() {
        $array = $this->listar();
        $arrayItensDeProdutosQuantidade = $_SESSION[Colunas::ITEM_DE_PRODUTO_QUANTIDADE];
        $index = 0;
        $totalCompra = 0;

        foreach ($array as $linha) {
            $produto = $this->produtoController->construirObjetoPorId(
                $linha[Colunas::PRODUTO_ID]
            );
            $itemDeProduto = $this->itemDeProdutoController->construirObjetoPorId(
                $linha[Colunas::ITEM_DE_PRODUTO_ID]
            );
            $itemDeProduto->quantidade = $arrayItensDeProdutosQuantidade[$index];
            $this->itemDeProdutoController->rotearInsercao($itemDeProduto);
            
            $produto->quantidade -= $itemDeProduto->quantidade;
            $this->produtoController->rotearInsercao($produto);            
            
            $totalCompra += $arrayItensDeProdutosQuantidade[$index++] * $itemDeProduto->preco;
        }
        
        $this->finalizarCompra($array['0'][Colunas::COMPRA_ID], $totalCompra);

        return $totalCompra;
    }

    private function listar() {
        $sqlQuery = $this->conexao->prepare(
            'SELECT ' . Colunas::PRODUTO_ID . ', ' . Colunas::MARCA_DE_PRODUTO_NOME . ', '
            . Colunas::CATEGORIA_DE_PRODUTO_NOME . ', ' . Colunas::ITEM_DE_PRODUTO_ID . ', '
            . Colunas::COMPRA_ID . ' FROM '
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
            array($this->usuario->id)
        );

        if ($sqlQuery->rowCount() > 0) {
            return $sqlQuery->fetchAll(PDO::FETCH_ASSOC);
        }
        else {
            return array();
        }
    }

    public function contruirBoletoBancario() {
        $totalCompra = $this->getValorTotalDaCompra();
        $endereco = $this->usuario->endereco->bairro . ' ' . $this->usuario->endereco->rua
            . ' ' . $this->usuario->endereco->numero;
        $sacado = new Agente(
            $this->usuario->nome, $this->usuario->cpf,
            $endereco, $this->usuario->endereco->cep,
            $this->usuario->endereco->cidade->nome, $this->usuario->endereco->cidade->unidadeFederativa->sigla
        );
        $cedente = new Agente(
            'EBM e-Commerce LTDA', '02.123.123/0001-11',
            'UTFPR Campus Cornélio Procópio - Avenida Alberto Carazzai, 1640', '86300-000',
            'Cornélio Procópio', 'PR'
        );

        $boleto = new Itau(
            array(
                'dataVencimento' => new DateTime('2013-01-28'),
                'valor' => $totalCompra,
                'sequencial' => 12345678, // 8 dígitos
                'sacado' => $sacado,
                'cedente' => $cedente,
                'agencia' => 1724, // 4 dígitos
                'carteira' => 112, // 3 dígitos
                'conta' => 12345, // 5 dígitos
            )
        );

        return $boleto->getOutput();
    }
    
    private function finalizarCompra($compraId, $totalCompra) {
        $compra = $this->compraController->construirObjetoPorId($compraId);
        
        $compra->concluida = TRUE;
        $compra->total = $totalCompra;
        
        $this->compraController->rotearInsercao($compra);
    }

}

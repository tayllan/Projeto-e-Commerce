<?php

require_once DIR_ROOT . 'controller/database.php';
require_once DIR_ROOT . 'controller/produtoController.php';
require_once DIR_ROOT . 'controller/itemDeProdutoController.php';
require_once DIR_ROOT . 'controller/compraController.php';

class CartaoDeCreditoController extends DAO {

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
            $itemDeProduto = $this->itemDeProdutoController->construirObjetoPorId(
                $linha[Colunas::ITEM_DE_PRODUTO_ID]
            );
            $itemDeProduto->quantidade = $arrayItensDeProdutosQuantidade[$index];
            $this->itemDeProdutoController->rotearInsercao($itemDeProduto);
            
            $totalCompra += $arrayItensDeProdutosQuantidade[$index++] * $itemDeProduto->preco;
        }

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

    public function construirFormularioCartao() {
        $totalCompra = $this->getValorTotalDaCompra();
        $endereco = $this->usuario->endereco->bairro . ' - ' . $this->usuario->endereco->logradouro
            . ', ' . $this->usuario->endereco->numero;
        
        $conteudo = '<form class="ui form segment" action="/view/cartaoDeCreditoView.php" method="POST">
            <fieldset class="ui form segment">
                <legend>Informações Gerais:</legend>

                <div>
                    <label>Valor total da compra</label>
                    <div class="ui left labeled icon input">
                        <input type="number" placeholder="E-Mail" value="' . $totalCompra . '">
                        <i class="dollar icon"></i>
                    </div>
                </div>

                <div>
                    <label>Comprador</label>
                    <div class="ui left labeled icon input">
                        <input type="text" value="' . $this->usuario->nome . '">
                        <i class="user icon"></i>
                    </div>
                </div>

                <div>
                    <label>Endereço de Entrega</label>
                    <div class="ui left labeled icon input">
                        <input type="text" value="' . $endereco . '">
                        <i class="map icon"></i>
                    </div>
                </div>
            </fieldset>

            <fieldset class="ui form segment">
                <legend>Informações de Cartão de Crédito</legend>
                
                <p>TODO: campos a serem preenchidos, referentes ao cartão de crédito do usuário</p>
            </fieldset>
            
            <div>
                <br>
                <input type="submit" name="compraSucesso" value="Finalizar" class="ui black submit button small">
            </div>
        </form>';

        return $conteudo;
    }
    
    public function finalizarCompra() {
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
        
        $compra = $this->compraController->construirObjetoPorId($array['0'][Colunas::COMPRA_ID]);
        
        $compra->concluida = TRUE;
        $compra->total = $totalCompra;
        $compra->formaPagamento = 'Cartão de Crédito';
        
        $this->compraController->rotearInsercao($compra);
    }

}

<?php

require_once 'baseView.php';
require_once ROOT . 'controller/itemDeProdutoController.php';
require_once ROOT . 'controller/compraController.php';
require_once ROOT . 'controller/produtoController.php';
require_once ROOT . 'entity/itemDeProdutoModel.php';
require_once ROOT . 'entity/compraModel.php';
require_once ROOT . 'entity/produtoModel.php';
require_once ROOT . 'view/template/itemDeProdutoEdicao.php';

class ItemDeProdutoView extends BaseView {
    
    private $compraController;
    private $produtoController;

    public function __construct() {
        $this->controller = new ItemDeProdutoController();
        $this->compraController = new CompraController();
        $this->produtoController = new ProdutoController();
        if ($this->controller->testarLogin()) {
            $this->rotear();
        }
    }

    protected function rotear() {
        if (isset($_POST[Colunas::ITEM_DE_PRODUTO_ID])) {
            $itemDeProduto = $this->controller->construirObjeto(
                array (
                    Colunas::ITEM_DE_PRODUTO_ID => $_POST[Colunas::ITEM_DE_PRODUTO_ID],
                    Colunas::ITEM_DE_PRODUTO_QUANTIDADE => $_POST[Colunas::ITEM_DE_PRODUTO_QUANTIDADE],
                    Colunas::ITEM_DE_PRODUTO_PRECO => $_POST[Colunas::ITEM_DE_PRODUTO_PRECO],
                    Colunas::ITEM_DE_PRODUTO_FK_COMPRA => $_POST[Colunas::ITEM_DE_PRODUTO_FK_COMPRA],
                    Colunas::ITEM_DE_PRODUTO_FK_PRODUTO => $_POST[Colunas::ITEM_DE_PRODUTO_FK_PRODUTO]
                )
            );
            $trueFalse = $this->controller->rotearInsercao($itemDeProduto);
            $this->exibirMensagem(
                'Item De Prdotuo', $trueFalse
            );
        }
        else if (isset($_GET['editar']) && $_GET['editar'] === 'false') {
            $this->cadastrar();
        }
        else if (isset($_GET['editar'])) {
            $this->alterar();
        }
        else if (isset($_POST['deletar'])) {
            $this->deletar(
                'Item De Produto', Colunas::ITEM_DE_PRODUTO_ID,
                Colunas::ITEM_DE_PRODUTO
            );
        }
        else {
            $this->listar();
        }
    }

    protected function cadastrar() {
        $itemDeProduto = ItemDeProduto::getNullObject();
        $this->exibirConteudo(
            construirFormulario($itemDeProduto)
        );
    }

    protected function listar() {
        $array = $this->controller->listar(Colunas::ITEM_DE_PRODUTO);
        $conteudo = criarTabela(
            'Itens de Produtos Cadastrados', 'itemDeProdutoView',
            array(
                'Quantidade', 'Preço',
                'Compra Relacionada', 'Produto'
            )
        );

        foreach ($array as $linha) {
            $conteudo .= $this->construirTabela($linha);
        }

        $this->exibirConteudo($conteudo . '</tbody></table>');
    }
    
    protected function construirTabela($linha) {
        $conteudo = '<tr><td><a href="itemDeProdutoView.php?editar=true&id='
            . $linha[Colunas::ITEM_DE_PRODUTO_ID] . '">' . $linha[Colunas::ITEM_DE_PRODUTO_QUANTIDADE] . '</a></td>'
            . '<td>' . $linha[Colunas::ITEM_DE_PRODUTO_PRECO] . '</td>'
            . '<td>' . $this->getBuyName($linha) . '</td>'
            . '<td>' . $this->getProductName($linha) . '</td>'
            . '<td><form action="itemDeProdutoView.php" method="POST"><button type="submit" name="deletar"'
            . 'value="' . $linha[Colunas::ITEM_DE_PRODUTO_ID] . '">Deletar</button></form></td></tr>';
        
        return $conteudo;
    }
    
    private function getBuyName($linha) {
        $arrayCompra = $this->compraController->getById(
            $linha[Colunas::ITEM_DE_PRODUTO_FK_COMPRA]
        );
        $nomeCompra = $arrayCompra[Colunas::COMPRA_DATA] . ' '
            . $arrayCompra[Colunas::COMPRA_TOTAL];
        
        return $nomeCompra;
    }
    
    private function getProductName($linha) {
        $nomeProduto = $this->produtoController->getById(
            $linha[Colunas::ITEM_DE_PRODUTO_FK_PRODUTO]
        )[Colunas::PRODUTO_NOME];
        
        return $nomeProduto;            
    }

    protected function alterar() {
        $itemDeProduto = $this->controller->construirObjetoPorId($_GET['id']);

        $this->exibirConteudo(
            construirFormulario($itemDeProduto)
        );
    }
    
    protected function exibirConteudo($conteudo) {
        cabecalhoHTML('Cadastro de Itens de Produtos');
        cabecalho('Super Cabeçalho');
        echo $conteudo;
        rodape('Super Rodapé');
        rodapeHTML();
    }

}

new ItemDeProdutoView();
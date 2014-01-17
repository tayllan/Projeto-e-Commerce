<?php

require_once 'baseView.php';
require_once DIR_ROOT . 'controller/produtoController.php';
require_once DIR_ROOT . 'controller/marcaDeProdutoController.php';
require_once DIR_ROOT . 'controller/categoriaDeProdutoController.php';
require_once DIR_ROOT . 'entity/produtoModel.php';
require_once DIR_ROOT . 'view/template/produtoEdicao.php';

class ProdutoView extends BaseView {
    
    private $marcaController;
    private $categoriaController;

    public function __construct() {
        $this->controller = new ProdutoController();
        $this->marcaController = new MarcaDeProdutoController();
        $this->categoriaController = new CategoriaDeProdutoController();
        if ($this->controller->testarLogin()) {
            $this->rotear();
        }
    }

    protected function rotear() {
        if (isset($_POST[Colunas::PRODUTO_ID])) {
            $produto = $this->controller->construirObjeto(
                array (
                    Colunas::PRODUTO_ID => $_POST[Colunas::PRODUTO_ID],
                    Colunas::PRODUTO_NOME => $_POST[Colunas::PRODUTO_NOME],
                    Colunas::PRODUTO_FK_MARCA => $_POST[Colunas::PRODUTO_FK_MARCA],
                    Colunas::PRODUTO_FK_CATEGORIA => $_POST[Colunas::PRODUTO_FK_CATEGORIA],
                    Colunas::PRODUTO_DESCRICAO => $_POST[Colunas::PRODUTO_DESCRICAO],
                    Colunas::PRODUTO_PRECO => $_POST[Colunas::PRODUTO_PRECO],
                    Colunas::PRODUTO_QUANTIDADE => $_POST[Colunas::PRODUTO_QUANTIDADE]
                )
            );
            $trueFalse = $this->controller->rotearInsercao($produto);
            $this->exibirMensagemCadastro(
                'Produto', $trueFalse
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
                'Produto', Colunas::PRODUTO_ID,
                Colunas::PRODUTO
            );
        }
        else {
            $this->listar();
        }
    }

    protected function cadastrar() {
        $produto = Produto::getNullObject();
        $this->exibirConteudo(
            construirFormulario($produto)
        );
    }

    protected function listar() {
        $array = $this->controller->listar(Colunas::PRODUTO);
        $conteudo = criarTabela(
            'Produtos Cadastrados', 'produtoView',
            array(
                'Nome', 'Descrição',
                'Marca', 'Categoria',
                'Preço', 'Quantidade'
            )
        );

        foreach ($array as $linha) {
            $conteudo .= $this->construirTabela($linha);
        }

        $this->exibirConteudo($conteudo . '</tbody></table>');
    }
    
    protected function construirTabela($linha) {
        $conteudo = '<tr><td><a href="produtoView.php?editar=true&id=' . $linha[Colunas::PRODUTO_ID] . '">'
            . $linha[Colunas::PRODUTO_NOME] . '</a></td>'
            . '<td>' . $linha[Colunas::PRODUTO_DESCRICAO] . '</td>'
            . '<td>' . $this->getBrandName($linha) . '</td>'
            . '<td>' . $this->getCategoryName($linha) . '</td>'
            . '<td>' . $linha[Colunas::PRODUTO_PRECO] . '</td>'
            . '<td>' . $linha[Colunas::PRODUTO_QUANTIDADE] . '</td>'
            . '<td><form action="produtoView.php" method="POST"><button type="submit" name="deletar"'
            . 'value="' . $linha[Colunas::PRODUTO_ID] . '">Deletar</button></form></td></tr>';
        
        return $conteudo;
    }
    
    private function getBrandName($linha) {
        $nomeMarca = $this->marcaController->getById(
            $linha[Colunas::PRODUTO_FK_MARCA]
        )[Colunas::MARCA_DE_PRODUTO_NOME];
        
        return $nomeMarca;
    }
    
    private function getCategoryName($linha) {
        $nomeCategoria = $this->categoriaController->getById(
            $linha[Colunas::PRODUTO_FK_CATEGORIA]
        )[Colunas::CATEGORIA_DE_PRODUTO_NOME];
        
        return $nomeCategoria;
    }

    protected function alterar() {
        $produto = $this->controller->construirObjetoPorId($_GET['id']);
        
        $this->exibirConteudo(
            construirFormulario($produto)
        );
    }
    
    protected function exibirConteudo($conteudo) {
        cabecalhoHTML('Cadastro de Usuarios');
        cabecalho('Super Cabeçalho');
        echo $conteudo;
        rodape('Super Rodapé');
        rodapeHTML();
    }

}

new ProdutoView();

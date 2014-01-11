<?php

require_once 'baseView.php';
require_once ROOT . 'controller/marcaDeProdutoController.php';
require_once ROOT . 'entity/marcaDeProdutoModel.php';
require_once ROOT . 'view/template/marcaDeProdutoEdicao.php';

class MarcaDeProdutoView extends BaseView {

    public function __construct() {
        $this->controller = new MarcaDeProdutoController();
        if ($this->controller->testarLogin()) {
            $this->rotear();
        }
    }

    protected function rotear() {
        if (isset($_POST[Colunas::MARCA_DE_PRODUTO_ID])) {
            $marcaDeProduto = $this->controller->construirObjeto(
                array (
                    Colunas::MARCA_DE_PRODUTO_ID => $_POST[Colunas::MARCA_DE_PRODUTO_ID],
                    Colunas::MARCA_DE_PRODUTO_NOME=> $_POST[Colunas::MARCA_DE_PRODUTO_NOME]
                )
            );
            $trueFalse = $this->controller->rotearInsercao($marcaDeProduto);
            $this->exibirMensagem(
                'Marca de Produto', $trueFalse
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
                'Marca de Produto', Colunas::MARCA_DE_PRODUTO_ID,
                Colunas::MARCA_DE_PRODUTO
            );
        }
        else {
            $this->listar();
        }
    }

    protected function cadastrar() {
        $marcaDeProduto = MarcaDeProduto::getNullObject();
        $this->exibirConteudo(
            construirFormulario($marcaDeProduto)
        );
    }

    protected function listar() {
        $array = $this->controller->listar(Colunas::MARCA_DE_PRODUTO);
        $conteudo = criarTabela(
            'Marcas de Produtos Cadastradas', 'marcaDeProdutoView',
            array('Nome')
        );

        foreach ($array as $linha) {
            $conteudo .= $this->construirTabela($linha);
        }

        $this->exibirConteudo($conteudo . '</tbody></table>');
    }
    
    protected function construirTabela($linha) {
        $conteudo = '<tr><td><a href="marcaDeProdutoView.php?editar=true&id='
            . $linha[Colunas::MARCA_DE_PRODUTO_ID] . '">' . $linha[Colunas::MARCA_DE_PRODUTO_NOME]
            . '</a></td>'
            . '<td><form action="marcaDeProdutoView.php" method="POST"><button type="submit" name="deletar"'
            . 'value="' . $linha[Colunas::MARCA_DE_PRODUTO_ID] . '">Deletar</button></form></td></tr>';
        
        return $conteudo;
    }

    protected function alterar() {
        $marcaDeProduto = $this->controller->construirObjetoPorId($_GET['id']);

        $this->exibirConteudo(
            construirFormulario($marcaDeProduto)
        );
    }
    
    protected function exibirConteudo($conteudo) {
        cabecalhoHTML('Cadastro de Marcas de Produtos');
        cabecalho('Super Cabeçalho');
        echo $conteudo;
        rodape('Super Rodapé');
        rodapeHTML();
    }

}

new MarcaDeProdutoView();
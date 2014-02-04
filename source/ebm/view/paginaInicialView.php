<?php

require_once DIR_ROOT . 'controller/paginaInicialController.php';
require_once DIR_ROOT . 'controller/loginController.php';

class PaginaInicialView {
    
    private $controller;
    
    public function __construct() {
        $this->controller = new PaginaInicialController();
    }

    public function listar() {
        $array = $this->controller->listar();
        $conteudo = '<div class="ui secondary pointing menu">
            <legend class="item">Categorias</label>
            <a class="item" href="/index.php">
                <i class="search icon"></i>
                Todos
            </a>
            <a class="item" href="/index.php?queries[search]=eletrônico">
                <i class="search icon"></i>
                Eletrônicos
            </a>
            <a class="item" href="/index.php?queries[search]=eletrodoméstico">
                <i class="search icon"></i>
                Eletrodomésticos
            </a>
            <a class="item" href="/index.php?queries[search]=erva">
                <i class="search icon"></i>
                Ervas
            </a>
            <a class="item" href="/index.php?queries[search]=categoriaX">
                <i class="search icon"></i>
                Categoria X
            </a>
            <a class="item" href="/index.php?queries[search]=categoriaY">
                <i class="search icon"></i>
                Categoria Y
            </a>
            <a class="item" href="/index.php?queries[search]=categoriaZ">
                <i class="search icon"></i>
                Categoria Z
            </a>
            <a class="item" href="/index.php?queries[search]=outracategoria">
                <i class="search icon"></i>
                Outra Categoria
            </a>
        </div>
        <form class="ui form" action="/view/carrinhoDeComprasView.php" method="POST">'
        . $this->criarTabela(
            'Produtos Cadastrados', array(
                'Comprar', 'Imagem',
                'Nome', 'Descrição',
                'Marca', 'Categoria',
                'Preço'
            )
        );

        foreach ($array as $linha) {
            $conteudo .= $this->construirTabela($linha);
        }

        echo $conteudo . '</tbody></table></form><script>paginarTabela()</script>';
    }

    private function criarTabela($caption, array $array) {
        $conteudo = '<table id="tabela-paginada" class="ui table segment small">
            <caption class="ui header">' . $caption . '</caption>
            
            <thead>
                <tr>';

        foreach ($array as $elemento) {
            $conteudo .= '<th>' . $elemento . '</th>';
        }

        return $conteudo . '</tr></thead><tbody>';
    }

    private function construirTabela($linha) {
        $conteudo = '<tr><td><button class="ui black submit button small" type="submit"'
            . ' name="' . Colunas::PRODUTO_ID . '" value="' . $linha[Colunas::PRODUTO_ID] . '">'
            . '<i class="cart icon"></i></button></td>'
            . '<td><img src="' . $linha[Colunas::PRODUTO_IMAGEM] . '" alt="Produto" width="80" height="80"></td>'
            . '<td>' . $linha[Colunas::PRODUTO_NOME] . '</td>'
            . '<td>' . $linha[Colunas::PRODUTO_DESCRICAO] . '</td>'
            . '<td>' . $this->controller->getBrandName($linha) . '</td>'
            . '<td>' . $this->controller->getCategoryName($linha) . '</td>'
            . '<td>' . $linha[Colunas::PRODUTO_PRECO] . '</td></tr>';
        
        return $conteudo;
    }

}

new PaginaInicialView();
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
        $conteudo = '<div class="ui form segment">'
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

        echo $conteudo . '</tbody></table></div>';
    }

    private function criarTabela($caption, array $array) {
        $conteudo = '<table class="ui table segment small">
            <caption>' . $caption . '</caption>
            
            <thead>
                <tr>';

        foreach ($array as $elemento) {
            $conteudo .= '<th><strong>' . $elemento . '</strong></th>';
        }

        return $conteudo . '</tr></thead><tbody>';
    }

    private function construirTabela($linha) {
        $conteudo = '<form action="/view/carrinhoDeComprasView.php" method="POST">'
            . '<tr><td><button class="ui black submit button small" type="submit"'
            . ' name="' . Colunas::PRODUTO_ID . '" value="' . $linha[Colunas::PRODUTO_ID] . '">'
            . '<i class="cart icon"></i></button></td>'
            . '<td><img src="' . $linha[Colunas::PRODUTO_IMAGEM] . '" alt="Produto" width="80" height="80"></td>'
            . '<td>' . $linha[Colunas::PRODUTO_NOME] . '</td>'
            . '<td>' . $linha[Colunas::PRODUTO_DESCRICAO] . '</td>'
            . '<td>' . $this->controller->getBrandName($linha) . '</td>'
            . '<td>' . $this->controller->getCategoryName($linha) . '</td>'
            . '<td>' . $linha[Colunas::PRODUTO_PRECO] . '</td></tr></form>';
        
        return $conteudo;
    }

}

new PaginaInicialView();
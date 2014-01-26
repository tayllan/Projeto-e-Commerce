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
        $conteudo = $this->criarTabela(
            'Produtos Cadastrados', array(
                'Comprar', 'Nome',
                'Descrição', 'Marca',
                'Categoria', 'Preço'
            )
        );

        foreach ($array as $linha) {
            $conteudo .= $this->construirTabela($linha);
        }

        echo $conteudo . '</tbody></table>';
    }

    private function criarTabela($caption, array $array) {
        $conteudo = '<table border="1">
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
            . '<tr><td><button type="submit" name="' . Colunas::PRODUTO_ID
            . '" value="' . $linha[Colunas::PRODUTO_ID] . '"><i class="cart icon"></i></button></td>'
            . '<td>' . $linha[Colunas::PRODUTO_NOME] . '</td>'
            . '<td>' . $linha[Colunas::PRODUTO_DESCRICAO] . '</td>'
            . '<td>' . $this->controller->getBrandName($linha) . '</td>'
            . '<td>' . $this->controller->getCategoryName($linha) . '</td>'
            . '<td>' . $linha[Colunas::PRODUTO_PRECO] . '</td></tr></form>';
        
        return $conteudo;
    }

}

new PaginaInicialView();
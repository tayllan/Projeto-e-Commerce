<?php

require_once DIR_ROOT . 'controller/paginaInicialController.php';

class PaginaInicialView {
    
    private $controller;
    
    public function __construct() {
        $this->controller = new PaginaInicialController();
    }

    public function listar() {
        $array = $this->controller->listar();
        $conteudo = $this->criarTabela(
            'Produtos Cadastrados', array(
                'Nome', 'Descrição',
                'Marca', 'Categoria',
                'Preço', 'Quantidade'
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
        $conteudo = '<tr><td>' . $linha[Colunas::PRODUTO_NOME] . '</a></td>'
            . '<td>' . $linha[Colunas::PRODUTO_DESCRICAO] . '</td>'
            . '<td>' . $this->controller->getBrandName($linha) . '</td>'
            . '<td>' . $this->controller->getCategoryName($linha) . '</td>'
            . '<td>' . $linha[Colunas::PRODUTO_PRECO] . '</td>'
            . '<td>' . $linha[Colunas::PRODUTO_QUANTIDADE] . '</td></tr>';

        return $conteudo;
    }

}

new PaginaInicialView();
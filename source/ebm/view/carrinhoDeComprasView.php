<?php

require_once '../config.php';
require_once DIR_ROOT . 'controller/carrinhoDeComprasController.php';

class CarrinhoDeComprasView {

    private $controller;

    public function __construct() {
        $this->controller = new CarrinhoDeComprasController();
        $this->rotear();
    }

    private function rotear() {
        if (isset($_POST[Colunas::PRODUTO_ID])) {
            $this->controller->rotearInsercao($_POST[Colunas::PRODUTO_ID]);
        }
    }
    
    public function construirFormulario() {
        $conteudo = '<form action="/view/carrinhoDeComprasControllerView.php" method="POST">
            <fieldset>
                <legend>Meu Carrinho de Compras</legend>
                
                <div>';
        
        $conteudo .= $this->listar();

        $conteudo .= '</div>

                <div>
                    <input type="submit" name="submeter" value="Efetuar Pagamento">
                </div>
            </fieldset>
        </form>';

        return $conteudo;
    }
    
    public function listar() {
        $array = $this->controller->listar();
        $conteudo = $this->criarTabela(
            'Produtos Cadastrados', array(
                'Comprar', 'Nome',
                'Descrição', 'Marca',
                'Categoria', 'Preço',
                'Quantidade'
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
            . '<tr><td><button class="comprar" type="submit" name="' . Colunas::PRODUTO_ID
            . '" value="' . $linha[Colunas::PRODUTO_ID] . '">comprar</button></td>'
            . '<td>' . $linha[Colunas::PRODUTO_NOME] . '</td>'
            . '<td>' . $linha[Colunas::PRODUTO_DESCRICAO] . '</td>'
            . '<td>' . $this->controller->getBrandName($linha) . '</td>'
            . '<td>' . $this->controller->getCategoryName($linha) . '</td>'
            . '<td>' . $linha[Colunas::PRODUTO_PRECO] . '</td>'
            . '<td>' . $linha[Colunas::PRODUTO_QUANTIDADE] . '</td></tr></form>';

        return $conteudo;
    }

    public function exibirConteudo($conteudo) {
        cabecalhoHTML('Carrinho de Compras');
        cabecalho('Super Cabeçalho');
        echo $conteudo;
        rodape('Super Rodapé');
        rodapeHTML();
    }

}

new CarrinhoDeComprasView();

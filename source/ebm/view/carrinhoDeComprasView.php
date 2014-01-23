<?php

require_once '../config.php';
require_once DIR_ROOT . 'controller/loginController.php';
require_once DIR_ROOT . 'controller/carrinhoDeComprasController.php';

class CarrinhoDeComprasView {

    private $controller;

    public function __construct() {
        $this->controller = new CarrinhoDeComprasController();
        if (LoginController::testarLogin()) {
            $this->rotear();
        }
    }

    private function rotear() {
        if (isset($_POST[Colunas::PRODUTO_ID])) {
            $this->controller->rotearInsercao($_POST[Colunas::PRODUTO_ID]);
            header('Location: carrinhoDeComprasView.php');
        }
        else {
            $usuario = LoginController::getUsuarioLogado();
            $this->exibirConteudo(
                $this->construirFormulario($usuario)
            );
        }
    }
    
    public function construirFormulario($usuario) {
        $conteudo = '<form action="/view/pagamentoView.php" method="POST">
            <fieldset>
                <legend>Meu Carrinho de Compras</legend>
                
                <div>';
        
        $conteudo .= $this->listar($usuario);

        $conteudo .= '</div>

                <div>
                    <input type="submit" name="submeter" value="Efetuar Pagamento">
                </div>
            </fieldset>
        </form>';

        return $conteudo;
    }
    
    public function listar($usuario) {
        $array = $this->controller->listar($usuario);
        $conteudo = $this->criarTabela(
            'Produtos Adicionados no Carrinho', array(
                'Nome', 'Descrição',
                'Marca', 'Categoria',
                'Quantidade', 'Preço'
            )
        );

        foreach ($array as $linha) {
            $conteudo .= $this->construirTabela($linha);
        }

        return $conteudo . '</tbody></table>';
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
        $conteudo = '<tr><td hidden><input type="hidden" name="' . Colunas::PRODUTO
            . '[]" value="' . $linha[Colunas::PRODUTO_ID] . '"></td>'
            . '<td>' . $linha[Colunas::PRODUTO_NOME] . '</td>'
            . '<td>' . $linha[Colunas::PRODUTO_DESCRICAO] . '</td>'
            . '<td>' . $linha[Colunas::MARCA_DE_PRODUTO_NOME] . '</td>'
            . '<td>' . $linha[Colunas::CATEGORIA_DE_PRODUTO_NOME] . '</td>'
            . '<td><input type="number" name="' . Colunas::ITEM_DE_PRODUTO_QUANTIDADE
            . '[]" value="' . $linha[Colunas::ITEM_DE_PRODUTO_QUANTIDADE] . '"</td>'
            . '<td hidden><input type="hidden" name="' . Colunas::ITEM_DE_PRODUTO_PRECO
            . '[]" value="' . $linha[Colunas::ITEM_DE_PRODUTO_PRECO] . '"></td>'
            . '<td>' . $linha[Colunas::ITEM_DE_PRODUTO_PRECO] . '</td></tr>';

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

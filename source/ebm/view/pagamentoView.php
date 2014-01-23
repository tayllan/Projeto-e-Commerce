<?php

require_once '../config.php';
require_once DIR_ROOT . 'controller/loginController.php';
require_once DIR_ROOT . 'controller/pagamentoController.php';

class PagamentoView {

    public function __construct() {
        if (LoginController::testarLogin()) {
            $this->rotear();
        }
    }

    private function rotear() {
        /*#$arrayItensDeProdutosQuantidade = $_POST[Colunas::ITEM_DE_PRODUTO_QUANTIDADE];
        #$arrayItensDeProdutosPreco = $_POST[Colunas::ITEM_DE_PRODUTO_PRECO];*/
        
        if (isset($_POST[Colunas::PRODUTO])) {
            $this->exibirFormasDePagamento();
        }
        else {
            if ($_POST['pagamento'] === 'boleto') {
                echo 'Boleto';
            }
            else {
                echo 'Cartão';
            }
        }
    }
    
    private function exibirFormasDePagamento() {
        $this->exibirConteudo(
            $this->contruirFormulario()
        );
    }
    
    private function contruirFormulario() {
        $conteudo = '<form action="/view/pagamentoView.php" method="POST">
            <div>
                <span class="label">Escolha sua forma de pagamento:</span>
                    
                <input type="radio" id="formaUm" name="pagamento" value="boleto" checked>
                <label for="formaUm">Bolento Bancário</label>
                    
                <input type="radio" id="formaDois" name="pagamento" value="cartao">
                <label for="formaDois">Cartão de Crédito</label>
            </div>
            
            <div>
                <input type="submit" name="pagar" value="Pagar">
            </div>
        </form>';
        
        return $conteudo;
    }
    
    private function exibirConteudo($conteudo) {
        cabecalhoHTML('Formas de Pagamento');
        cabecalho('Super Cabeçalho');
        echo $conteudo;
        rodape('Super Rodapé');
        rodapeHTML();
    }

}

new PagamentoView();

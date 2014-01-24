<?php

require_once '../config.php';
require_once DIR_ROOT . 'controller/loginController.php';
require_once DIR_ROOT . 'controller/pagamentoController.php';

class PagamentoView {

    public function __construct() {
        if (LoginController::testarLogin()) {
            $this->rotear();
        }
        else {
            LoginController::exibirConteudo(
                LoginController::construirFormulario('/view/carrinhoDeComprasView.php')
            );
        }
    }

    private function rotear() {
        if (isset($_POST[Colunas::PRODUTO_ID])) {
            $this->exibirFormasDePagamento();
            $_SESSION[Colunas::ITEM_DE_PRODUTO_QUANTIDADE] = $_POST[Colunas::ITEM_DE_PRODUTO_QUANTIDADE];
        }
        else {
            if ($_POST['pagamento'] === 'boleto') {
                header('Location: boletoBancarioView.php');
            }
            else {
                header('Location: cartaoDeCreditoView.php');
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

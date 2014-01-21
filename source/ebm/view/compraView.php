<?php

require_once 'baseView.php';
require_once DIR_ROOT . 'controller/compraController.php';
require_once DIR_ROOT . 'controller/usuarioController.php';
require_once DIR_ROOT . 'entity/compraModel.php';
require_once DIR_ROOT . 'entity/usuarioModel.php';
require_once DIR_ROOT . 'view/template/compraEdicao.php';

class CompraView extends BaseView {

    public function __construct() {
        $this->controller = new CompraController();
        if ($this->controller->testarLoginAdministrador()) {
            $this->rotear();
        }
    }

    protected function rotear() {
        if (isset($_POST[Colunas::COMPRA_ID])) {
            $compra = $this->controller->construirObjeto(
                array (
                    Colunas::COMPRA_ID => $_POST[Colunas::COMPRA_ID],
                    Colunas::COMPRA_DATA => $_POST[Colunas::COMPRA_DATA],
                    Colunas::COMPRA_TOTAL => $_POST[Colunas::COMPRA_TOTAL],
                    Colunas::COMPRA_FK_USUARIO => $_POST[Colunas::COMPRA_FK_USUARIO]
                )
            );
            $trueFalse = $this->controller->rotearInsercao($compra);
            $this->exibirMensagemCadastro(
                'Compra', $trueFalse
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
                'Compra', Colunas::COMPRA_ID,
                Colunas::COMPRA
            );
        }
        else {
            $this->listar();
        }
    }

    protected function cadastrar() {
        $compra = Compra::getNullObject();
        $this->exibirConteudo(
            construirFormulario($compra)
        );
    }

    protected function listar() {
        $array = $this->controller->listar(Colunas::COMPRA);
        $conteudo = criarTabela(
            'Compras Cadastradas', 'compraView',
            array(
                'Data', 'Total', 'Comprador'
            )
        );

        foreach ($array as $linha) {
            $conteudo .= $this->construirTabela($linha);
        }

        $this->exibirConteudo($conteudo . '</tbody></table>');
    }
    
    protected function construirTabela($linha) {
        $conteudo = '<tr><td><a href="compraView.php?editar=true&id=' . $linha[Colunas::COMPRA_ID] . '">'
            . $linha[Colunas::COMPRA_DATA] . '</a></td>'
            . '<td>' . $linha[Colunas::COMPRA_TOTAL] . '</td>'
            . '<td>' . $this->controller->getUserName($linha) . '</td>'
            . '<td><form action="compraView.php" method="POST"><button type="submit" name="deletar"'
            . 'value="' . $linha[Colunas::COMPRA_ID] . '">Deletar</button></form></td></tr>';
        
        return $conteudo;
    }

    protected function alterar() {
        $compra = $this->controller->construirObjetoPorId($_GET['id']);

        $this->exibirConteudo(
            construirFormulario($compra)
        );
    }
    
    protected function exibirConteudo($conteudo) {
        cabecalhoHTML('Cadastro de Compras');
        cabecalho('Super Cabeçalho');
        echo $conteudo;
        rodape('Super Rodapé');
        rodapeHTML();
    }

}

new CompraView();

<?php

require_once 'baseView.php';
require_once ROOT . 'controller/compraController.php';
require_once ROOT . 'controller/usuarioController.php';
require_once ROOT . 'entity/compraModel.php';
require_once ROOT . 'entity/usuarioModel.php';
require_once ROOT . 'view/template/compraEdicao.php';

class CompraView extends BaseView {

    private $usuarioController;

    public function __construct() {
        $this->controller = new CompraController();
        $this->usuarioController = new UsuarioController();
        if ($this->controller->testarLogin()) {
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
            $this->exibirMensagem(
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
            . '<td>' . $this->getUserName($linha) . '</td>'
            . '<td><form action="compraView.php" method="POST"><button type="submit" name="deletar"'
            . 'value="' . $linha[Colunas::COMPRA_ID] . '">Deletar</button></form></td></tr>';
        
        return $conteudo;
    }
    
    private function getUserName($linha) {
        $nomeUsuario = $this->usuarioController->getById(
            $linha[Colunas::COMPRA_FK_USUARIO]
        )[Colunas::USUARIO_NOME];
        
        return $nomeUsuario;
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

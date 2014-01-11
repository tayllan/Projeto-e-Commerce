<?php

require_once 'baseView.php';
require_once ROOT . 'controller/regiaoController.php';
require_once ROOT . 'entity/regiaoModel.php';
require_once ROOT . 'view/template/regiaoEdicao.php';

class RegiaoView extends BaseView {

    public function __construct() {
        $this->controller = new RegiaoController();
        if ($this->controller->testarLogin()) {
            $this->rotear();
        }
    }

    protected function rotear() {
        if (isset($_POST[Colunas::REGIAO_ID])) {
            $regiao = $this->controller->construirObjeto(
                array(
                    Colunas::REGIAO_ID => $_POST[Colunas::REGIAO_ID],
                    Colunas::REGIAO_NOME => $_POST[Colunas::REGIAO_NOME]
                )
            );
            $trueFalse = $this->controller->rotearInsercao($regiao);
            $this->exibirMensagem(
                'Região', $trueFalse
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
                'Região', Colunas::REGIAO_ID, Colunas::REGIAO
            );
        }
        else {
            $this->listar();
        }
    }

    protected function cadastrar() {
        $regiao = Regiao::getNullObject();
        $this->exibirConteudo(
            construirFormulario($regiao)
        );
    }

    protected function listar() {
        $array = $this->controller->listar(Colunas::REGIAO);
        $conteudo = criarTabela(
            'Regiões Cadastradas', 'regiaoView', array('Nome')
        );

        foreach ($array as $linha) {
            $conteudo .= $this->construirTabela($linha);
        }

        $this->exibirConteudo($conteudo . '</tbody></table>');
    }

    protected function construirTabela($linha) {
        $conteudo = '<tr><td><a href="regiaoView.php?editar=true&id='
            . $linha[Colunas::REGIAO_ID] . '">' . $linha[Colunas::REGIAO_NOME] . '</a></td>'
            . '<td><form action="regiaoView.php" method="POST"><button type="submit" name="deletar"'
            . 'value="' . $linha[Colunas::REGIAO_ID] . '">Deletar</button></form></td></tr>';

        return $conteudo;
    }

    protected function alterar() {
        $regiao = $this->controller->construirObjetoPorId($_GET['id']);

        $this->exibirConteudo(
            construirFormulario($regiao)
        );
    }

    protected function exibirConteudo($conteudo) {
        cabecalhoHTML('Cadastro de Regiões');
        cabecalho('Super Cabeçalho');
        echo $conteudo;
        rodape('Super Rodapé');
        rodapeHTML();
    }

}

new RegiaoView();
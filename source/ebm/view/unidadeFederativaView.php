<?php

require_once 'baseView.php';
require_once DIR_ROOT . 'controller/unidadeFederativaController.php';
require_once DIR_ROOT . 'controller/regiaoController.php';
require_once DIR_ROOT . 'entity/unidadeFederativaModel.php';
require_once DIR_ROOT . 'entity/regiaoModel.php';
require_once DIR_ROOT . 'view/template/unidadeFederativaEdicao.php';

class UnidadeFederativaView extends BaseView {

    public function __construct() {
        $this->controller = new UnidadeFederativaController();
        if ($this->controller->testarLoginAdministrador()) {
            $this->rotear();
        }
    }

    protected function rotear() {
        if (isset($_POST[Colunas::UNIDADE_FEDERATIVA_ID])) {
            $unidadeFederativa = $this->controller->construirObjeto(
                array (
                    Colunas::UNIDADE_FEDERATIVA_ID => $_POST[Colunas::UNIDADE_FEDERATIVA_ID],
                    Colunas::UNIDADE_FEDERATIVA_NOME => $_POST[Colunas::UNIDADE_FEDERATIVA_NOME],
                    Colunas::UNIDADE_FEDERATIVA_SIGLA => $_POST[Colunas::UNIDADE_FEDERATIVA_SIGLA],
                    Colunas::UNIDADE_FEDERATIVA_FK_REGIAO => $_POST[Colunas::UNIDADE_FEDERATIVA_FK_REGIAO]
                )
            );
            $trueFalse = $this->controller->rotearInsercao($unidadeFederativa);
            $this->exibirMensagemCadastro(
                'Unidade Federativa', $trueFalse
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
                'Unidade Federativa', Colunas::UNIDADE_FEDERATIVA_ID,
                Colunas::UNIDADE_FEDERATIVA
            );
        }
        else {
            $this->listar();
        }
    }

    protected function cadastrar() {
        $unidadeFederativa = UnidadeFederativa::getNullObject();
        $this->exibirConteudo(
            construirFormulario($unidadeFederativa)
        );
    }

    protected function listar() {
        $array = $this->controller->listar(Colunas::UNIDADE_FEDERATIVA);
        $conteudo = criarTabela(
            'Unidades Federativas Cadastradas', 'unidadeFederativaView',
            array(
                'Nome', 'Sigla', 'Região'
            )
        );

        foreach ($array as $linha) {
            $conteudo .= $this->construirTabela($linha);
        }

        $this->exibirConteudo($conteudo . '</tbody></table>');
    }
    
    protected function construirTabela($linha) {
        $conteudo = '<tr><td><a href="unidadeFederativaView.php?editar=true&id='
            . $linha[Colunas::UNIDADE_FEDERATIVA_ID] . '">' . $linha[Colunas::UNIDADE_FEDERATIVA_NOME] . '</a></td>'
            . '<td>' . $linha[Colunas::UNIDADE_FEDERATIVA_SIGLA] . '</td>'
            . '<td>' . $this->controller->getRegionName($linha) . '</td>'
            . '<td><form action="unidadeFederativaView.php" method="POST"><button type="submit" name="deletar"'
            . 'value="' . $linha[Colunas::UNIDADE_FEDERATIVA_ID] . '">Deletar</button></form></td></tr>';
        
        return $conteudo;
    }

    protected function alterar() {
        $unidadeFederativa = $this->controller->construirObjetoPorId($_GET['id']);

        $this->exibirConteudo(
            construirFormulario($unidadeFederativa)
        );
    }
    
    protected function exibirConteudo($conteudo) {
        cabecalhoHTML('Cadastro de Unidades Federativas');
        cabecalho('Super Cabeçalho');
        echo $conteudo;
        rodape('Super Rodapé');
        rodapeHTML();
    }

}

new UnidadeFederativaView();

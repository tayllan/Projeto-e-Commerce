<?php

require_once 'baseView.php';
require_once ROOT . 'controller/enderecoController.php';
require_once ROOT . 'controller/cidadeController.php';
require_once ROOT . 'entity/enderecoModel.php';
require_once ROOT . 'entity/cidadeModel.php';
require_once ROOT . 'view/template/enderecoEdicao.php';

class EnderecoView extends BaseView {
    
    private $cidadeController;

    public function __construct() {
        $this->controller = new EnderecoController();
        $this->cidadeController = new CidadeController();
        if ($this->controller->testarLogin()) {
            $this->rotear();
        }
    }

    protected function rotear() {
        if (isset($_POST[Colunas::ENDERECO_ID])) {
            $endereco = $this->controller->construirObjeto(
                array (
                    Colunas::ENDERECO_ID => $_POST[Colunas::ENDERECO_ID],
                    Colunas::ENDERECO_BAIRRO => $_POST[Colunas::ENDERECO_BAIRRO],
                    Colunas::ENDERECO_CEP => $_POST[Colunas::ENDERECO_CEP],
                    Colunas::ENDERECO_RUA => $_POST[Colunas::ENDERECO_RUA],
                    Colunas::ENDERECO_NUMERO => $_POST[Colunas::ENDERECO_NUMERO],
                    Colunas::ENDERECO_FK_CIDADE => $_POST[Colunas::ENDERECO_FK_CIDADE],
                )
            );
            $trueFalse = $this->controller->rotearInsercao($endereco);
            $this->exibirMensagem(
                'Endereço', $trueFalse
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
                'Endereço', Colunas::ENDERECO_ID,
                Colunas::ENDERECO
            );
        }
        else {
            $this->listar();
        }
    }

    protected function cadastrar() {
        $endereco = Endereco::getNullObject();
        $this->exibirConteudo(
            construirFormulario($endereco)
        );
    }

    protected function listar() {
        $array = $this->controller->listar(Colunas::ENDERECO);
        $conteudo = criarTabela(
            'Endereços Cadastrados', 'enderecoView',
            array(
                'Bairro', 'CEP', 'Rua', 'Número', 'Cidade'
            )
        );

        foreach ($array as $linha) {
            $conteudo .= $this->construirTabela($linha);
        }

        $this->exibirConteudo($conteudo . '</tbody></table>');
    }
    
    protected function construirTabela($linha) {
        $conteudo = '<tr><td><a href="enderecoView.php?editar=true&id=' . $linha[Colunas::ENDERECO_ID] . '">'
            . $linha[Colunas::ENDERECO_BAIRRO] . '</a></td>'
            . '<td>' . $linha[Colunas::ENDERECO_CEP] . '</td>'
            . '<td>' . $linha[Colunas::ENDERECO_RUA] . '</td>'
            . '<td>' . $linha[Colunas::ENDERECO_NUMERO] . '</td>'
            . '<td>' . $this->getCityName($linha) . '</td>'
            . '<td><form action="enderecoView.php" method="POST"><button type="submit" name="deletar"'
            . 'value="' . $linha[Colunas::ENDERECO_ID] . '">Deletar</button></form></td></tr>';
        
        return $conteudo;
    }
    
    private function getCityName($linha) {
        $nomeCidade = $this->cidadeController->getById(
            $linha[Colunas::ENDERECO_FK_CIDADE]
        )[Colunas::CIDADE_NOME];
        
        return $nomeCidade;
    }

    protected function alterar() {
        $endereco = $this->controller->construirObjetoPorId($_GET['id']);

        $this->exibirConteudo(
            construirFormulario($endereco)
        );
    }
    
    protected function exibirConteudo($conteudo) {
        cabecalhoHTML('Cadastro de Endereços');
        cabecalho('Super Cabeçalho');
        echo $conteudo;
        rodape('Super Rodapé');
        rodapeHTML();
    }

}

new EnderecoView();

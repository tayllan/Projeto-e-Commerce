<?php

require_once 'baseView.php';
require_once DIR_ROOT . 'controller/enderecoController.php';
require_once DIR_ROOT . 'controller/cidadeController.php';
require_once DIR_ROOT . 'entity/enderecoModel.php';
require_once DIR_ROOT . 'entity/cidadeModel.php';
require_once DIR_ROOT . 'view/template/enderecoEdicao.php';

class EnderecoView extends BaseView {

    public function __construct() {
        $this->controller = new EnderecoController();
        if ($this->controller->testarLoginAdministrador()) {
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
            $this->exibirMensagemCadastro(
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
            . '<td>' . $this->controller->getCityName($linha) . '</td>'
            . '<td><form action="enderecoView.php" method="POST"><button class="deletar" '
            . 'type="submit" name="deletar" '
            . 'value="' . $linha[Colunas::ENDERECO_ID] . '">Deletar</button></form></td></tr>';
        
        return $conteudo;
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

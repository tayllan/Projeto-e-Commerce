<?php

require_once 'baseView.php';
require_once DIR_ROOT . 'controller/generoSexualController.php';
require_once DIR_ROOT . 'entity/generoSexualModel.php';
require_once DIR_ROOT . 'view/template/generoSexualEdicao.php';

class GeneroSexualView extends BaseView {

    public function __construct() {
        $this->controller = new GeneroSexualController();
        if ($this->controller->testarLoginAdministrador()) {
            $this->rotear();
        }
    }

    protected function rotear() {
        if (isset($_POST[Colunas::GENERO_SEXUAL_ID])) {
            $generoSexual = $this->controller->construirObjeto(
                array (
                    Colunas::GENERO_SEXUAL_ID => $_POST[Colunas::GENERO_SEXUAL_ID],
                    Colunas::GENERO_SEXUAL_NOME=> $_POST[Colunas::GENERO_SEXUAL_NOME]
                )
            );
            $trueFalse = $this->controller->rotearInsercao($generoSexual);
            $this->exibirMensagemCadastro(
                'Gênero Sexual', $trueFalse
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
                'Gênero Sexual', Colunas::GENERO_SEXUAL_ID,
                Colunas::GENERO_SEXUAL
            );
        }
        else {
            $this->listar();
        }
    }

    protected function cadastrar() {
        $generoSexual = GeneroSexual::getNullObject();
        $this->exibirConteudo(
            construirFormulario($generoSexual)
        );
    }

    protected function listar() {
        $array = $this->controller->listar(Colunas::GENERO_SEXUAL);
        $conteudo = criarTabela(
            'Gêneros Sexuais Cadastrados', 'generoSexualView',
            array('Nome')
        );

        foreach ($array as $linha) {
            $conteudo .= $this->construirTabela($linha);
        }

        $this->exibirConteudo($conteudo . '</tbody></table>');
    }
    
    protected function construirTabela($linha) {
        $conteudo = '<tr><td><a href="generoSexualView.php?editar=true&id='
            . $linha[Colunas::GENERO_SEXUAL_ID] . '">'
            . $linha[Colunas::GENERO_SEXUAL_NOME] . '</a></td>'
            . '<td><form action="generoSexualView.php" method="POST"><button class="deletar" '
            . 'type="submit" name="deletar" '
            . 'value="' . $linha[Colunas::GENERO_SEXUAL_ID] . '">Deletar</button></form></td></tr>';
        
        return $conteudo;
    }

    protected function alterar() {
        $generoSexual = $this->controller->construirObjetoPorId($_GET['id']);
        
        $this->exibirConteudo(
            construirFormulario($generoSexual)
        );
    }
    
    protected function exibirConteudo($conteudo) {
        cabecalhoHTML('Cadastro de Gêneros Sexuais');
        cabecalho('Super Cabeçalho');
        echo $conteudo;
        rodape('Super Rodapé');
        rodapeHTML();
    }

}

new GeneroSexualView();
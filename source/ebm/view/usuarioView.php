<?php

require_once 'baseView.php';
require_once ROOT . 'controller/usuarioController.php';
require_once ROOT . 'controller/enderecoController.php';
require_once ROOT . 'controller/generoSexualController.php';
require_once ROOT . 'entity/usuarioModel.php';
require_once ROOT . 'entity/enderecoModel.php';
require_once ROOT . 'entity/generoSexualModel.php';
require_once ROOT . 'view/template/usuarioEdicao.php';

class UsuarioView extends BaseView {
    
    private $enderecoController;
    private $generoSexualController;

    public function __construct() {
        $this->controller = new UsuarioController();
        $this->enderecoController = new EnderecoController();
        $this->generoSexualController = new GeneroSexualController();
        if ($this->controller->testarLogin()) {
            $this->rotear();
        }
    }

    protected function rotear() {
        if (isset($_POST[Colunas::USUARIO_ID])) {
            $usuario = $this->controller->construirObjeto(
                array (
                    Colunas::USUARIO_ID => $_POST[Colunas::USUARIO_ID],
                    Colunas::USUARIO_NOME => $_POST[Colunas::USUARIO_NOME],
                    Colunas::USUARIO_LOGIN => $_POST[Colunas::USUARIO_LOGIN],
                    Colunas::USUARIO_SENHA => $_POST[Colunas::USUARIO_SENHA],
                    Colunas::USUARIO_CPF => $_POST[Colunas::USUARIO_CPF],
                    Colunas::USUARIO_TELEFONE => $_POST[Colunas::USUARIO_TELEFONE],
                    Colunas::USUARIO_DATA_DE_NASCIMENTO => $_POST[Colunas::USUARIO_DATA_DE_NASCIMENTO],
                    Colunas::USUARIO_ADMINISTRADOR => $_POST[Colunas::USUARIO_ADMINISTRADOR],
                    Colunas::USUARIO_FK_ENDERECO => $_POST[Colunas::USUARIO_FK_ENDERECO],
                    Colunas::USUARIO_FK_GENERO_SEXUAL => $_POST[Colunas::USUARIO_FK_GENERO_SEXUAL]
                )
            );
            $trueFalse = $this->controller->rotearInsercao($usuario);
            $this->exibirMensagem(
                'Usuario', $trueFalse
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
                'Usuario', Colunas::USUARIO_ID,
                Colunas::USUARIO
            );
        }
        else {
            $this->listar();
        }
    }

    protected function cadastrar() {
        $usuario = Usuario::getNullObject();
        $this->exibirConteudo(
            construirFormulario($usuario)
        );
    }

    protected function listar() {
        $array = $this->controller->listar(Colunas::USUARIO);
        $conteudo = criarTabela(
            'Usuarios Cadastrados', 'usuarioView',
            array(
                'Nome', 'Login',
                'Senha', 'CPF',
                'Telefone', 'Data de Nascimento',
                'Administrador ?', 'Endereço',
                'Gênero Sexual'
            )
        );

        foreach ($array as $linha) {
            $linha[Colunas::USUARIO_ADMINISTRADOR] = ajustarPermissao($linha[Colunas::USUARIO_ADMINISTRADOR]);
            
            $conteudo .= $this->construirTabela($linha);
        }

        $this->exibirConteudo($conteudo . '</tbody></table>');
    }
    
    protected function construirTabela($linha) {
        $conteudo = '<tr><td><a href="usuarioView.php?editar=true&id='
            . $linha[Colunas::USUARIO_ID] . '">' . $linha[Colunas::USUARIO_NOME] . '</a></td>'
            . '<td>' . $linha[Colunas::USUARIO_LOGIN] . '</td>'
            . '<td>**********</td>'
            . '<td>' . $linha[Colunas::USUARIO_CPF] . '</td>'
            . '<td>' . $linha[Colunas::USUARIO_TELEFONE] . '</td>'
            . '<td>' . $linha[Colunas::USUARIO_DATA_DE_NASCIMENTO] . '</td>'
            . '<td>' . $linha[Colunas::USUARIO_ADMINISTRADOR] . '</td>'
            . '<td>' . $this->getAddressName($linha) . '</td>'
            . '<td>' . $this->getGenderName($linha) . '</td>'
            . '<td><form action="usuarioView.php" method="POST"><button type="submit" name="deletar"'
            . 'value="' . $linha[Colunas::USUARIO_ID] . '">Deletar</button></form></td></tr>';
        
        return $conteudo;
    }
    
    private function getAddressName($linha) {
        $arrayEndereco = $this->enderecoController->getById(
            $linha[Colunas::USUARIO_FK_ENDERECO]
        );
        $nomeEndereco = $arrayEndereco[Colunas::ENDERECO_BAIRRO] . ' '
            . $arrayEndereco[Colunas::ENDERECO_RUA] . ' '
            . $arrayEndereco[Colunas::ENDERECO_NUMERO] . ' '
            . $arrayEndereco[Colunas::ENDERECO_CEP];
        
        return $nomeEndereco;
    }
    
    private function getGenderName($linha) {
        $nomeGenero = $this->generoSexualController->getById(
            $linha[Colunas::USUARIO_FK_GENERO_SEXUAL]
        )[Colunas::GENERO_SEXUAL_NOME];
        
        return $nomeGenero;            
    }

    protected function alterar() {
        $usuario = $this->controller->construirObjetoPorId($_GET['id']);

        $this->exibirConteudo(
            construirFormulario($usuario)
        );
    }
    
    protected function exibirConteudo($conteudo) {
        cabecalhoHTML('Cadastro de Usuarios');
        cabecalho('Super Cabeçalho');
        echo $conteudo;
        rodape('Super Rodapé');
        rodapeHTML();
    }

}

new UsuarioView();

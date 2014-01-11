<?php

require_once '../config.php';
require_once ROOT . 'view/template/html.php';
require_once ROOT . 'view/template/listagens.php';

abstract class BaseView {

    protected $controller;

    abstract protected function rotear();

    abstract protected function cadastrar();

    abstract protected function listar();
    
    abstract protected function construirTabela($linha);

    abstract protected function alterar();

    protected function deletar($apelidoDaTabela, $nomeColunaIdDaTabela, $nomeDaTabela) {
        $trueFalse = $this->controller->deletar(
            $_POST['deletar'], $nomeColunaIdDaTabela,
            $nomeDaTabela
        );

        if ($trueFalse) {
            $this->exibirConteudo($apelidoDaTabela . MENSAGEM_DELECAO_SUCESSO);
        }
        else {
            $this->exibirConteudo(MENSAGEM_ERRO);
        }
    }
    
    protected function exibirMensagem($apelidoDaTabela, $trueFalse) {
        if ($trueFalse) {
            $this->exibirConteudo($apelidoDaTabela . MENSAGEM_CADASTRO_SUCESSO);
        }
        else {
            $this->exibirConteudo(MENSAGEM_ERRO);
        }
    }

}
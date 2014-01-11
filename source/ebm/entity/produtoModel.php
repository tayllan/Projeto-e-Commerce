<?php

require_once 'marcaDeProdutoModel.php';
require_once 'categoriaDeProdutoModel.php';

class Produto {

    public $id;
    public $nome;
    public $marca;
    public $categoria;
    public $descricao;
    public $preco;
    public $quantidade;

    public function __construct($id, $nome, MarcaDeProduto $marca, CategoriaDeProduto $categoria,
        $descricao, $preco, $quantidade) {

        $this->id = $id;
        $this->marca = $marca;
        $this->categoria = $categoria;
        $this->descricao = $descricao;
        $this->nome = $nome;
        $this->preco = $preco;
        $this->quantidade = $quantidade;
    }
    
    static public function getNullObject() {
        return new Produto(
            NULL, NULL,
            MarcaDeProduto::getNullObject(), CategoriaDeProduto::getNullObject(),
            NULL, NULL,
            NULL
        );
    }

}

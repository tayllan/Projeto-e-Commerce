<?php

require_once 'usuarioModel.php';

class Compra {

    public $id;
    public $data;
    public $total;
    public $usuario;

    public function __construct($id, $data, $total, Usuario $usuario) {
        $this->id = $id;
        $this->data = $data;
        $this->total = $total;
        $this->usuario = $usuario;
    }
    
    static public function getNullObject() {
        return new Compra(
            NULL, NULL,
            NULL, Usuario::getNullObject()
        );
    }

}

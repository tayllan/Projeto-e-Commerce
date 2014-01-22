<?php

require_once DIR_ROOT . 'entity/compraModel.php';
require_once DIR_ROOT . 'controller/usuarioController.php';
require_once 'baseController.php';

class CompraController extends BaseController {
    
    private $usuarioController;
    
    public function __construct() {
        parent::__construct();
        $this->usuarioController = new UsuarioController();
    }

    protected function inserir($compra) {
        $sqlQuery = $this->conexao->prepare(
            'INSERT INTO ' . Colunas::COMPRA . ' (' . Colunas::COMPRA_DATA . ', '
            . Colunas::COMPRA_TOTAL. ', ' . Colunas::COMPRA_FK_USUARIO . ') VALUES (?, ?, ?)'
        );

        return $sqlQuery->execute(
                array(
                    $compra->data, $compra->total,
                    $compra->usuario->id
                )
        );
    }

    protected function alterar($compra) {
        $sqlQuery = $this->conexao->prepare(
            'UPDATE ' . Colunas::COMPRA . ' SET ' . Colunas::COMPRA_DATA . ' = ?, '
            . Colunas::COMPRA_TOTAL . ' = ?, ' . Colunas::COMPRA_FK_USUARIO . ' = ? WHERE '
            . Colunas::COMPRA_ID . ' = ?'
        );

        return $sqlQuery->execute(
                array(
                    $compra->data, $compra->total,
                    $compra->usuario->id, $compra->id
                )
        );
    }

    public function getById($id) {
        $sqlQuery = $this->conexao->prepare(
            'SELECT * FROM ' . Colunas::COMPRA . ' WHERE ' . Colunas::COMPRA_ID . ' = ?'
        );

        $sqlQuery->execute(
            array($id)
        );
        
        if ($sqlQuery->rowCount() > 0) {
            return $sqlQuery->fetch(PDO::FETCH_ASSOC);
        }
        else {
            return array();
        }
    }

    public function getId($compra) {
        $sqlQuery = $this->conexao->prepare(
            'SELECT ' . Colunas::COMPRA_ID . ' FROM ' . Colunas::COMPRA . ' WHERE '
            . Colunas::COMPRA_DATA . ' = ? AND ' . Colunas::COMPRA_TOTAL . ' = ? AND '
            . Colunas::COMPRA_FK_USUARIO . ' = ?'
        );

        $sqlQuery->execute(
                array(
                    $compra->data, $compra->total,
                    $compra->usuario->id
                )
        );
        
        if ($sqlQuery->rowCount() > 0) {
            return $sqlQuery->fetch(PDO::FETCH_ASSOC);
        }
        else {
            return array();
        }
    }

    public function construirObjeto(array $codigosIdentificadores = NULL) {
        $usuario = $this->usuarioController->construirObjetoPorId(
            $codigosIdentificadores[Colunas::COMPRA_FK_USUARIO]
        );
        $compra = new Compra(
            $codigosIdentificadores[Colunas::COMPRA_ID],
            $codigosIdentificadores[Colunas::COMPRA_DATA],
            $codigosIdentificadores[Colunas::COMPRA_TOTAL],
            $usuario
        );

        return $compra;
    }

    public function construirObjetoPorId($id) {
        $arrayCompra = $this->getById($id);
        $usuario = $this->usuarioController->construirObjetoPorId(
            $arrayCompra[Colunas::COMPRA_FK_USUARIO]
        );
        $compra = new Compra(
            $arrayCompra[Colunas::COMPRA_ID], $arrayCompra[Colunas::COMPRA_DATA],
            $arrayCompra[Colunas::COMPRA_TOTAL], $usuario
        );

        return $compra;
    }
    
    public function getUserName($linha) {
        $nomeUsuario = $this->usuarioController->getById(
            $linha[Colunas::COMPRA_FK_USUARIO]
        )[Colunas::USUARIO_NOME];
        
        return $nomeUsuario;
    }

}

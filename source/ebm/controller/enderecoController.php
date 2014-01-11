<?php

require_once ROOT . 'entity/enderecoModel.php';
require_once ROOT . 'controller/cidadeController.php';
require_once 'baseController.php';

class EnderecoController extends BaseController {
    
    private $cidade;
    
    public function __construct() {
        parent::__construct();
        $this->cidade = new CidadeController();
    }

    protected function inserir($endereco) {
        $sqlQuery = $this->conexao->prepare(
            'INSERT INTO ' . Colunas::ENDERECO . ' (' . Colunas::ENDERECO_BAIRRO
            . ', ' . Colunas::ENDERECO_CEP
            . ', ' . Colunas::ENDERECO_RUA . ', ' . Colunas::ENDERECO_NUMERO
            . ', ' . Colunas::ENDERECO_FK_CIDADE . ') VALUES (?, ?, ?, ?, ?)'
        );

        return $sqlQuery->execute(
                array(
                    $endereco->bairro, $endereco->cep,
                    $endereco->rua, $endereco->numero,
                    $endereco->cidade->id
                )
        );
    }

    protected function alterar($endereco) {
        $sqlQuery = $this->conexao->prepare(
            'UPDATE ' . Colunas::ENDERECO . ' SET ' . Colunas::ENDERECO_BAIRRO 
            . ' = ?, ' . Colunas::ENDERECO_CEP
            . ' = ?, ' . Colunas::ENDERECO_RUA . ' = ?, ' . Colunas::ENDERECO_NUMERO
            . ' = ?, ' . Colunas::ENDERECO_FK_CIDADE . ' = ? WHERE ' . Colunas::ENDERECO_ID . ' = ?'
        );

        return $sqlQuery->execute(
                array(
                    $endereco->bairro, $endereco->cep,
                    $endereco->rua, $endereco->numero,
                    $endereco->cidade->id, $endereco->id
                )
        );
    }

    public function getById($id) {
        $sqlQuery = $this->conexao->prepare(
            'SELECT * FROM ' . Colunas::ENDERECO . ' WHERE ' . Colunas::ENDERECO_ID . ' = ?'
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

    public function getId($endereco) {
        $sqlQuery = $this->conexao->prepare(
            'SELECT ' . Colunas::ENDERECO_ID . ' FROM ' . Colunas::ENDERECO
            . ' WHERE ' . Colunas::ENDERECO_BAIRRO
            . ' = ? AND ' . Colunas::ENDERECO_CEP . ' = ? AND ' . Colunas::ENDERECO_RUA
            . ' = ? AND ' . Colunas::ENDERECO_NUMERO . ' = ? AND ' . Colunas::ENDERECO_FK_CIDADE . ' = ?'
        );

        $sqlQuery->execute(
                array(
                    $endereco->id, $endereco->bairro,
                    $endereco->cep, $endereco->rua,
                    $endereco->numero, $endereco->cidade->id
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
        $cidade = $this->cidade->construirObjetoPorId(
            $codigosIdentificadores[Colunas::ENDERECO_FK_CIDADE]
        );
        $endereco = new Endereco(
            $codigosIdentificadores[Colunas::ENDERECO_ID],
            $codigosIdentificadores[Colunas::ENDERECO_BAIRRO],
            $codigosIdentificadores[Colunas::ENDERECO_CEP],
            $codigosIdentificadores[Colunas::ENDERECO_RUA],
            $codigosIdentificadores[Colunas::ENDERECO_NUMERO],
            $cidade
        );

        return $endereco;
    }

    public function construirObjetoPorId($id) {
        $arrayEndereco = $this->getById($id);
        $cidade = $this->cidade->construirObjetoPorId(
            $arrayEndereco[Colunas::ENDERECO_FK_CIDADE]
        );
        $endereco = new Endereco(
            $arrayEndereco[Colunas::ENDERECO_ID],
            $arrayEndereco[Colunas::ENDERECO_BAIRRO],
            $arrayEndereco[Colunas::ENDERECO_CEP],
            $arrayEndereco[Colunas::ENDERECO_RUA],
            $arrayEndereco[Colunas::ENDERECO_NUMERO],
            $cidade
        );

        return $endereco;
    }

}

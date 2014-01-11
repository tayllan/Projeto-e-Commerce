<?php

require_once '../config.php';
require_once 'database.php';

abstract class BaseController extends DAO {

    public function rotearInsercao($objetoDaEntidade) {
        $id = $objetoDaEntidade->id;
        $array = $this->getById($id);

        if (empty($array)) {
            $trueFalse = $this->inserir($objetoDaEntidade);
        }
        else {
            $trueFalse = $this->alterar($objetoDaEntidade);
        }

        return $trueFalse;
    }

    public function listar($nomeDaTabela) {
        $sqlQuery = $this->conexao->query(
            $this->getSQLSelectAll($nomeDaTabela)
        );
        if ($sqlQuery->rowCount() > 0) {
            return $sqlQuery->fetchAll(PDO::FETCH_ASSOC);
        }
        else {
            return array();
        }
    }

    private function getSQLSelectAll($nomeDaTabela) {
        $sqlQuery = 'SELECT * FROM ' . $nomeDaTabela;

        return $sqlQuery;
    }

    public function testarLogin() {
        if (isset($_SESSION[SESSAO_USUARIO_PERMISSAO])) {
            return true;
            #$this->rotear();
        }
        else {
            header('Location: ../index.php');
        }
    }
    
    public function deletar($idDaTabela, $nomeColunaIdDaTabela, $nomeDaTabela) {
        $sqlQuery = $this->conexao->prepare(
            'DELETE FROM ' . $nomeDaTabela . ' WHERE ' . $nomeColunaIdDaTabela . ' = ?'
        );
        $sqlQuery->execute(
            array($idDaTabela)
        );

        if ($sqlQuery->rowCount() > 0) {
            return true;
        }
        else {
            return false;
        }
    }

    abstract protected function inserir($objetoDaEntidade);

    abstract protected function alterar($objetoDaEntidade);

    abstract public function getById($id);

    abstract public function construirObjeto(array $codigosIdentificadores = NULL);
    
    abstract public function construirObjetoPorId($id);
}

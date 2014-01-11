<?php

require_once ROOT . 'entity/usuarioModel.php';
require_once ROOT . 'controller/enderecoController.php';
require_once ROOT . 'controller/generoSexualController.php';
require_once 'baseController.php';

class UsuarioController extends BaseController {
    
    private $enderecoController;
    private $generoSexualController;
    
    public function __construct() {
        parent::__construct();
        $this->enderecoController = new EnderecoController();
        $this->generoSexualController = new GeneroSexualController();
    }
        
    protected function inserir($usuario) {
        $sqlQuery = $this->conexao->prepare(
            'INSERT INTO ' . Colunas::USUARIO . ' (' . Colunas::USUARIO_NOME . ', ' . Colunas::USUARIO_LOGIN
            . ', ' . Colunas::USUARIO_SENHA . ', ' . Colunas::USUARIO_CPF
            . ', ' . Colunas::USUARIO_TELEFONE . ', ' . Colunas::USUARIO_DATA_DE_NASCIMENTO
            . ', ' . Colunas::USUARIO_ADMINISTRADOR . ', ' . Colunas::USUARIO_FK_ENDERECO
            . ', ' . Colunas::USUARIO_FK_GENERO_SEXUAL . ') VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
        );
        
        return $sqlQuery->execute(
            array(
                $usuario->nome, $usuario->login,
                $usuario->senha, $usuario->cpf,
                $usuario->telefone, $usuario->dataDeNascimento,
                $usuario->administrador, $usuario->endereco->id,
                $usuario->generoSexual->id
            )
        );
    }
    
    protected function alterar($usuario) {
        $sqlQuery = $this->conexao->prepare(
            'UPDATE ' . Colunas::USUARIO . ' SET ' . Colunas::USUARIO_NOME . ' = ?, ' . Colunas::USUARIO_LOGIN
            . ' = ?, ' . Colunas::USUARIO_SENHA . ' = ?, ' . Colunas::USUARIO_CPF
            . ' = ?, ' . Colunas::USUARIO_TELEFONE . ' = ?, ' . Colunas::USUARIO_DATA_DE_NASCIMENTO
            . ' = ?, ' . Colunas::USUARIO_ADMINISTRADOR . ' = ?, ' . Colunas::USUARIO_FK_ENDERECO
            . ' = ?, ' . Colunas::USUARIO_FK_GENERO_SEXUAL . ' = ? WHERE ' . Colunas::USUARIO_ID . ' = ?'
        );
        if (strlen($usuario->senha) < 32) {
            $usuario->senha = md5($usuario->senha);
        }
        
        return $sqlQuery->execute(
            array(
                $usuario->nome, $usuario->login,
                $usuario->senha, $usuario->cpf,
                $usuario->telefone, $usuario->dataDeNascimento,
                $usuario->administrador, $usuario->endereco->id,
                $usuario->generoSexual->id, $usuario->id
            )
        );
    }
    
    public function getById($id) {
        $sqlQuery = $this->conexao->prepare(
            'SELECT * FROM ' . Colunas::USUARIO . ' WHERE ' . Colunas::USUARIO_ID . ' = ?'
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
    
    public function getId($usuario) {
        $sqlQuery = $this->conexao->prepare(
            'SELECT ' . Colunas::USUARIO_ID . ' FROM ' . Colunas::USUARIO . ' WHERE '
            . Colunas::USUARIO_LOGIN . ' LIKE ? AND '
            . Colunas::USUARIO_SENHA . ' LIKE ?'
        );
        
        $sqlQuery->execute(
            array(
                $usuario->login, md5($usuario->senha)
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
        $endereco = $this->enderecoController->construirObjetoPorId(
            $codigosIdentificadores[Colunas::USUARIO_FK_ENDERECO]
        );
        $generoSexual = $this->generoSexualController->construirObjetoPorId(
            $codigosIdentificadores[Colunas::USUARIO_FK_GENERO_SEXUAL]
        );
        $usuario = new Usuario(
            $codigosIdentificadores[Colunas::USUARIO_ID], $codigosIdentificadores[Colunas::USUARIO_NOME],
            $codigosIdentificadores[Colunas::USUARIO_LOGIN], $codigosIdentificadores[Colunas::USUARIO_SENHA],
            $codigosIdentificadores[Colunas::USUARIO_CPF], $codigosIdentificadores[Colunas::USUARIO_TELEFONE],
            $codigosIdentificadores[Colunas::USUARIO_DATA_DE_NASCIMENTO],
            $codigosIdentificadores[Colunas::USUARIO_ADMINISTRADOR],
            $endereco, $generoSexual
        );

        return $usuario;
    }
    
    public function construirObjetoPorId($id) {
        $arrayUsuario = $this->getById($id);
        $endereco = $this->enderecoController->construirObjetoPorId(
            $arrayUsuario[Colunas::USUARIO_FK_ENDERECO]
        );
        $generoSexual = $this->generoSexualController->construirObjetoPorId(
            $arrayUsuario[Colunas::USUARIO_FK_GENERO_SEXUAL]
        );
        $usuario = new Usuario(
            $arrayUsuario[Colunas::USUARIO_ID], $arrayUsuario[Colunas::USUARIO_NOME],
            $arrayUsuario[Colunas::USUARIO_LOGIN], $arrayUsuario[Colunas::USUARIO_SENHA],
            $arrayUsuario[Colunas::USUARIO_CPF], $arrayUsuario[Colunas::USUARIO_TELEFONE],
            $arrayUsuario[Colunas::USUARIO_DATA_DE_NASCIMENTO], $arrayUsuario[Colunas::USUARIO_ADMINISTRADOR],
            $endereco, $generoSexual
        );
        
        return $usuario;
    }

}

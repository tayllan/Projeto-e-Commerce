SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `ebm` DEFAULT CHARACTER SET utf8 ;
USE `ebm` ;

-- -----------------------------------------------------
-- Table `ebm`.`regiao`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ebm`.`regiao` ;

CREATE  TABLE IF NOT EXISTS `ebm`.`regiao` (
  `regiao_id` INT NULL AUTO_INCREMENT ,
  `regiao_nome` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`regiao_id`) ,
  UNIQUE INDEX `regiao_nome_UNIQUE` (`regiao_nome` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ebm`.`unidadeFederativa`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ebm`.`unidadeFederativa` ;

CREATE  TABLE IF NOT EXISTS `ebm`.`unidadeFederativa` (
  `unidade_federativa_id` INT NULL AUTO_INCREMENT ,
  `unidade_federativa_fk_id_regiao` INT NOT NULL ,
  `unidade_federativa_nome` VARCHAR(45) NOT NULL ,
  `unidade_federativa_sigla` VARCHAR(2) NOT NULL ,
  PRIMARY KEY (`unidade_federativa_id`) ,
  INDEX `fk_UnidadeFederativa_Regiao` (`unidade_federativa_fk_id_regiao` ASC) ,
  UNIQUE INDEX `unidade_federativa_nome_UNIQUE` (`unidade_federativa_nome` ASC) ,
  UNIQUE INDEX `unidade_federativa_sigla_UNIQUE` (`unidade_federativa_sigla` ASC) ,
  CONSTRAINT `fk_UnidadeFederativa_Regiao`
    FOREIGN KEY (`unidade_federativa_fk_id_regiao` )
    REFERENCES `ebm`.`regiao` (`regiao_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ebm`.`cidade`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ebm`.`cidade` ;

CREATE  TABLE IF NOT EXISTS `ebm`.`cidade` (
  `cidade_id` INT NULL AUTO_INCREMENT ,
  `cidade_fk_id_unidade_federativa` INT NOT NULL ,
  `cidade_nome` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`cidade_id`) ,
  INDEX `fk_Cidade_UnidadeFederativa` (`cidade_fk_id_unidade_federativa` ASC) ,
  CONSTRAINT `fk_Cidade_UnidadeFederativa`
    FOREIGN KEY (`cidade_fk_id_unidade_federativa` )
    REFERENCES `ebm`.`unidadeFederativa` (`unidade_federativa_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ebm`.`endereco`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ebm`.`endereco` ;

CREATE  TABLE IF NOT EXISTS `ebm`.`endereco` (
  `endereco_id` INT NULL AUTO_INCREMENT ,
  `endereco_fk_id_cidade` INT NOT NULL ,
  `endereco_bairro` VARCHAR(45) NOT NULL ,
  `endereco_cep` VARCHAR(8) NOT NULL ,
  `endereco_logradouro` VARCHAR(45) NOT NULL ,
  `endereco_numero` INT NOT NULL ,
  PRIMARY KEY (`endereco_id`) ,
  INDEX `fk_Endereco_Cidade` (`endereco_fk_id_cidade` ASC) ,
  CONSTRAINT `fk_Endereco_Cidade`
    FOREIGN KEY (`endereco_fk_id_cidade` )
    REFERENCES `ebm`.`cidade` (`cidade_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ebm`.`generoSexual`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ebm`.`generoSexual` ;

CREATE  TABLE IF NOT EXISTS `ebm`.`generoSexual` (
  `genero_sexual_id` INT NULL AUTO_INCREMENT ,
  `genero_sexual_nome` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`genero_sexual_id`) ,
  UNIQUE INDEX `genero_sexual_nome_UNIQUE` (`genero_sexual_nome` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ebm`.`usuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ebm`.`usuario` ;

CREATE  TABLE IF NOT EXISTS `ebm`.`usuario` (
  `usuario_id` INT NULL AUTO_INCREMENT ,
  `usuario_fk_id_endereco` INT NOT NULL ,
  `usuario_fk_id_genero_sexual` INT NOT NULL ,
  `usuario_nome` VARCHAR(45) NOT NULL ,
  `usuario_senha` VARCHAR(45) NOT NULL ,
  `usuario_data_de_nascimento` DATE NOT NULL COMMENT '\n' ,
  `usuario_cpf` VARCHAR(11) NOT NULL ,
  `usuario_email` VARCHAR(45) NOT NULL ,
  `usuario_telefone` VARCHAR(45) NOT NULL ,
  `usuario_permissao` TINYINT(1) NOT NULL DEFAULT FALSE ,
  `usuario_ativo` TINYINT(1) NOT NULL DEFAULT TRUE ,
  PRIMARY KEY (`usuario_id`) ,
  INDEX `fk_Usuario_Endereco` (`usuario_fk_id_endereco` ASC) ,
  INDEX `fk_Usuario_GeneroSexual` (`usuario_fk_id_genero_sexual` ASC) ,
  UNIQUE INDEX `usuario_email_UNIQUE` (`usuario_email` ASC) ,
  CONSTRAINT `fk_Usuario_Endereco`
    FOREIGN KEY (`usuario_fk_id_endereco` )
    REFERENCES `ebm`.`endereco` (`endereco_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Usuario_GeneroSexual`
    FOREIGN KEY (`usuario_fk_id_genero_sexual` )
    REFERENCES `ebm`.`generoSexual` (`genero_sexual_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ebm`.`categoriaDeProduto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ebm`.`categoriaDeProduto` ;

CREATE  TABLE IF NOT EXISTS `ebm`.`categoriaDeProduto` (
  `categoria_de_produto_id` INT NULL AUTO_INCREMENT ,
  `categoria_de_produto_nome` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`categoria_de_produto_id`) ,
  UNIQUE INDEX `categoria_de_produto_nome_UNIQUE` (`categoria_de_produto_nome` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ebm`.`marcaDeProduto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ebm`.`marcaDeProduto` ;

CREATE  TABLE IF NOT EXISTS `ebm`.`marcaDeProduto` (
  `marca_de_produto_id` INT NULL AUTO_INCREMENT ,
  `marca_de_produto_nome` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`marca_de_produto_id`) ,
  UNIQUE INDEX `marca_de_produto_nome_UNIQUE` (`marca_de_produto_nome` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ebm`.`produto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ebm`.`produto` ;

CREATE  TABLE IF NOT EXISTS `ebm`.`produto` (
  `produto_id` INT NULL AUTO_INCREMENT ,
  `produto_fk_id_categoria_de_produto` INT NOT NULL ,
  `produto_fk_id_marca_de_produto` INT NOT NULL ,
  `produto_nome` VARCHAR(45) NOT NULL ,
  `produto_descricao` VARCHAR(45) NULL ,
  `produto_preco` FLOAT NOT NULL ,
  `produto_quantidade` INT NOT NULL ,
  `produto_caminho_imagem` VARCHAR(100) NULL ,
  PRIMARY KEY (`produto_id`) ,
  INDEX `fk_Produto_CategoriaDeProtudo` (`produto_fk_id_categoria_de_produto` ASC) ,
  INDEX `fk_Produto_Marca` (`produto_fk_id_marca_de_produto` ASC) ,
  UNIQUE INDEX `produto_nome_UNIQUE` (`produto_nome` ASC) ,
  CONSTRAINT `fk_Produto_CategoriaDeProtudo`
    FOREIGN KEY (`produto_fk_id_categoria_de_produto` )
    REFERENCES `ebm`.`categoriaDeProduto` (`categoria_de_produto_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Produto_Marca`
    FOREIGN KEY (`produto_fk_id_marca_de_produto` )
    REFERENCES `ebm`.`marcaDeProduto` (`marca_de_produto_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ebm`.`compra`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ebm`.`compra` ;

CREATE  TABLE IF NOT EXISTS `ebm`.`compra` (
  `compra_id` INT NULL AUTO_INCREMENT ,
  `compra_fk_id_usuario` INT NOT NULL ,
  `compra_data` VARCHAR(45) NOT NULL ,
  `compra_total` FLOAT NOT NULL ,
  `compra_concluida` TINYINT(1) NOT NULL DEFAULT FALSE ,
  `compra_forma_de_pagamento` VARCHAR(45) NOT NULL ,
  `compra_frete` FLOAT NOT NULL ,
  PRIMARY KEY (`compra_id`) ,
  INDEX `fk_Compra_Usuario` (`compra_fk_id_usuario` ASC) ,
  CONSTRAINT `fk_Compra_Usuario`
    FOREIGN KEY (`compra_fk_id_usuario` )
    REFERENCES `ebm`.`usuario` (`usuario_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ebm`.`itemDeProduto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ebm`.`itemDeProduto` ;

CREATE  TABLE IF NOT EXISTS `ebm`.`itemDeProduto` (
  `item_de_produto_id` INT NULL AUTO_INCREMENT ,
  `item_de_produto_fk_id_produto` INT NOT NULL ,
  `item_de_produto_fk_id_compra` INT NOT NULL ,
  `item_de_produto_quantidade` INT NOT NULL DEFAULT 1 ,
  `item_de_produto_preco` FLOAT NOT NULL ,
  INDEX `fk_ItemDeProduto_Produto` (`item_de_produto_fk_id_produto` ASC) ,
  PRIMARY KEY (`item_de_produto_id`) ,
  INDEX `fk_ItemDeProduto_Compra` (`item_de_produto_fk_id_compra` ASC) ,
  CONSTRAINT `fk_ItemDeProduto_Produto`
    FOREIGN KEY (`item_de_produto_fk_id_produto` )
    REFERENCES `ebm`.`produto` (`produto_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ItemDeProduto_Compra`
    FOREIGN KEY (`item_de_produto_fk_id_compra` )
    REFERENCES `ebm`.`compra` (`compra_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

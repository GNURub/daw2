-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema thecatlong
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `thecatlong` ;

-- -----------------------------------------------------
-- Schema thecatlong
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `thecatlong` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `thecatlong` ;

-- -----------------------------------------------------
-- Table `thecatlong`.`descuentos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `thecatlong`.`descuentos` (
  `iddescuento` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `fechainicio` DATE NULL COMMENT '',
  `fechafin` DATE NULL COMMENT '',
  `porcentaje` VARCHAR(45) NULL COMMENT '',
  PRIMARY KEY (`iddescuento`)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `thecatlong`.`productos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `thecatlong`.`productos` (
  `idproducto` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `titulo` VARCHAR(45) NULL COMMENT '',
  `descripcion` VARCHAR(45) NULL COMMENT '',
  `precio` DECIMAL NULL COMMENT '',
  `gatosdeenvio` DECIMAL NULL COMMENT '',
  `marca` VARCHAR(45) NULL COMMENT '',
  `createdAt` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT '',
  `iddescuento` INT NULL COMMENT '',
  `proveedor` VARCHAR(45) NULL DEFAULT 'local' COMMENT '',
  PRIMARY KEY (`idproducto`)  COMMENT '',
  INDEX `fk_productos_descuentos1_idx` (`iddescuento` ASC)  COMMENT '',
  CONSTRAINT `fk_productos_descuentos1`
    FOREIGN KEY (`iddescuento`)
    REFERENCES `thecatlong`.`descuentos` (`iddescuento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `thecatlong`.`metodosPago`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `thecatlong`.`metodosPago` (
  `idmetodo` VARCHAR(45) NOT NULL COMMENT '',
  PRIMARY KEY (`idmetodo`)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `thecatlong`.`usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `thecatlong`.`usuarios` (
  `username` VARCHAR(45) NOT NULL COMMENT '',
  `nombre` VARCHAR(45) NULL COMMENT '',
  `apellidos` VARCHAR(45) NULL COMMENT '',
  `createdAt` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT '',
  `email` VARCHAR(45) NULL COMMENT '',
  `telefono` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `direccion` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `orden` TINYINT(1) NULL DEFAULT 1 COMMENT '',
  `rol` VARCHAR(45) NULL DEFAULT 'cliente' COMMENT '',
  `password` VARCHAR(45) NULL COMMENT '',
  `public` TINYINT(1) NULL DEFAULT 0 COMMENT '',
  `provider` VARCHAR(45) NULL DEFAULT 'local' COMMENT '',
  `path` LONGTEXT NULL DEFAULT NULL COMMENT '',
  `estado` TEXT NULL DEFAULT NULL COMMENT '',
  `news` TINYINT(1) NULL DEFAULT 0 COMMENT '',
  `poblacion` VARCHAR(50) NULL DEFAULT NULL COMMENT '',
  `zip` VARCHAR(10) NULL DEFAULT NULL COMMENT '',
  `provincia` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  PRIMARY KEY (`username`)  COMMENT '',
  UNIQUE INDEX `email_UNIQUE` (`email` ASC)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `thecatlong`.`compras`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `thecatlong`.`compras` (
  `idcompra` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `idmetodo` VARCHAR(45) NULL COMMENT '',
  `hash_compra` VARCHAR(45) NOT NULL COMMENT '',
  `estado` VARCHAR(20) NULL COMMENT '',
  `fecha` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT '',
  `username` VARCHAR(45) NOT NULL COMMENT '',
  PRIMARY KEY (`idcompra`, `username`)  COMMENT '',
  INDEX `fk_compras_metodosPago1_idx` (`idmetodo` ASC)  COMMENT '',
  UNIQUE INDEX `hash_compra_UNIQUE` (`hash_compra` ASC)  COMMENT '',
  INDEX `fk_compras_usuarios1_idx` (`username` ASC)  COMMENT '',
  CONSTRAINT `fk_compras_metodosPago1`
    FOREIGN KEY (`idmetodo`)
    REFERENCES `thecatlong`.`metodosPago` (`idmetodo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_compras_usuarios1`
    FOREIGN KEY (`username`)
    REFERENCES `thecatlong`.`usuarios` (`username`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `thecatlong`.`categorias`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `thecatlong`.`categorias` (
  `idcategoria` VARCHAR(45) NOT NULL COMMENT '',
  PRIMARY KEY (`idcategoria`)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `thecatlong`.`imagenes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `thecatlong`.`imagenes` (
  `idimagen` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `path` LONGTEXT NULL COMMENT '',
  `idproducto` INT NOT NULL COMMENT '',
  PRIMARY KEY (`idimagen`)  COMMENT '',
  INDEX `fk_imagenes_productos1_idx` (`idproducto` ASC)  COMMENT '',
  CONSTRAINT `fk_imagenes_productos1`
    FOREIGN KEY (`idproducto`)
    REFERENCES `thecatlong`.`productos` (`idproducto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `thecatlong`.`caracteristicas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `thecatlong`.`caracteristicas` (
  `color` VARCHAR(10) NOT NULL COMMENT '',
  `talla` VARCHAR(10) NOT NULL COMMENT '',
  PRIMARY KEY (`color`, `talla`)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `thecatlong`.`color`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `thecatlong`.`color` (
  `idcolor` VARCHAR(45) NOT NULL COMMENT '',
  PRIMARY KEY (`idcolor`)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `thecatlong`.`tallas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `thecatlong`.`tallas` (
  `idtalla` VARCHAR(45) NOT NULL COMMENT '',
  PRIMARY KEY (`idtalla`)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `thecatlong`.`productos_tallas_colores`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `thecatlong`.`productos_tallas_colores` (
  `idproducto` INT NOT NULL COMMENT '',
  `stock` DECIMAL NULL COMMENT '',
  `idtalla` VARCHAR(45) NOT NULL COMMENT '',
  `idcolor` VARCHAR(45) NOT NULL COMMENT '',
  PRIMARY KEY (`idproducto`, `idtalla`, `idcolor`)  COMMENT '',
  INDEX `fk_productos_has_tallas_color_productos1_idx` (`idproducto` ASC)  COMMENT '',
  INDEX `fk_productos_tallas_colores_tallas1_idx` (`idtalla` ASC)  COMMENT '',
  INDEX `fk_productos_tallas_colores_color1_idx` (`idcolor` ASC)  COMMENT '',
  CONSTRAINT `fk_productos_has_tallas_color_productos1`
    FOREIGN KEY (`idproducto`)
    REFERENCES `thecatlong`.`productos` (`idproducto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_productos_tallas_colores_tallas1`
    FOREIGN KEY (`idtalla`)
    REFERENCES `thecatlong`.`tallas` (`idtalla`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_productos_tallas_colores_color1`
    FOREIGN KEY (`idcolor`)
    REFERENCES `thecatlong`.`color` (`idcolor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `thecatlong`.`compras_productos_tallas_colores`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `thecatlong`.`compras_productos_tallas_colores` (
  `idcompra` INT NOT NULL COMMENT '',
  `username` VARCHAR(45) NOT NULL COMMENT '',
  `cantidad` INT NULL COMMENT '',
  `idproducto` INT NOT NULL COMMENT '',
  `idtalla` VARCHAR(45) NOT NULL COMMENT '',
  `idcolor` VARCHAR(45) NOT NULL COMMENT '',
  PRIMARY KEY (`idcompra`, `username`, `idproducto`, `idtalla`, `idcolor`)  COMMENT '',
  INDEX `fk_compras_productos_tallas_colores_productos_tallas_colore_idx` (`idproducto` ASC, `idtalla` ASC, `idcolor` ASC)  COMMENT '',
  CONSTRAINT `fk_compras_has_productos_tallas_colores_compras1`
    FOREIGN KEY (`idcompra` , `username`)
    REFERENCES `thecatlong`.`compras` (`idcompra` , `username`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_compras_productos_tallas_colores_productos_tallas_colores1`
    FOREIGN KEY (`idproducto` , `idtalla` , `idcolor`)
    REFERENCES `thecatlong`.`productos_tallas_colores` (`idproducto` , `idtalla` , `idcolor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `thecatlong`.`subcategorias`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `thecatlong`.`subcategorias` (
  `idsubcategoria` VARCHAR(45) NOT NULL COMMENT '',
  PRIMARY KEY (`idsubcategoria`)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `thecatlong`.`subcategorias_categorias`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `thecatlong`.`subcategorias_categorias` (
  `idcategoria` VARCHAR(45) NOT NULL COMMENT '',
  `idsubcategoria` VARCHAR(45) NOT NULL COMMENT '',
  PRIMARY KEY (`idcategoria`, `idsubcategoria`)  COMMENT '',
  INDEX `fk_categorias_has_subcategorias_subcategorias1_idx` (`idsubcategoria` ASC)  COMMENT '',
  INDEX `fk_categorias_has_subcategorias_categorias1_idx` (`idcategoria` ASC)  COMMENT '',
  CONSTRAINT `fk_categorias_has_subcategorias_categorias1`
    FOREIGN KEY (`idcategoria`)
    REFERENCES `thecatlong`.`categorias` (`idcategoria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_categorias_has_subcategorias_subcategorias1`
    FOREIGN KEY (`idsubcategoria`)
    REFERENCES `thecatlong`.`subcategorias` (`idsubcategoria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `thecatlong`.`productos_subcategorias_categorias`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `thecatlong`.`productos_subcategorias_categorias` (
  `idproducto` INT NOT NULL COMMENT '',
  `idcategoria` VARCHAR(45) NOT NULL COMMENT '',
  `idsubcategoria` VARCHAR(45) NOT NULL COMMENT '',
  PRIMARY KEY (`idproducto`, `idcategoria`, `idsubcategoria`)  COMMENT '',
  INDEX `fk_productos_has_subcategorias_categorias_subcategorias_cat_idx` (`idcategoria` ASC, `idsubcategoria` ASC)  COMMENT '',
  INDEX `fk_productos_has_subcategorias_categorias_productos1_idx` (`idproducto` ASC)  COMMENT '',
  CONSTRAINT `fk_productos_has_subcategorias_categorias_productos1`
    FOREIGN KEY (`idproducto`)
    REFERENCES `thecatlong`.`productos` (`idproducto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_productos_has_subcategorias_categorias_subcategorias_categ1`
    FOREIGN KEY (`idcategoria` , `idsubcategoria`)
    REFERENCES `thecatlong`.`subcategorias_categorias` (`idcategoria` , `idsubcategoria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

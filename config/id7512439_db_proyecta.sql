SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `id7512439_db_proyecta` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `id7512439_db_proyecta` ;

-- -----------------------------------------------------
-- Table `id7512439_db_proyecta`.`perfil`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `id7512439_db_proyecta`.`perfil` ;

CREATE  TABLE IF NOT EXISTS `id7512439_db_proyecta`.`perfil` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `id7512439_db_proyecta`.`usuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `id7512439_db_proyecta`.`usuario` ;

CREATE  TABLE IF NOT EXISTS `id7512439_db_proyecta`.`usuario` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `username` VARCHAR(45) NOT NULL ,
  `password` VARCHAR(45) NOT NULL ,
  `estado` CHAR(1) NOT NULL ,
  `fecha_creacion` DATE NOT NULL ,
  `id_perfil` INT NOT NULL ,
  PRIMARY KEY (`id`, `id_perfil`) ,
  INDEX `fk_usuario_perfil1_idx` (`id_perfil` ASC) ,
  CONSTRAINT `fk_usuario_perfil1`
    FOREIGN KEY (`id_perfil` )
    REFERENCES `id7512439_db_proyecta`.`perfil` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `id7512439_db_proyecta`.`categoria`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `id7512439_db_proyecta`.`categoria` ;

CREATE  TABLE IF NOT EXISTS `id7512439_db_proyecta`.`categoria` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `id7512439_db_proyecta`.`proyecto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `id7512439_db_proyecta`.`proyecto` ;

CREATE  TABLE IF NOT EXISTS `id7512439_db_proyecta`.`proyecto` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `titulo` VARCHAR(70) NOT NULL ,
  `objeto` LONGTEXT NOT NULL ,
  `fundamento` LONGTEXT NOT NULL ,
  `beneficio` LONGTEXT NOT NULL ,
  `departamento` VARCHAR(45) NOT NULL ,
  `estado` CHAR(1) NOT NULL ,
  `fecha_creacion` DATE NOT NULL ,
  `id_categoria` INT NOT NULL ,
  `id_usuario` INT NOT NULL ,
  PRIMARY KEY (`id`, `id_categoria`, `id_usuario`) ,
  INDEX `fk_proyecto_categoria1_idx` (`id_categoria` ASC) ,
  INDEX `fk_proyecto_usuario1_idx` (`id_usuario` ASC) ,
  CONSTRAINT `fk_proyecto_categoria1`
    FOREIGN KEY (`id_categoria` )
    REFERENCES `id7512439_db_proyecta`.`categoria` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_proyecto_usuario1`
    FOREIGN KEY (`id_usuario` )
    REFERENCES `id7512439_db_proyecta`.`usuario` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `id7512439_db_proyecta`.`usuario_has_proyecto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `id7512439_db_proyecta`.`usuario_has_proyecto` ;

CREATE  TABLE IF NOT EXISTS `id7512439_db_proyecta`.`usuario_has_proyecto` (
  `id_usuario` INT NOT NULL ,
  `id_proyecto` INT NOT NULL ,
  `like` CHAR(1) NOT NULL ,
  `firma` CHAR(1) NOT NULL ,
  PRIMARY KEY (`id_usuario`, `id_proyecto`) ,
  INDEX `fk_usuario_has_proyecto_proyecto1_idx` (`id_proyecto` ASC) ,
  INDEX `fk_usuario_has_proyecto_usuario1_idx` (`id_usuario` ASC) ,
  CONSTRAINT `fk_usuario_has_proyecto_usuario1`
    FOREIGN KEY (`id_usuario` )
    REFERENCES `id7512439_db_proyecta`.`usuario` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_has_proyecto_proyecto1`
    FOREIGN KEY (`id_proyecto` )
    REFERENCES `id7512439_db_proyecta`.`proyecto` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `id7512439_db_proyecta`.`comentario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `id7512439_db_proyecta`.`comentario` ;

CREATE  TABLE IF NOT EXISTS `id7512439_db_proyecta`.`comentario` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `descripcion` VARCHAR(255) NOT NULL ,
  `like` CHAR(1) NOT NULL ,
  `id_usuario` INT NOT NULL ,
  `iid_proyecto` INT NOT NULL ,
  PRIMARY KEY (`id`, `id_usuario`, `iid_proyecto`) ,
  INDEX `fk_comentario_usuario_has_proyecto1_idx` (`id_usuario` ASC, `iid_proyecto` ASC) ,
  CONSTRAINT `fk_comentario_usuario_has_proyecto1`
    FOREIGN KEY (`id_usuario` , `iid_proyecto` )
    REFERENCES `id7512439_db_proyecta`.`usuario_has_proyecto` (`id_usuario` , `id_proyecto` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE `id7512439_db_proyecta` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `id7512439_db_proyecta`.`perfil`
-- -----------------------------------------------------
START TRANSACTION;
USE `id7512439_db_proyecta`;
INSERT INTO `id7512439_db_proyecta`.`perfil` (`id`, `nombre`) VALUES (NULL, 'ciudadano');

COMMIT;

-- -----------------------------------------------------
-- Data for table `id7512439_db_proyecta`.`usuario`
-- -----------------------------------------------------
START TRANSACTION;
USE `id7512439_db_proyecta`;
INSERT INTO `id7512439_db_proyecta`.`usuario` (`id`, `username`, `password`, `estado`, `fecha_creacion`, `id_perfil`) VALUES (NULL, '77050095', 'joel123', '1', 'date', 1);

COMMIT;

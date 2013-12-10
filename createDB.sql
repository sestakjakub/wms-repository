SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `wms` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `wms` ;

-- -----------------------------------------------------
-- Table `wms`.`wms`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wms`.`wms` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `wmsUrl` VARCHAR(200) NULL,
  `version` VARCHAR(45) NULL,
  `name` VARCHAR(45) NULL,
  `title` VARCHAR(45) NULL,
  `abstract` VARCHAR(45) NULL,
  `contactInformation` VARCHAR(45) NULL,
  `fees` VARCHAR(45) NULL,
  `accessConstraints` VARCHAR(45) NULL,
  `layerLimit` INT NULL,
  `maxWidth` INT NULL,
  `maxHeight` INT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wms`.`layer`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wms`.`layer` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `wms_id` INT NULL,
  `layer_id` INT NULL,
  `name` VARCHAR(45) NULL,
  `title` VARCHAR(45) NULL,
  `abstract` VARCHAR(45) NULL,
  `bBoxNorth` VARCHAR(45) NULL,
  `bBoxSouth` VARCHAR(45) NULL,
  `bBoxEast` VARCHAR(45) NULL,
  `bBoxWest` VARCHAR(45) NULL,
  `attribution` VARCHAR(45) NULL,
  `dataURL` VARCHAR(45) NULL,
  `featureListURL` VARCHAR(45) NULL,
  `minScale` VARCHAR(45) NULL,
  `maxScale` VARCHAR(45) NULL,
  `queryable` VARCHAR(45) NULL,
  `cascaded` VARCHAR(45) NULL,
  `opaque` VARCHAR(45) NULL,
  `noSubsets` VARCHAR(45) NULL,
  `fixedWidth` VARCHAR(45) NULL,
  `fixedHeight` VARCHAR(45) NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_layer_wms_idx` (`wms_id` ASC),
  INDEX `fk_layer_layer1_idx` (`layer_id` ASC),
  CONSTRAINT `fk_layer_wms`
    FOREIGN KEY (`wms_id`)
    REFERENCES `wms`.`wms` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_layer_layer1`
    FOREIGN KEY (`layer_id`)
    REFERENCES `wms`.`layer` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wms`.`onlineResource`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wms`.`onlineResource` (
  `id` INT NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wms`.`contactInformation`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wms`.`contactInformation` (
  `id` INT NOT NULL,
  `contactPersonPrimary` VARCHAR(45) NULL,
  `contactPosition` VARCHAR(45) NULL,
  `contactAddress` VARCHAR(45) NULL,
  `contactVoiceTelephone` VARCHAR(45) NULL,
  `contactFacsimileTelephone` VARCHAR(45) NULL,
  `contactElectronicMailAddress` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wms`.`keyword`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wms`.`keyword` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `keyword` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wms`.`crs`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wms`.`crs` (
)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wms`.`boundingBox`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wms`.`boundingBox` (
)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wms`.`wms_has_keyword`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wms`.`wms_has_keyword` (
  `wms_id` INT NOT NULL,
  `keyword_id` INT NOT NULL,
  PRIMARY KEY (`wms_id`, `keyword_id`),
  INDEX `fk_wms_has_keyword_keyword1_idx` (`keyword_id` ASC),
  INDEX `fk_wms_has_keyword_wms1_idx` (`wms_id` ASC),
  CONSTRAINT `fk_wms_has_keyword_wms1`
    FOREIGN KEY (`wms_id`)
    REFERENCES `wms`.`wms` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_wms_has_keyword_keyword1`
    FOREIGN KEY (`keyword_id`)
    REFERENCES `wms`.`keyword` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wms`.`wms_has_onlineResource`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wms`.`wms_has_onlineResource` (
  `wms_id` INT NOT NULL,
  `onlineResource_id` INT NOT NULL,
  PRIMARY KEY (`wms_id`, `onlineResource_id`),
  INDEX `fk_wms_has_onlineResource_onlineResource1_idx` (`onlineResource_id` ASC),
  INDEX `fk_wms_has_onlineResource_wms1_idx` (`wms_id` ASC),
  CONSTRAINT `fk_wms_has_onlineResource_wms1`
    FOREIGN KEY (`wms_id`)
    REFERENCES `wms`.`wms` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_wms_has_onlineResource_onlineResource1`
    FOREIGN KEY (`onlineResource_id`)
    REFERENCES `wms`.`onlineResource` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wms`.`layer_has_keyword`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wms`.`layer_has_keyword` (
  `layer_id` INT NOT NULL,
  `keyword_id` INT NOT NULL,
  PRIMARY KEY (`layer_id`, `keyword_id`),
  INDEX `fk_layer_has_keyword_keyword1_idx` (`keyword_id` ASC),
  INDEX `fk_layer_has_keyword_layer1_idx` (`layer_id` ASC),
  CONSTRAINT `fk_layer_has_keyword_layer1`
    FOREIGN KEY (`layer_id`)
    REFERENCES `wms`.`layer` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_layer_has_keyword_keyword1`
    FOREIGN KEY (`keyword_id`)
    REFERENCES `wms`.`keyword` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wms`.`style`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wms`.`style` (
)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

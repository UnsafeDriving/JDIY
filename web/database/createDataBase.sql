SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema JDIY (delete)
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `JDIY` ;

-- -----------------------------------------------------
-- Schema JDIY (create and use)
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `JDIY` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `JDIY` ;

-- -----------------------------------------------------
-- Table `JDIY`.`groups`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `JDIY`.`groups` ;

CREATE TABLE IF NOT EXISTS `JDIY`.`groups` (
  `groId` INT NOT NULL AUTO_INCREMENT,
  `groType` VARCHAR(45) NOT NULL,
  `groDescription` VARCHAR(100) NULL,
  PRIMARY KEY (`groId`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `JDIY`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `JDIY`.`users` ;

CREATE TABLE IF NOT EXISTS `JDIY`.`users` (
  `useId` INT NOT NULL AUTO_INCREMENT,
  `useFirstName` VARCHAR(65) NOT NULL,
  `useLastName` VARCHAR(65) NOT NULL,
  `useEmail` VARCHAR(100) NOT NULL,
  `usePassword` CHAR(40) NOT NULL,
  `useSession` CHAR(32) NULL,
  `useIp` CHAR(32) NULL,
  `useDateCreation` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `useGroup` INT NOT NULL,
  PRIMARY KEY (`useId`),
  INDEX `useGroup_idx` (`useGroup` ASC),
  CONSTRAINT `useGroup`
    FOREIGN KEY (`useGroup`)
    REFERENCES `JDIY`.`groups` (`groId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `JDIY`.`pages`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `JDIY`.`pages` ;

CREATE TABLE IF NOT EXISTS `JDIY`.`pages` (
  `pagId` INT NOT NULL AUTO_INCREMENT,
  `pagTitle` VARCHAR(100) NOT NULL,
  `pagContent` MEDIUMTEXT NOT NULL,
  `pagDateCreation` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pagDateLastUpdate` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `pagUser` INT NOT NULL,
  PRIMARY KEY (`pagId`),
  INDEX `pagUser_idx` (`pagUser` ASC),
  CONSTRAINT `pagUser`
    FOREIGN KEY (`pagUser`)
    REFERENCES `JDIY`.`users` (`useId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `JDIY`.`menu`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `JDIY`.`menu` ;

CREATE TABLE IF NOT EXISTS `JDIY`.`menu` (
  `menId` INT NOT NULL AUTO_INCREMENT,
  `menDescription` VARCHAR(30) NULL,
  `menPage` INT NOT NULL,
  `menParent` INT NULL,
  `menLevel` INT NOT NULL,
  PRIMARY KEY (`menId`),
  INDEX `menPage_idx` (`menPage` ASC),
  INDEX `menParent_idx` (`menParent` ASC),
  CONSTRAINT `menPage`
    FOREIGN KEY (`menPage`)
    REFERENCES `JDIY`.`pages` (`pagId`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `menParent`
    FOREIGN KEY (`menParent`)
    REFERENCES `JDIY`.`pages` (`pagId`)
    ON DELETE SET NULL
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `JDIY`.`roles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `JDIY`.`roles` ;

CREATE TABLE IF NOT EXISTS `JDIY`.`roles` (
  `rolId` INT NOT NULL AUTO_INCREMENT,
  `rolName` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`rolId`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `JDIY`.`groups_roles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `JDIY`.`groups_roles` ;

CREATE TABLE IF NOT EXISTS `JDIY`.`groups_roles` (
  `groId` INT NOT NULL,
  `rolId` INT NOT NULL,
  PRIMARY KEY (`groId`, `rolId`),
  INDEX `groId_idx` (`groId` ASC),
  INDEX `rolId_Idx` (`rolId` ASC),
  CONSTRAINT `groId`
    FOREIGN KEY (`groId`)
    REFERENCES `JDIY`.`groups` (`groId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `rolId`
    FOREIGN KEY (`rolId`)
    REFERENCES `JDIY`.`roles` (`rolId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `JDIY`.`comments`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `JDIY`.`comments` ;

CREATE TABLE IF NOT EXISTS `JDIY`.`comments` (
  `comId` INT NOT NULL AUTO_INCREMENT,
  `comText` VARCHAR(255) NOT NULL,
  `comDateCreation` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `comActivated` TINYINT(1) NOT NULL,
  `comPage` INT NOT NULL,
  PRIMARY KEY (`comId`),
  INDEX `comPage_idx` (`comPage` ASC),
  CONSTRAINT `comPage`
    FOREIGN KEY (`comPage`)
    REFERENCES `JDIY`.`pages` (`pagId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `JDIY`.`plugins`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `JDIY`.`plugins` ;

CREATE TABLE IF NOT EXISTS `JDIY`.`plugins` (
  `pluName` VARCHAR(45) NOT NULL,
  `pluDescription` VARCHAR(100) NULL,
  `pluVersion` VARCHAR(30) NULL,
  `pluActive` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`pluName`))
ENGINE = InnoDB;

USE `JDIY` ;

-- -----------------------------------------------------
-- Placeholder table for view `JDIY`.`displayUsers`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `JDIY`.`displayUsers` (`useId` INT, `useFirstName` INT, `useLastName` INT, `useEmail` INT, `useGroupId` INT, `useGroup` INT);

-- -----------------------------------------------------
-- View `JDIY`.`displayUsers`
-- -----------------------------------------------------
DROP VIEW IF EXISTS `JDIY`.`displayUsers` ;
DROP TABLE IF EXISTS `JDIY`.`displayUsers`;
USE `JDIY`;
CREATE  OR REPLACE VIEW `displayUsers` AS
SELECT `jdiy`.`users`.`useId` AS `useId`,`jdiy`.`users`.`useFirstName` AS `useFirstName`,`jdiy`.`users`.`useLastName` AS `useLastName`,`jdiy`.`users`.`useEmail` AS `useEmail`,`jdiy`.`users`.`useGroup` AS `useGroupId`,`jdiy`.`groups`.`groType` AS `useGroup`
FROM `jdiy`.`users` 
	INNER JOIN `jdiy`.`groups` 
		ON `jdiy`.`users`.`useGroup` = `jdiy`.`groups`.`groId`;
USE `JDIY`;

-- -----------------------------------------------------
-- Trigger `JDIY`.`addPageMenu`
-- -----------------------------------------------------
DELIMITER $$

USE `JDIY`$$
DROP TRIGGER IF EXISTS `JDIY`.`addPageMenu` $$
USE `JDIY`$$
CREATE TRIGGER `addPageMenu` AFTER INSERT ON `pages`
 FOR EACH ROW BEGIN
	DECLARE lastLevel integer;
    SELECT MAX(menLevel) INTO lastLevel FROM menu;
	
    IF (lastLevel IS NULL) THEN
      SET lastLevel = 0;
    ELSE
      SET lastLevel = lastLevel + 1;
    END IF;
    
    INSERT into menu (menPage, menParent, menLevel) VALUES (NEW.pagId, NULL, lastLevel);

END
    $$


DELIMITER ;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

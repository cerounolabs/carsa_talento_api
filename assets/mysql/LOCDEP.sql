CREATE TABLE IF NOT EXISTS `LOCDEP` (
    `LOCDEPCOD` mediumint(9) NOT NULL COMMENT 'CÓDIGO',
    `LOCDEPEST` char(1) COLLATE utf8_spanish_ci NOT NULL COMMENT 'ESTADO',
    `LOCDEPNOM` varchar(100) COLLATE utf8_spanish_ci NULL COMMENT 'NOMBRE',
    `LOCDEPEQU` mediumint(9) NULL COMMENT 'CÓDIGO EQUIVALENCIA',
    `LOCDEPOBS` varchar(5120) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'OBSERVACIÓN',
    `LOCDEPAUS` char(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'USUARIO',
    `LOCDEPAFH` datetime NOT NULL COMMENT 'FECHA HORA',
    `LOCDEPAIP` char(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'IP'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='LOCALIDAD DEPARTAMENTO';

CREATE TABLE IF NOT EXISTS `LOCDEPA` (
    `LOCDEPACOD` int(11) NOT NULL COMMENT 'CÓDIGO',
    `LOCDEPAMET` char(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'MÉTODO',
    `LOCDEPAUSU` char(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'USUARIO',
    `LOCDEPAFEC` datetime NOT NULL COMMENT 'FECHA HORA',
    `LOCDEPADIP` char(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'IP',

    `LOCDEPACODOLD` mediumint(9) NULL COMMENT 'CÓDIGO OLD',
    `LOCDEPAESTOLD` char(1) COLLATE utf8_spanish_ci NULL COMMENT 'ESTADO OLD',
    `LOCDEPANOMOLD` varchar(100) COLLATE utf8_spanish_ci NULL COMMENT 'NOMBRE OLD',
    `LOCDEPAEQUOLD` mediumint(9) NULL COMMENT 'CÓDIGO EQUIVALENCIA OLD',
    `LOCDEPAOBSOLD` varchar(5120) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'OBSERVACIÓN OLD',

    `LOCDEPACODNEW` mediumint(9) NOT NULL COMMENT 'CÓDIGO NEW',
    `LOCDEPAESTNEW` char(1) COLLATE utf8_spanish_ci NOT NULL COMMENT 'ESTADO NEW',
    `LOCDEPANOMNEW` varchar(100) COLLATE utf8_spanish_ci NULL COMMENT 'NOMBRE NEW',
    `LOCDEPAEQUNEW` mediumint(9) NULL COMMENT 'CÓDIGO EQUIVALENCIA NEW',
    `LOCDEPAOBSNEW` varchar(5120) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'OBSERVACIÓN NEW'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='LOCALIDAD DEPARTAMENTO AUDITORÍA';

CREATE TRIGGER `LOCDEPDLT` BEFORE DELETE ON `LOCDEP`
    FOR EACH ROW 
        INSERT INTO `LOCDEPA` (`LOCDEPAMET`, `LOCDEPAUSU`, `LOCDEPAFEC`, `LOCDEPADIP`, `LOCDEPACODOLD`, `LOCDEPAESTOLD`, `LOCDEPANOMOLD`, `LOCDEPAEQUOLD`, `LOCDEPAOBSOLD`) 
        VALUES ('DELETE', OLD.`LOCDEPAUS`, NOW(), OLD.`LOCDEPAIP`, OLD.`LOCDEPCOD`, OLD.`LOCDEPEST`, OLD.`LOCDEPNOM`, OLD.`LOCDEPEQU`, OLD.`LOCDEPOBS`);

CREATE TRIGGER `LOCDEPINS` AFTER INSERT ON `LOCDEP`
    FOR EACH ROW 
        INSERT INTO `LOCDEPA` (`LOCDEPAMET`, `LOCDEPAUSU`, `LOCDEPAFEC`, `LOCDEPADIP`, `LOCDEPACODNEW`, `LOCDEPAESTNEW`, `LOCDEPANOMNEW`, `LOCDEPAEQUNEW`, `LOCDEPAOBSNEW`)  
        VALUES ('INSERT', NEW.`LOCDEPAUS`, NOW(), NEW.`LOCDEPAIP`, NEW.`LOCDEPCOD`, NEW.`LOCDEPEST`, NEW.`LOCDEPNOM`, NEW.`LOCDEPEQU`, NEW.`LOCDEPOBS`);

CREATE TRIGGER `LOCDEPUPD` AFTER UPDATE ON `LOCDEP`
    FOR EACH ROW 
        INSERT INTO `LOCDEPA` (`LOCDEPAMET`, `LOCDEPAUSU`, `LOCDEPAFEC`, `LOCDEPADIP`, `LOCDEPACODOLD`, `LOCDEPAESTOLD`, `LOCDEPANOMOLD`, `LOCDEPAEQUOLD`, `LOCDEPAOBSOLD`, `LOCDEPACODNEW`, `LOCDEPAESTNEW`, `LOCDEPANOMNEW`, `LOCDEPAEQUNEW`, `LOCDEPAOBSNEW`)
        VALUES ('UPDATE', NEW.`LOCDEPAUS`, NOW(), NEW.`LOCDEPAIP`, OLD.`LOCDEPCOD`, OLD.`LOCDEPEST`, OLD.`LOCDEPNOM`, OLD.`LOCDEPEQU`, OLD.`LOCDEPOBS`, NEW.`LOCDEPCOD`, NEW.`LOCDEPEST`, NEW.`LOCDEPNOM`, NEW.`LOCDEPEQU`, NEW.`LOCDEPOBS`);

ALTER TABLE `LOCDEP` ADD PRIMARY KEY (`LOCDEPCOD`);
ALTER TABLE `LOCDEP` MODIFY `LOCDEPCOD` mediumint(9) NOT NULL AUTO_INCREMENT COMMENT 'CÓDIGO', AUTO_INCREMENT=0;

ALTER TABLE `LOCDEPA` ADD PRIMARY KEY (`LOCDEPACOD`);
ALTER TABLE `LOCDEPA` MODIFY `LOCDEPACOD` int(11) NOT NULL AUTO_INCREMENT COMMENT 'CÓDIGO', AUTO_INCREMENT=0;
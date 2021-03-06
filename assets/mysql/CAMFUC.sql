CREATE TABLE IF NOT EXISTS `CAMFUC` (
    `CAMFUCCAC` mediumint(9) NOT NULL COMMENT 'CÓDIGO CAMPAÑA',
    `CAMFUCFUC` mediumint(9) NOT NULL COMMENT 'CÓDIGO FUNCIONARIO',
    `CAMFUCEST` char(1) COLLATE utf8_spanish_ci NOT NULL COMMENT 'ESTADO',
    `CAMFUCAUS` char(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'USUARIO',
    `CAMFUCAFH` datetime NOT NULL COMMENT 'FECHA HORA',
    `CAMFUCAIP` char(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'IP'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='CAMPAÑA FUNCIONARIO';

CREATE TABLE IF NOT EXISTS `CAMFUCA` (
    `CAMFUCACOD` int(11) NOT NULL COMMENT 'CÓDIGO',
    `CAMFUCAMET` char(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'MÉTODO',
    `CAMFUCAUSU` char(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'USUARIO',
    `CAMFUCAFEC` datetime NOT NULL COMMENT 'FECHA HORA',
    `CAMFUCADIP` char(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'IP',
    `CAMFUCACACOLD` mediumint(9) NULL COMMENT 'CÓDIGO CAMPAÑA OLD',
    `CAMFUCAFUCOLD` mediumint(9) NULL COMMENT 'CÓDIGO FUNCIONARIO OLD',
    `CAMFUCAESTOLD` char(1) COLLATE utf8_spanish_ci NULL COMMENT 'ESTADO OLD',
    `CAMFUCACACNEW` mediumint(9) NULL COMMENT 'CÓDIGO CAMPAÑA NEW',
    `CAMFUCAFUCNEW` mediumint(9) NULL COMMENT 'CÓDIGO FUNCIONARIO NEW',
    `CAMFUCAESTNEW` char(1) COLLATE utf8_spanish_ci NULL COMMENT 'ESTADO NEW'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='CAMPAÑA FUNCIONARIO AUDITORÍA';

CREATE TRIGGER `CAMFUCDLT` BEFORE DELETE ON `CAMFUC`
  FOR EACH ROW 
    INSERT INTO `CAMFUCA` (`CAMFUCAMET`, `CAMFUCAUSU`, `CAMFUCAFEC`, `CAMFUCADIP`, `CAMFUCACACOLD`, `CAMFUCAFUCOLD`, `CAMFUCAESTOLD`) 
    VALUES ('DELETE', OLD.`CAMFUCAUS`, NOW(), OLD.`CAMFUCAIP`, OLD.`CAMFUCCAC`, OLD.`CAMFUCFUC`, OLD.`CAMFUCEST`);

CREATE TRIGGER `CAMFUCINS` AFTER INSERT ON `CAMFUC`
  FOR EACH ROW 
    INSERT INTO `CAMFUCA` (`CAMFUCAMET`, `CAMFUCAUSU`, `CAMFUCAFEC`, `CAMFUCADIP`, `CAMFUCACACNEW`, `CAMFUCAFUCNEW`, `CAMFUCAESTNEW`) 
    VALUES ('INSERT', NEW.`CAMFUCAUS`, NOW(), NEW.`CAMFUCAIP`, NEW.`CAMFUCCAC`, NEW.`CAMFUCFUC`, NEW.`CAMFUCEST`);

CREATE TRIGGER `CAMFUCUPD` AFTER UPDATE ON `CAMFUC`
  FOR EACH ROW 
    INSERT INTO `CAMFUCA` (`CAMFUCAMET`, `CAMFUCAUSU`, `CAMFUCAFEC`, `CAMFUCADIP`, `CAMFUCACACOLD`, `CAMFUCAFUCOLD`, `CAMFUCAESTOLD`, `CAMFUCACACNEW`, `CAMFUCAFUCNEW`, `CAMFUCAESTNEW`) 
    VALUES ('UPDATE', NEW.`CAMFUCAUS`, NOW(), NEW.`CAMFUCAIP`, OLD.`CAMFUCCAC`, OLD.`CAMFUCFUC`, OLD.`CAMFUCEST`, NEW.`CAMFUCCAC`, NEW.`CAMFUCFUC`, NEW.`CAMFUCEST`);

ALTER TABLE `CAMFUC` ADD PRIMARY KEY (`CAMFUCCAC`, `CAMFUCFUC`);
ALTER TABLE `CAMFUC` ADD CONSTRAINT `FK_CAMFUC_CAMFUCCAC` FOREIGN KEY (`CAMFUCCAC`) REFERENCES `CAMFIC` (`CAMFICCOD`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `CAMFUC` ADD CONSTRAINT `FK_CAMFUC_CAMFUCFUC` FOREIGN KEY (`CAMFUCFUC`) REFERENCES `FUNFIC` (`FUNFICCOD`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `CAMFUCA` ADD PRIMARY KEY (`CAMFUCACOD`);
ALTER TABLE `CAMFUCA` MODIFY `CAMFUCACOD` int(11) NOT NULL AUTO_INCREMENT COMMENT 'CÓDIGO', AUTO_INCREMENT=0;
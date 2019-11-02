CREATE TABLE IF NOT EXISTS `FUNTRA` (
    `FUNTRACOD` mediumint(9) NOT NULL COMMENT 'CÓDIGO',
    `FUNTRAEST` char(1) COLLATE utf8_spanish_ci NOT NULL COMMENT 'ESTADO',
    `FUNTRATCC` mediumint(9) NOT NULL COMMENT 'TIPO CARGO',
    `FUNTRAMSC` mediumint(9) NOT NULL COMMENT 'MOTIVO SALIDA',
    `FUNTRAFUC` mediumint(9) NOT NULL COMMENT 'FUNCIONARIO',
    `FUNTRAEMP` varchar(100) COLLATE utf8_spanish_ci NULL COMMENT 'EMPRESA',
    `FUNTRAFDE` date NULL COMMENT 'DESDE',
    `FUNTRAFHA` date NULL COMMENT 'HASTA',
    `FUNTRAOBS` varchar(5120) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'OBSERVACIÓN',
    `FUNTRAAUS` char(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'USUARIO',
    `FUNTRAAFH` datetime NOT NULL COMMENT 'FECHA HORA',
    `FUNTRAAIP` char(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'IP'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='FUNCIONARIO TRABAJO ANTERIOR';

CREATE TABLE IF NOT EXISTS `FUNTRAA` (
    `FUNTRAACOD` int(11) NOT NULL COMMENT 'CÓDIGO',
    `FUNTRAAMET` char(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'MÉTODO',
    `FUNTRAAUSU` char(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'USUARIO',
    `FUNTRAAFEC` datetime NOT NULL COMMENT 'FECHA HORA',
    `FUNTRAADIP` char(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'IP',

    `FUNTRAACODOLD` mediumint(9) NULL COMMENT 'CÓDIGO OLD',
    `FUNTRAAESTOLD` char(1) COLLATE utf8_spanish_ci NULL COMMENT 'ESTADO OLD',
    `FUNTRAATCCOLD` mediumint(9) NULL COMMENT 'TIPO CARGO OLD',
    `FUNTRAAMSCOLD` mediumint(9) NULL COMMENT 'MOTIVO SALIDA OLD',
    `FUNTRAAFUCOLD` mediumint(9) NULL COMMENT 'FUNCIONARIO OLD',
    `FUNTRAAEMPOLD` varchar(100) COLLATE utf8_spanish_ci NULL COMMENT 'EMPRESA OLD',
    `FUNTRAAFDEOLD` date NULL COMMENT 'DESDE OLD',
    `FUNTRAAFHAOLD` date NULL COMMENT 'HASTA OLD',
    `FUNTRAAOBSOLD` varchar(5120) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'OBSERVACIÓN OLD',

    `FUNTRAACODNEW` mediumint(9) NULL COMMENT 'CÓDIGO NEW',
    `FUNTRAAESTNEW` char(1) COLLATE utf8_spanish_ci NULL COMMENT 'ESTADO NEW',
    `FUNTRAATCCNEW` mediumint(9) NULL COMMENT 'TIPO CARGO NEW',
    `FUNTRAAMSCNEW` mediumint(9) NULL COMMENT 'MOTIVO SALIDA NEW',
    `FUNTRAAFUCNEW` mediumint(9) NULL COMMENT 'FUNCIONARIO NEW',
    `FUNTRAAEMPNEW` varchar(100) COLLATE utf8_spanish_ci NULL COMMENT 'EMPRESA NEW',
    `FUNTRAAFDENEW` date NULL COMMENT 'DESDE NEW',
    `FUNTRAAFHANEW` date NULL COMMENT 'HASTA NEW',
    `FUNTRAAOBSNEW` varchar(5120) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'OBSERVACIÓN NEW'

) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='FUNCIONARIO TRABAJO ANTERIOR AUDITORÍA';

CREATE TRIGGER `FUNTRADLT` BEFORE DELETE ON `FUNTRA`
    FOR EACH ROW 
        INSERT INTO `FUNTRAA` (`FUNTRAAMET`, `FUNTRAAUSU`, `FUNTRAAFEC`, `FUNTRAADIP`, `FUNTRAACODOLD`, `FUNTRAAESTOLD`, `FUNTRAATCCOLD`, `FUNTRAAMSCOLD`, `FUNTRAAFUCOLD`, `FUNTRAAEMPOLD`, `FUNTRAAFDEOLD`, `FUNTRAAFHAOLD`, `FUNTRAAOBSOLD`) 
        VALUES ('DELETE', OLD.`FUNTRAAUS`, NOW(), OLD.`FUNTRAAIP`, OLD.`FUNTRACOD`, OLD.`FUNTRAEST`, OLD.`FUNTRATCC`, OLD.`FUNTRAMSC`, OLD.`FUNTRAFUC`, OLD.`FUNTRAEMP`, OLD.`FUNTRAFDE`, OLD.`FUNTRAFHA`, OLD.`FUNTRAOBS`);

CREATE TRIGGER `FUNTRAINS` AFTER INSERT ON `FUNTRA`
    FOR EACH ROW 
        INSERT INTO `FUNTRAA` (`FUNTRAAMET`, `FUNTRAAUSU`, `FUNTRAAFEC`, `FUNTRAADIP`, `FUNTRAACODNEW`, `FUNTRAAESTNEW`, `FUNTRAATCCNEW`, `FUNTRAAMSCNEW`, `FUNTRAAFUCNEW`, `FUNTRAAEMPNEW`, `FUNTRAAFDENEW`, `FUNTRAAFHANEW`, `FUNTRAAOBSNEW`)
        VALUES ('INSERT', NEW.`FUNTRAAUS`, NOW(), NEW.`FUNTRAAIP`, NEW.`FUNTRACOD`, NEW.`FUNTRAEST`, NEW.`FUNTRATCC`, NEW.`FUNTRAMSC`, NEW.`FUNTRAFUC`, NEW.`FUNTRAEMP`, NEW.`FUNTRAFDE`, NEW.`FUNTRAFHA`, NEW.`FUNTRAOBS`);

CREATE TRIGGER `FUNTRAUPD` AFTER UPDATE ON `FUNTRA`
    FOR EACH ROW 
        INSERT INTO `FUNTRAA` (`FUNTRAAMET`, `FUNTRAAUSU`, `FUNTRAAFEC`, `FUNTRAADIP`, `FUNTRAACODOLD`, `FUNTRAAESTOLD`, `FUNTRAATCCOLD`, `FUNTRAAMSCOLD`, `FUNTRAAFUCOLD`, `FUNTRAAEMPOLD`, `FUNTRAAFDEOLD`, `FUNTRAAFHAOLD`, `FUNTRAAOBSOLD`, `FUNTRAACODNEW`, `FUNTRAAESTNEW`, `FUNTRAATCCNEW`, `FUNTRAAMSCNEW`, `FUNTRAAFUCNEW`, `FUNTRAAEMPNEW`, `FUNTRAAFDENEW`, `FUNTRAAFHANEW`, `FUNTRAAOBSNEW`) 
        VALUES ('UPDATE', NEW.`FUNTRAAUS`, NOW(), NEW.`FUNTRAAIP`, OLD.`FUNTRACOD`, OLD.`FUNTRAEST`, OLD.`FUNTRATCC`, OLD.`FUNTRAMSC`, OLD.`FUNTRAFUC`, OLD.`FUNTRAEMP`, OLD.`FUNTRAFDE`, OLD.`FUNTRAFHA`, OLD.`FUNTRAOBS`, NEW.`FUNTRACOD`, NEW.`FUNTRAEST`, NEW.`FUNTRATCC`, NEW.`FUNTRAMSC`, NEW.`FUNTRAFUC`, NEW.`FUNTRAEMP`, NEW.`FUNTRAFDE`, NEW.`FUNTRAFHA`, NEW.`FUNTRAOBS`);

ALTER TABLE `FUNTRA` ADD PRIMARY KEY (`FUNTRACOD`);
ALTER TABLE `FUNTRA` MODIFY `FUNTRACOD` mediumint(9) NOT NULL AUTO_INCREMENT COMMENT 'CÓDIGO', AUTO_INCREMENT=0;
ALTER TABLE `FUNTRA` ADD KEY `FUNTRATCC` (`FUNTRATCC`);
ALTER TABLE `FUNTRA` ADD KEY `FUNTRAMSC` (`FUNTRAMSC`);
ALTER TABLE `FUNTRA` ADD KEY `FUNTRAFUC` (`FUNTRAFUC`);
ALTER TABLE `FUNTRA` ADD CONSTRAINT `FK_FUNTRA_FUNTRATCC` FOREIGN KEY (`FUNTRATCC`) REFERENCES `DOMFIC` (`DOMFICCOD`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `FUNTRA` ADD CONSTRAINT `FK_FUNTRA_FUNTRAMSC` FOREIGN KEY (`FUNTRAMSC`) REFERENCES `DOMFIC` (`DOMFICCOD`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `FUNTRA` ADD CONSTRAINT `FK_FUNTRA_FUNTRAFUC` FOREIGN KEY (`FUNTRAFUC`) REFERENCES `FUNFIC` (`FUNFICCOD`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `FUNTRAA` ADD PRIMARY KEY (`FUNTRAACOD`);
ALTER TABLE `FUNTRAA` MODIFY `FUNTRAACOD` int(11) NOT NULL AUTO_INCREMENT COMMENT 'CÓDIGO', AUTO_INCREMENT=0;
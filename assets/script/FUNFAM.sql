CREATE TABLE IF NOT EXISTS `FUNFAM` (
    `FUNFAMCOD` mediumint(9) NOT NULL COMMENT 'CÓDIGO',
    `FUNFAMEST` char(1) COLLATE utf8_spanish_ci NOT NULL COMMENT 'ESTADO',
    `FUNFAMTPC` mediumint(9) NOT NULL COMMENT 'TIPO PARENTEZCO',
    `FUNFAMTCC` mediumint(9) NOT NULL COMMENT 'TIPO CELULAR',
    `FUNRPPTTC` mediumint(9) NOT NULL COMMENT 'TIPO TELEFONO',
    `FUNFAMFUC` mediumint(9) NOT NULL COMMENT 'FUNCIONARIO',
    `FUNFAMNOM` varchar(100) COLLATE utf8_spanish_ci NOT NULL COMMENT 'PERSONA NOMBRE',
    `FUNFAMAPE` varchar(100) COLLATE utf8_spanish_ci NOT NULL COMMENT 'PERSONA APELLIDO',
    `FUNFAMFHA` date NULL COMMENT 'FECHA NACIMIENTO',
    `FUNFAMCIC` varchar(100) COLLATE utf8_spanish_ci NULL COMMENT 'DOCUMENTO',
    `FUNFAMEMP` varchar(100) COLLATE utf8_spanish_ci NULL COMMENT 'EMPRESA',
    `FUNFAMOCU` varchar(100) COLLATE utf8_spanish_ci NULL COMMENT 'OCUPACIÓN',
    `FUNFAMCEL` char(6) COLLATE utf8_spanish_ci COMMENT 'CELULAR',
    `FUNFAMTEL` char(6) COLLATE utf8_spanish_ci COMMENT 'TELEFONO',
    `FUNFAMOBS` varchar(5120) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'OBSERVACIÓN',
    `FUNFAMAUS` char(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'USUARIO',
    `FUNFAMAFH` datetime NOT NULL COMMENT 'FECHA HORA',
    `FUNFAMAIP` char(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'IP'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='FUNCIONARIO DATOS FAMILIARES';

CREATE TABLE IF NOT EXISTS `FUNFAMA` (
    `FUNFAMACOD` int(11) NOT NULL COMMENT 'CÓDIGO',
    `FUNFAMAMET` char(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'MÉTODO',
    `FUNFAMAUSU` char(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'USUARIO',
    `FUNFAMAFEC` datetime NOT NULL COMMENT 'FECHA HORA',
    `FUNFAMADIP` char(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'IP',

    `FUNFAMACODOLD` mediumint(9) NULL COMMENT 'CÓDIGO OLD',
    `FUNFAMAESTOLD` char(1) COLLATE utf8_spanish_ci NULL COMMENT 'ESTADO OLD',
    `FUNFAMATPCOLD` mediumint(9) NULL COMMENT 'TIPO PARENTEZCO OLD',
    `FUNFAMATCCOLD` mediumint(9) NULL COMMENT 'TIPO CELULAR OLD',
    `FUNRPPATTCOLD` mediumint(9) NULL COMMENT 'TIPO TELEFONO OLD',
    `FUNFAMAFUCOLD` mediumint(9) NULL COMMENT 'FUNCIONARIO OLD',
    `FUNFAMANOMOLD` varchar(100) COLLATE utf8_spanish_ci NULL COMMENT 'PERSONA NOMBRE OLD',
    `FUNFAMAAPEOLD` varchar(100) COLLATE utf8_spanish_ci NULL COMMENT 'PERSONA APELLIDO OLD',
    `FUNFAMAFHAOLD` date NULL COMMENT 'FECHA NACIMIENTO OLD',
    `FUNFAMACICOLD` varchar(100) COLLATE utf8_spanish_ci NULL COMMENT 'DOCUMENTO OLD',
    `FUNFAMAEMPOLD` varchar(100) COLLATE utf8_spanish_ci NULL COMMENT 'EMPRESA OLD',
    `FUNFAMAOCUOLD` varchar(100) COLLATE utf8_spanish_ci NULL COMMENT 'OCUPACIÓN OLD',
    `FUNFAMACELOLD` varchar(100) COLLATE utf8_spanish_ci COMMENT 'CELULAR OLD',
    `FUNFAMATELOLD` varchar(100) COLLATE utf8_spanish_ci COMMENT 'TELEFONO OLD',
    `FUNFAMAOBSOLD` varchar(5120) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'OBSERVACIÓN OLD',

    `FUNFAMACODNEW` mediumint(9) NULL COMMENT 'CÓDIGO NEW',
    `FUNFAMAESTNEW` char(1) COLLATE utf8_spanish_ci NULL COMMENT 'ESTADO NEW',
    `FUNFAMATPCNEW` mediumint(9) NULL COMMENT 'TIPO PARENTEZCO NEW',
    `FUNFAMATCCNEW` mediumint(9) NULL COMMENT 'TIPO CELULAR NEW',
    `FUNRPPATTCNEW` mediumint(9) NULL COMMENT 'TIPO TELEFONO NEW',
    `FUNFAMAFUCNEW` mediumint(9) NULL COMMENT 'FUNCIONARIO NEW',
    `FUNFAMANOMNEW` varchar(100) COLLATE utf8_spanish_ci NULL COMMENT 'PERSONA NOMBRE NEW',
    `FUNFAMAAPENEW` varchar(100) COLLATE utf8_spanish_ci NULL COMMENT 'PERSONA APELLIDO NEW',
    `FUNFAMAFHANEW` date NULL COMMENT 'FECHA NACIMIENTO NEW',
    `FUNFAMACICNEW` varchar(100) COLLATE utf8_spanish_ci NULL COMMENT 'DOCUMENTO NEW',
    `FUNFAMAEMPNEW` varchar(100) COLLATE utf8_spanish_ci NULL COMMENT 'EMPRESA NEW',
    `FUNFAMAOCUNEW` varchar(100) COLLATE utf8_spanish_ci NULL COMMENT 'OCUPACIÓN NEW',
    `FUNFAMACELNEW` varchar(100) COLLATE utf8_spanish_ci COMMENT 'CELULAR NEW',
    `FUNFAMATELNEW` varchar(100) COLLATE utf8_spanish_ci COMMENT 'TELEFONO NEW',
    `FUNFAMAOBSNEW` varchar(5120) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'OBSERVACIÓN NEW'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='FUNCIONARIO DATOS FAMILIARES AUDITORÍA';

CREATE TRIGGER `FUNFAMDLT` BEFORE DELETE ON `FUNFAM`
    FOR EACH ROW 
        INSERT INTO `FUNFAMA` (`FUNFAMAMET`, `FUNFAMAUSU`, `FUNFAMAFEC`, `FUNFAMADIP`, `FUNFAMACODOLD`, `FUNFAMAESTOLD`, `FUNFAMATPCOLD`, `FUNFAMATCCOLD`, `FUNRPPATTCOLD`, `FUNFAMAFUCOLD`, `FUNFAMANOMOLD`, `FUNFAMAAPEOLD`, `FUNFAMAFHAOLD`, `FUNFAMACICOLD`, `FUNFAMAEMPOLD`, `FUNFAMAOCUOLD`, `FUNFAMACELOLD`, `FUNFAMATELOLD`, `FUNFAMAOBSOLD`) 
        VALUES ('DELETE', OLD.`FUNFAMAUS`, NOW(), OLD.`FUNFAMAIP`, OLD.`FUNFAMCOD`, OLD.`FUNFAMEST`, OLD.`FUNFAMTPC`, OLD.`FUNFAMTCC`, OLD.`FUNRPPTTC`, OLD.`FUNFAMFUC`, OLD.`FUNFAMNOM`, OLD.`FUNFAMAPE`, OLD.`FUNFAMFHA`, OLD.`FUNFAMCIC`, OLD.`FUNFAMEMP`, OLD.`FUNFAMOCU`, OLD.`FUNFAMCEL`, OLD.`FUNFAMTEL`, OLD.`FUNFAMOBS`);

CREATE TRIGGER `FUNFAMINS` AFTER INSERT ON `FUNFAM`
    FOR EACH ROW 
        INSERT INTO `FUNFAMA` (`FUNFAMAMET`, `FUNFAMAUSU`, `FUNFAMAFEC`, `FUNFAMADIP`, `FUNFAMACODNEW`, `FUNFAMAESTNEW`, `FUNFAMATPCNEW`, `FUNFAMATCCNEW`, `FUNRPPATTCNEW`, `FUNFAMAFUCNEW`, `FUNFAMANOMNEW`, `FUNFAMAAPENEW`, `FUNFAMAFHANEW`, `FUNFAMACICNEW`, `FUNFAMAEMPNEW`, `FUNFAMAOCUNEW`, `FUNFAMACELNEW`, `FUNFAMATELNEW`, `FUNFAMAOBSNEW`)
        VALUES ('INSERT', NEW.`FUNFAMAUS`, NOW(), NEW.`FUNFAMAIP`, NEW.`FUNFAMCOD`, NEW.`FUNFAMEST`, NEW.`FUNFAMTPC`, NEW.`FUNFAMTCC`, NEW.`FUNRPPTTC`, NEW.`FUNFAMFUC`, NEW.`FUNFAMNOM`, NEW.`FUNFAMAPE`, NEW.`FUNFAMFHA`, NEW.`FUNFAMCIC`, NEW.`FUNFAMEMP`, NEW.`FUNFAMOCU`, NEW.`FUNFAMCEL`, NEW.`FUNFAMTEL`, NEW.`FUNFAMOBS`);

CREATE TRIGGER `FUNFAMUPD` AFTER UPDATE ON `FUNFAM`
    FOR EACH ROW 
        INSERT INTO `FUNFAMA` (`FUNFAMAMET`, `FUNFAMAUSU`, `FUNFAMAFEC`, `FUNFAMADIP`, `FUNFAMACODOLD`, `FUNFAMAESTOLD`, `FUNFAMATPCOLD`, `FUNFAMATCCOLD`, `FUNRPPATTCOLD`, `FUNFAMAFUCOLD`, `FUNFAMANOMOLD`, `FUNFAMAAPEOLD`, `FUNFAMAFHAOLD`, `FUNFAMACICOLD`, `FUNFAMAEMPOLD`, `FUNFAMAOCUOLD`, `FUNFAMACELOLD`, `FUNFAMATELOLD`, `FUNFAMAOBSOLD`, `FUNFAMACODNEW`, `FUNFAMAESTNEW`, `FUNFAMATPCNEW`, `FUNFAMATCCNEW`, `FUNRPPATTCNEW`, `FUNFAMAFUCNEW`, `FUNFAMANOMNEW`, `FUNFAMAAPEOLD`, `FUNFAMAFHAOLD`, `FUNFAMACICNEW`, `FUNFAMAEMPNEW`, `FUNFAMAOCUNEW`, `FUNFAMACELNEW`, `FUNFAMATELNEW`, `FUNFAMAOBSNEW`)
        VALUES ('UPDATE', NEW.`FUNFAMAUS`, NOW(), NEW.`FUNFAMAIP`, OLD.`FUNFAMCOD`, OLD.`FUNFAMEST`, OLD.`FUNFAMTPC`, OLD.`FUNFAMTCC`, OLD.`FUNRPPTTC`, OLD.`FUNFAMFUC`, OLD.`FUNFAMNOM`, OLD.`FUNFAMAPE`, OLD.`FUNFAMFHA`, OLD.`FUNFAMCIC`, OLD.`FUNFAMEMP`, OLD.`FUNFAMOCU`, OLD.`FUNFAMCEL`, OLD.`FUNFAMTEL`, OLD.`FUNFAMOBS`, NEW.`FUNFAMCOD`, NEW.`FUNFAMEST`, NEW.`FUNFAMTPC`, NEW.`FUNFAMTCC`, NEW.`FUNRPPTTC`, NEW.`FUNFAMFUC`, NEW.`FUNFAMNOM`, NEW.`FUNFAMAPE`, NEW.`FUNFAMFHA`, NEW.`FUNFAMCIC`, NEW.`FUNFAMEMP`, NEW.`FUNFAMOCU`, NEW.`FUNFAMCEL`, NEW.`FUNFAMTEL`, NEW.`FUNFAMOBS`);

ALTER TABLE `FUNFAM` ADD PRIMARY KEY (`FUNFAMCOD`);
ALTER TABLE `FUNFAM` MODIFY `FUNFAMCOD` mediumint(9) NOT NULL AUTO_INCREMENT COMMENT 'CÓDIGO', AUTO_INCREMENT=0;

ALTER TABLE `FUNFAM` ADD KEY `FUNFAMTPC` (`FUNFAMTPC`);
ALTER TABLE `FUNFAM` ADD CONSTRAINT `FK_FUNFAM_FUNFAMTPC` FOREIGN KEY (`FUNFAMTPC`) REFERENCES `DOMFIC` (`DOMFICCOD`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `FUNFAM` ADD KEY `FUNFAMTCC` (`FUNFAMTCC`);
ALTER TABLE `FUNFAM` ADD CONSTRAINT `FK_FUNFAM_FUNFAMTCC` FOREIGN KEY (`FUNFAMTCC`) REFERENCES `DOMFIC` (`DOMFICCOD`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `FUNFAM` ADD KEY `FUNRPPTTC` (`FUNRPPTTC`);
ALTER TABLE `FUNFAM` ADD CONSTRAINT `FK_FUNFAM_FUNRPPTTC` FOREIGN KEY (`FUNRPPTTC`) REFERENCES `DOMFIC` (`DOMFICCOD`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `FUNFAM` ADD KEY `FUNFAMFUC` (`FUNFAMFUC`);
ALTER TABLE `FUNFAM` ADD CONSTRAINT `FK_FUNFAM_FUNFAMFUC` FOREIGN KEY (`FUNFAMFUC`) REFERENCES `FUNFIC` (`FUNFICCOD`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `FUNFAMA` ADD PRIMARY KEY (`FUNFAMACOD`);
ALTER TABLE `FUNFAMA` MODIFY `FUNFAMACOD` int(11) NOT NULL AUTO_INCREMENT COMMENT 'CÓDIGO', AUTO_INCREMENT=0;
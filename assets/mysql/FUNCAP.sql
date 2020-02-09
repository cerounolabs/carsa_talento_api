CREATE TABLE IF NOT EXISTS `FUNCAP` (
    `FUNCAPCOD` mediumint(9) NOT NULL COMMENT 'CÓDIGO',
    `FUNCAPEST` char(1) COLLATE utf8_spanish_ci NOT NULL COMMENT 'ESTADO',
    `FUNCAPFUC` mediumint(9) NOT NULL COMMENT 'FUNCIONARIO',
    `FUNCAPEMP` varchar(100) COLLATE utf8_spanish_ci NULL COMMENT 'EMPRESA',
    `FUNCAPCAP` varchar(100) COLLATE utf8_spanish_ci NULL COMMENT 'CAPACITACION',
    `FUNCAPPER` char(4) COLLATE utf8_spanish_ci NULL COMMENT 'PERIODO',
    `FUNCAPOBS` varchar(5120) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'OBSERVACIÓN',
    `FUNCAPAUS` char(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'USUARIO',
    `FUNCAPAFH` datetime NOT NULL COMMENT 'FECHA HORA',
    `FUNCAPAIP` char(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'IP'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='FUNCIONARIO CAPACITACION';

CREATE TABLE IF NOT EXISTS `FUNCAPA` (
    `FUNCAPACOD` int(11) NOT NULL COMMENT 'CÓDIGO',
    `FUNCAPAMET` char(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'MÉTODO',
    `FUNCAPAUSU` char(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'USUARIO',
    `FUNCAPAFEC` datetime NOT NULL COMMENT 'FECHA HORA',
    `FUNCAPADIP` char(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'IP',

    `FUNCAPACODOLD` mediumint(9) NULL COMMENT 'CÓDIGO OLD',
    `FUNCAPAESTOLD` char(1) COLLATE utf8_spanish_ci NULL COMMENT 'ESTADO OLD',
    `FUNCAPAFUCOLD` mediumint(9) NULL COMMENT 'FUNCIONARIO OLD',
    `FUNCAPAEMPOLD` varchar(100) COLLATE utf8_spanish_ci NULL COMMENT 'EMPRESA OLD',
    `FUNCAPACAPOLD` varchar(100) COLLATE utf8_spanish_ci NULL COMMENT 'CAPACITACION OLD',
    `FUNCAPAPEROLD` char(4) COLLATE utf8_spanish_ci NULL COMMENT 'PERIODO OLD',
    `FUNCAPAOBSOLD` varchar(5120) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'OBSERVACIÓN OLD',

    `FUNCAPACODNEW` mediumint(9) NULL COMMENT 'CÓDIGO NEW',
    `FUNCAPAESTNEW` char(1) COLLATE utf8_spanish_ci NULL COMMENT 'ESTADO NEW',
    `FUNCAPAFUCNEW` mediumint(9) NULL COMMENT 'FUNCIONARIO NEW',
    `FUNCAPAEMPNEW` varchar(100) COLLATE utf8_spanish_ci NULL COMMENT 'EMPRESA NEW',
    `FUNCAPACAPNEW` varchar(100) COLLATE utf8_spanish_ci NULL COMMENT 'CAPACITACION NEW',
    `FUNCAPAPERNEW` char(4) COLLATE utf8_spanish_ci NULL COMMENT 'PERIODO NEW',
    `FUNCAPAOBSNEW` varchar(5120) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'OBSERVACIÓN NEW'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='FUNCIONARIO CAPACITACION AUDITORÍA';

CREATE TRIGGER `FUNCAPDLT` BEFORE DELETE ON `FUNCAP`
    FOR EACH ROW 
        INSERT INTO `FUNCAPA` (`FUNCAPAMET`, `FUNCAPAUSU`, `FUNCAPAFEC`, `FUNCAPADIP`, `FUNCAPACODOLD`, `FUNCAPAESTOLD`, `FUNCAPAFUCOLD`, `FUNCAPAEMPOLD`, `FUNCAPACAPOLD`, `FUNCAPAPEROLD`, `FUNCAPAOBSOLD`)
        VALUES ('DELETE', OLD.`FUNCAPAUS`, NOW(), OLD.`FUNCAPAIP`, OLD.`FUNCAPCOD`, OLD.`FUNCAPEST`, OLD.`FUNCAPFUC`, OLD.`FUNCAPEMP`, OLD.`FUNCAPCAP`, OLD.`FUNCAPPER`, OLD.`FUNCAPOBS`);

CREATE TRIGGER `FUNCAPINS` AFTER INSERT ON `FUNCAP`
    FOR EACH ROW 
        INSERT INTO `FUNCAPA` (`FUNCAPAMET`, `FUNCAPAUSU`, `FUNCAPAFEC`, `FUNCAPADIP`, `FUNCAPACODNEW`, `FUNCAPAESTNEW`, `FUNCAPAFUCNEW`, `FUNCAPAEMPNEW`, `FUNCAPACAPNEW`, `FUNCAPAPERNEW`, `FUNCAPAOBSNEW`)
        VALUES ('INSERT', NEW.`FUNCAPAUS`, NOW(), NEW.`FUNCAPAIP`, NEW.`FUNCAPCOD`, NEW.`FUNCAPEST`, NEW.`FUNCAPFUC`, NEW.`FUNCAPEMP`, NEW.`FUNCAPCAP`, NEW.`FUNCAPPER`, NEW.`FUNCAPOBS`);

CREATE TRIGGER `FUNCAPUPD` AFTER UPDATE ON `FUNCAP`
    FOR EACH ROW 
        INSERT INTO `FUNCAPA` (`FUNCAPAMET`, `FUNCAPAUSU`, `FUNCAPAFEC`, `FUNCAPADIP`, `FUNCAPACODOLD`, `FUNCAPAESTOLD`, `FUNCAPAFUCOLD`, `FUNCAPAEMPOLD`, `FUNCAPACAPOLD`, `FUNCAPAPEROLD`, `FUNCAPAOBSOLD`, `FUNCAPACODNEW`, `FUNCAPAESTNEW`, `FUNCAPAFUCNEW`, `FUNCAPAEMPNEW`, `FUNCAPACAPNEW`, `FUNCAPAPERNEW`, `FUNCAPAOBSNEW`)
        VALUES ('UPDATE', NEW.`FUNCAPAUS`, NOW(), NEW.`FUNCAPAIP`, OLD.`FUNCAPCOD`, OLD.`FUNCAPEST`, OLD.`FUNCAPFUC`, OLD.`FUNCAPEMP`, OLD.`FUNCAPCAP`, OLD.`FUNCAPPER`, OLD.`FUNCAPOBS`, NEW.`FUNCAPCOD`, NEW.`FUNCAPEST`, NEW.`FUNCAPFUC`, NEW.`FUNCAPEMP`, NEW.`FUNCAPCAP`, NEW.`FUNCAPPER`, NEW.`FUNCAPOBS`);

ALTER TABLE `FUNCAP` ADD PRIMARY KEY (`FUNCAPCOD`);
ALTER TABLE `FUNCAP` MODIFY `FUNCAPCOD` mediumint(9) NOT NULL AUTO_INCREMENT COMMENT 'CÓDIGO', AUTO_INCREMENT=0;

ALTER TABLE `FUNCAP` ADD KEY `FUNCAPFUC` (`FUNCAPFUC`);
ALTER TABLE `FUNCAP` ADD CONSTRAINT `FK_FUNCAP_FUNCAPFUC` FOREIGN KEY (`FUNCAPFUC`) REFERENCES `FUNFIC` (`FUNFICCOD`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `FUNCAPA` ADD PRIMARY KEY (`FUNCAPACOD`);
ALTER TABLE `FUNCAPA` MODIFY `FUNCAPACOD` int(11) NOT NULL AUTO_INCREMENT COMMENT 'CÓDIGO', AUTO_INCREMENT=0;
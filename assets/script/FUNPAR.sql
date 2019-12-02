CREATE TABLE IF NOT EXISTS `FUNPAR` (
    `FUNPARCOD` mediumint(9) NOT NULL COMMENT 'CÓDIGO',
    `FUNPAREST` char(1) COLLATE utf8_spanish_ci NOT NULL COMMENT 'ESTADO',
    `FUNPARTVC` mediumint(9) NOT NULL COMMENT 'TIPO VIVIENDA',
    `FUNPARTCC` mediumint(9) NOT NULL COMMENT 'TIPO CELULAR 1',
    `FUNPARTEC` mediumint(9) NOT NULL COMMENT 'TIPO CELULAR 1',
    `FUNPARTTC` mediumint(9) NOT NULL COMMENT 'TIPO TELEFONO 1',
    `FUNPARFUC` mediumint(9) NOT NULL COMMENT 'FUNCIONARIO',
    `FUNPARCIC` mediumint(9) NOT NULL COMMENT 'CIUDAD',
    `FUNPARBAC` mediumint(9) NOT NULL COMMENT 'BARRIO',
    `FUNPARCAS` varchar(100) COLLATE utf8_spanish_ci NULL COMMENT 'NÚMERO CASA',
    `FUNPARCA1` varchar(100) COLLATE utf8_spanish_ci NULL COMMENT 'CALLE 1',
    `FUNPARCA2` varchar(100) COLLATE utf8_spanish_ci NULL COMMENT 'CALLE 2',
    `FUNPARCA3` varchar(100) COLLATE utf8_spanish_ci NULL COMMENT 'CALLE 3',
    `FUNPARUBI` varchar(100) COLLATE utf8_spanish_ci NULL COMMENT 'UBICACION',
    `FUNPARTE1` varchar(100) COLLATE utf8_spanish_ci NULL COMMENT 'TELEFONO 1',
    `FUNPARCE1` varchar(100) COLLATE utf8_spanish_ci NULL COMMENT 'CELULAR 1',
    `FUNPARCE2` varchar(100) COLLATE utf8_spanish_ci NULL COMMENT 'CELULAR 2',
    `FUNPAREMA` varchar(100) COLLATE utf8_spanish_ci NULL COMMENT 'EMAIL',
    `FUNPAROBS` varchar(5120) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'OBSERVACIÓN',
    `FUNPARAUS` char(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'USUARIO',
    `FUNPARAFH` datetime NOT NULL COMMENT 'FECHA HORA',
    `FUNPARAIP` char(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'IP'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='FUNCIONARIO DATOS PARTICULARES';

CREATE TABLE IF NOT EXISTS `FUNPARA` (
    `FUNPARACOD` int(11) NOT NULL COMMENT 'CÓDIGO',
    `FUNPARAMET` char(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'MÉTODO',
    `FUNPARAUSU` char(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'USUARIO',
    `FUNPARAFEC` datetime NOT NULL COMMENT 'FECHA HORA',
    `FUNPARADIP` char(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'IP',

    `FUNPARACODOLD` mediumint(9) NULL COMMENT 'CÓDIGO OLD',
    `FUNPARAESTOLD` char(1) COLLATE utf8_spanish_ci NULL COMMENT 'ESTADO OLD',
    `FUNPARATVCOLD` mediumint(9) NULL COMMENT 'TIPO VIVIENDA OLD',
    `FUNPARATCCOLD` mediumint(9) NULL COMMENT 'TIPO CELULAR 1 OLD',
    `FUNPARATECOLD` mediumint(9) NULL COMMENT 'TIPO CELULAR 1 OLD',
    `FUNPARATTCOLD` mediumint(9) NULL COMMENT 'TIPO TELEFONO 1 OLD',
    `FUNPARAFUCOLD` mediumint(9) NULL COMMENT 'FUNCIONARIO OLD',
    `FUNPARACICOLD` mediumint(9) NULL COMMENT 'CIUDAD OLD',
    `FUNPARABACOLD` mediumint(9) NULL COMMENT 'BARRIO OLD',
    `FUNPARACASOLD` varchar(100) COLLATE utf8_spanish_ci NULL COMMENT 'NÚMERO CASA OLD',
    `FUNPARACA1OLD` varchar(100) COLLATE utf8_spanish_ci NULL COMMENT 'CALLE 1 OLD',
    `FUNPARACA2OLD` varchar(100) COLLATE utf8_spanish_ci NULL COMMENT 'CALLE 2 OLD',
    `FUNPARACA3OLD` varchar(100) COLLATE utf8_spanish_ci NULL COMMENT 'CALLE 3 OLD',
    `FUNPARAUBIOLD` varchar(100) COLLATE utf8_spanish_ci NULL COMMENT 'UBICACION OLD',
    `FUNPARATE1OLD` varchar(100) COLLATE utf8_spanish_ci NULL COMMENT 'TELEFONO 1 OLD',
    `FUNPARACE1OLD` varchar(100) COLLATE utf8_spanish_ci NULL COMMENT 'CELULAR 1 OLD',
    `FUNPARACE2OLD` varchar(100) COLLATE utf8_spanish_ci NULL COMMENT 'CELULAR 2 OLD',
    `FUNPARAEMAOLD` varchar(100) COLLATE utf8_spanish_ci NULL COMMENT 'EMAIL OLD',
    `FUNPARAOBSOLD` varchar(5120) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'OBSERVACIÓN OLD',

    `FUNPARACODNEW` mediumint(9) NULL COMMENT 'CÓDIGO NEW',
    `FUNPARAESTNEW` char(1) COLLATE utf8_spanish_ci NULL COMMENT 'ESTADO NEW',
    `FUNPARATVCNEW` mediumint(9) NULL COMMENT 'TIPO VIVIENDA NEW',
    `FUNPARATCCNEW` mediumint(9) NULL COMMENT 'TIPO CELULAR 1 NEW',
    `FUNPARATECNEW` mediumint(9) NULL COMMENT 'TIPO CELULAR 1 NEW',
    `FUNPARATTCNEW` mediumint(9) NULL COMMENT 'TIPO TELEFONO 1 NEW',
    `FUNPARAFUCNEW` mediumint(9) NULL COMMENT 'FUNCIONARIO NEW',
    `FUNPARACICNEW` mediumint(9) NULL COMMENT 'CIUDAD NEW',
    `FUNPARABACNEW` mediumint(9) NULL COMMENT 'BARRIO NEW',
    `FUNPARACASNEW` varchar(100) COLLATE utf8_spanish_ci NULL COMMENT 'NÚMERO CASA NEW',
    `FUNPARACA1NEW` varchar(100) COLLATE utf8_spanish_ci NULL COMMENT 'CALLE 1 NEW',
    `FUNPARACA2NEW` varchar(100) COLLATE utf8_spanish_ci NULL COMMENT 'CALLE 2 NEW',
    `FUNPARACA3NEW` varchar(100) COLLATE utf8_spanish_ci NULL COMMENT 'CALLE 3 NEW',
    `FUNPARAUBINEW` varchar(100) COLLATE utf8_spanish_ci NULL COMMENT 'UBICACION NEW',
    `FUNPARATE1NEW` varchar(100) COLLATE utf8_spanish_ci NULL COMMENT 'TELEFONO 1 NEW',
    `FUNPARACE1NEW` varchar(100) COLLATE utf8_spanish_ci NULL COMMENT 'CELULAR 1 NEW',
    `FUNPARACE2NEW` varchar(100) COLLATE utf8_spanish_ci NULL COMMENT 'CELULAR 2 NEW',
    `FUNPARAEMANEW` varchar(100) COLLATE utf8_spanish_ci NULL COMMENT 'EMAIL NEW',
    `FUNPARAOBSNEW` varchar(5120) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'OBSERVACIÓN NEW'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='FUNCIONARIO DATOS PARTICULARES AUDITORÍA';

CREATE TRIGGER `FUNPARDLT` BEFORE DELETE ON `FUNPAR`
    FOR EACH ROW 
        INSERT INTO `FUNPARA` (`FUNPARAMET`, `FUNPARAUSU`, `FUNPARAFEC`, `FUNPARADIP`, `FUNPARACODOLD`, `FUNPARAESTOLD`, `FUNPARATVCOLD`, `FUNPARATCCOLD`, `FUNPARATECOLD`, `FUNPARATTCOLD`, `FUNPARAFUCOLD`, `FUNPARACICOLD`, `FUNPARABACOLD`, `FUNPARACASOLD`, `FUNPARACA1OLD`, `FUNPARACA2OLD`, `FUNPARACA3OLD`, `FUNPARAUBIOLD`, `FUNPARATE1OLD`, `FUNPARACE1OLD`, `FUNPARACE2OLD`, `FUNPARAEMAOLD`, `FUNPARAOBSOLD`)
        VALUES ('DELETE', OLD.`FUNPARAUS`, NOW(), OLD.`FUNPARAIP`, OLD.`FUNPARCOD`, OLD.`FUNPAREST`, OLD.`FUNPARTVC`, OLD.`FUNPARTCC`, OLD.`FUNPARTEC`, OLD.`FUNPARTTC`, OLD.`FUNPARFUC`, OLD.`FUNPARCIC`, OLD.`FUNPARBAC`, OLD.`FUNPARCAS`, OLD.`FUNPARCA1`, OLD.`FUNPARCA2`, OLD.`FUNPARCA3`, OLD.`FUNPARUBI`, OLD.`FUNPARTE1`, OLD.`FUNPARCE1`, OLD.`FUNPARCE2`, OLD.`FUNPAREMA`, OLD.`FUNPAROBS`);

CREATE TRIGGER `FUNPARINS` AFTER INSERT ON `FUNPAR`
    FOR EACH ROW 
        INSERT INTO `FUNPARA` (`FUNPARAMET`, `FUNPARAUSU`, `FUNPARAFEC`, `FUNPARADIP`, `FUNPARACODNEW`, `FUNPARAESTNEW`, `FUNPARATVCNEW`, `FUNPARATCCNEW`, `FUNPARATECNEW`, `FUNPARATTCNEW`, `FUNPARAFUCNEW`, `FUNPARACICNEW`, `FUNPARABACNEW`, `FUNPARACASNEW`, `FUNPARACA1NEW`, `FUNPARACA2NEW`, `FUNPARACA3NEW`, `FUNPARAUBINEW`, `FUNPARATE1NEW`, `FUNPARACE1NEW`, `FUNPARACE2NEW`, `FUNPARAEMANEW`, `FUNPARAOBSNEW`)
        VALUES ('INSERT', NEW.`FUNPARAUS`, NOW(), NEW.`FUNPARAIP`, NEW.`FUNPARCOD`, NEW.`FUNPAREST`, NEW.`FUNPARTVC`, NEW.`FUNPARTCC`, NEW.`FUNPARTEC`, NEW.`FUNPARTTC`, NEW.`FUNPARFUC`, NEW.`FUNPARCIC`, NEW.`FUNPARBAC`, NEW.`FUNPARCAS`, NEW.`FUNPARCA1`, NEW.`FUNPARCA2`, NEW.`FUNPARCA3`, NEW.`FUNPARUBI`, NEW.`FUNPARTE1`, NEW.`FUNPARCE1`, NEW.`FUNPARCE2`, NEW.`FUNPAREMA`, NEW.`FUNPAROBS`);

CREATE TRIGGER `FUNPARUPD` AFTER UPDATE ON `FUNPAR`
    FOR EACH ROW 
        INSERT INTO `FUNPARA` (`FUNPARAMET`, `FUNPARAUSU`, `FUNPARAFEC`, `FUNPARADIP`, `FUNPARACODOLD`, `FUNPARAESTOLD`, `FUNPARATVCOLD`, `FUNPARATCCOLD`, `FUNPARATECOLD`, `FUNPARATTCOLD`, `FUNPARAFUCOLD`, `FUNPARACICOLD`, `FUNPARABACOLD`, `FUNPARACASOLD`, `FUNPARACA1OLD`, `FUNPARACA2OLD`, `FUNPARACA3OLD`, `FUNPARAUBIOLD`, `FUNPARATE1OLD`, `FUNPARACE1OLD`, `FUNPARACE2OLD`, `FUNPARAEMAOLD`, `FUNPARAOBSOLD`, `FUNPARACODNEW`, `FUNPARAESTNEW`, `FUNPARATVCNEW`, `FUNPARATCCNEW`, `FUNPARATECNEW`, `FUNPARATTCNEW`, `FUNPARAFUCNEW`, `FUNPARACICNEW`, `FUNPARABACNEW`, `FUNPARACASNEW`, `FUNPARACA1NEW`, `FUNPARACA2NEW`, `FUNPARACA3NEW`, `FUNPARAUBINEW`, `FUNPARATE1NEW`, `FUNPARACE1NEW`, `FUNPARACE2NEW`, `FUNPARAEMANEW`, `FUNPARAOBSNEW`) 
        VALUES ('UPDATE', NEW.`FUNPARAUS`, NOW(), OLD.`FUNPARAIP`, OLD.`FUNPARCOD`, OLD.`FUNPAREST`, OLD.`FUNPARTVC`, OLD.`FUNPARTCC`, OLD.`FUNPARTEC`, OLD.`FUNPARTTC`, OLD.`FUNPARFUC`, OLD.`FUNPARCIC`, OLD.`FUNPARBAC`, OLD.`FUNPARCAS`, OLD.`FUNPARCA1`, OLD.`FUNPARCA2`, OLD.`FUNPARCA3`, OLD.`FUNPARUBI`, OLD.`FUNPARTE1`, OLD.`FUNPARCE1`, OLD.`FUNPARCE2`, OLD.`FUNPAREMA`, OLD.`FUNPAROBS`, NEW.`FUNPARCOD`, NEW.`FUNPAREST`, NEW.`FUNPARTVC`, NEW.`FUNPARTCC`, NEW.`FUNPARTEC`, NEW.`FUNPARTTC`, NEW.`FUNPARFUC`, NEW.`FUNPARCIC`, NEW.`FUNPARBAC`, NEW.`FUNPARCAS`, NEW.`FUNPARCA1`, NEW.`FUNPARCA2`, NEW.`FUNPARCA3`, NEW.`FUNPARUBI`, NEW.`FUNPARTE1`, NEW.`FUNPARCE1`, NEW.`FUNPARCE2`, NEW.`FUNPAREMA`, NEW.`FUNPAROBS`);

ALTER TABLE `FUNPAR` ADD PRIMARY KEY (`FUNPARCOD`);
ALTER TABLE `FUNPAR` MODIFY `FUNPARCOD` mediumint(9) NOT NULL AUTO_INCREMENT COMMENT 'CÓDIGO', AUTO_INCREMENT=0;

ALTER TABLE `FUNPAR` ADD KEY `FUNPARTVC` (`FUNPARTVC`);
ALTER TABLE `FUNPAR` ADD CONSTRAINT `FK_FUNPAR_FUNPARTVC` FOREIGN KEY (`FUNPARTVC`) REFERENCES `DOMFIC` (`DOMFICCOD`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `FUNPAR` ADD KEY `FUNPARTCC` (`FUNPARTCC`);
ALTER TABLE `FUNPAR` ADD CONSTRAINT `FK_FUNPAR_FUNPARTCC` FOREIGN KEY (`FUNPARTCC`) REFERENCES `DOMFIC` (`DOMFICCOD`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `FUNPAR` ADD KEY `FUNPARTEC` (`FUNPARTEC`);
ALTER TABLE `FUNPAR` ADD CONSTRAINT `FK_FUNPAR_FUNPARTEC` FOREIGN KEY (`FUNPARTEC`) REFERENCES `DOMFIC` (`DOMFICCOD`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `FUNPAR` ADD KEY `FUNPARTTC` (`FUNPARTTC`);
ALTER TABLE `FUNPAR` ADD CONSTRAINT `FK_FUNPAR_FUNPARTTC` FOREIGN KEY (`FUNPARTTC`) REFERENCES `DOMFIC` (`DOMFICCOD`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `FUNPAR` ADD KEY `FUNPARFUC` (`FUNPARFUC`);
ALTER TABLE `FUNPAR` ADD CONSTRAINT `FK_FUNPAR_FUNPARFUC` FOREIGN KEY (`FUNPARFUC`) REFERENCES `FUNFIC` (`FUNFICCOD`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `FUNPAR` ADD KEY `FUNPARCIC` (`FUNPARCIC`);
ALTER TABLE `FUNPAR` ADD CONSTRAINT `FK_FUNPAR_FUNPARCIC` FOREIGN KEY (`FUNPARCIC`) REFERENCES `LOCCIU` (`LOCCIUCOD`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `FUNPAR` ADD KEY `FUNPARBAC` (`FUNPARBAC`);
ALTER TABLE `FUNPAR` ADD CONSTRAINT `FK_FUNPAR_FUNPARBAC` FOREIGN KEY (`FUNPARBAC`) REFERENCES `LOCBAR` (`LOCBARCOD`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `FUNPARA` ADD PRIMARY KEY (`FUNPARACOD`);
ALTER TABLE `FUNPARA` MODIFY `FUNPARACOD` int(11) NOT NULL AUTO_INCREMENT COMMENT 'CÓDIGO', AUTO_INCREMENT=0;
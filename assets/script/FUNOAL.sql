CREATE TABLE IF NOT EXISTS `FUNOAE` (
    `FUNOAECOD` mediumint(9) NOT NULL COMMENT 'CÓDIGO',
    `FUNOAEEST` char(1) COLLATE utf8_spanish_ci NOT NULL COMMENT 'ESTADO',
    `FUNOAEAEC` mediumint(9) NOT NULL COMMENT 'ACTIVIDAD ECONÓMICA',
    `FUNOAEFUC` mediumint(9) NOT NULL COMMENT 'FUNCIONARIO',
    `FUNOAENOM` varchar(100) COLLATE utf8_spanish_ci NULL COMMENT 'NOMBRE',
    `FUNOAEOBS` varchar(5120) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'OBSERVACIÓN',
    `FUNOAEAUS` char(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'USUARIO',
    `FUNOAEAFH` datetime NOT NULL COMMENT 'FECHA HORA',
    `FUNOAEAIP` char(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'IP'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='FUNCIONARIO OTRAS ACTIVIDADES ECONÓMICAS';

CREATE TABLE IF NOT EXISTS `FUNOAEA` (
    `FUNOAEACOD` int(11) NOT NULL COMMENT 'CÓDIGO',
    `FUNOAEAMET` char(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'MÉTODO',
    `FUNOAEAUSU` char(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'USUARIO',
    `FUNOAEAFEC` datetime NOT NULL COMMENT 'FECHA HORA',
    `FUNOAEADIP` char(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'IP',

    `FUNOAEACODOLD` mediumint(9) NULL COMMENT 'CÓDIGO OLD',
    `FUNOAEAESTOLD` char(1) COLLATE utf8_spanish_ci NULL COMMENT 'ESTADO OLD',
    `FUNOAEAAECOLD` mediumint(9) NULL COMMENT 'ACTIVIDAD ECONÓMICA OLD',
    `FUNOAEAFUCOLD` mediumint(9) NULL COMMENT 'FUNCIONARIO OLD',
    `FUNOAEANOMOLD` varchar(100) COLLATE utf8_spanish_ci NULL COMMENT 'NOMBRE OLD',
    `FUNOAEAOBSOLD` varchar(5120) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'OBSERVACIÓN OLD',

    `FUNOAEACODNEW` mediumint(9) NULL COMMENT 'CÓDIGO NEW',
    `FUNOAEAESTNEW` char(1) COLLATE utf8_spanish_ci NULL COMMENT 'ESTADO NEW',
    `FUNOAEAAECNEW` mediumint(9) NULL COMMENT 'ACTIVIDAD ECONÓMICA NEW',
    `FUNOAEAFUCNEW` mediumint(9) NULL COMMENT 'FUNCIONARIO NEW',
    `FUNOAEANOMNEW` varchar(100) COLLATE utf8_spanish_ci NULL COMMENT 'NOMBRE NEW',
    `FUNOAEAOBSNEW` varchar(5120) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'OBSERVACIÓN NEW'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='FUNCIONARIO OTRAS ACTIVIDADES ECONÓMICAS AUDITORÍA';

CREATE TRIGGER `FUNOAEDLT` BEFORE DELETE ON `FUNOAE`
    FOR EACH ROW 
        INSERT INTO `FUNOAEA` (`FUNOAEAMET`, `FUNOAEAUSU`, `FUNOAEAFEC`, `FUNOAEADIP`, `FUNOAEACODOLD`, `FUNOAEAESTOLD`, `FUNOAEAAECOLD`, `FUNOAEAFUCOLD`, `FUNOAEANOMOLD`, `FUNOAEAOBSOLD`) 
        VALUES ('DELETE', OLD.`FUNOAEAUS`, NOW(), OLD.`FUNOAEAIP`, OLD.`FUNOAECOD`, OLD.`FUNOAEEST`, OLD.`FUNOAEAEC`, OLD.`FUNOAEFUC`, OLD.`FUNOAENOM`, OLD.`FUNOAEOBS`);

CREATE TRIGGER `FUNOAEINS` AFTER INSERT ON `FUNOAE`
    FOR EACH ROW 
        INSERT INTO `FUNOAEA` (`FUNOAEAMET`, `FUNOAEAUSU`, `FUNOAEAFEC`, `FUNOAEADIP`, `FUNOAEACODNEW`, `FUNOAEAESTNEW`, `FUNOAEAAECNEW`, `FUNOAEAFUCNEW`, `FUNOAEANOMNEW`, `FUNOAEAOBSNEW`) 
        VALUES ('INSERT', NEW.`FUNOAEAUS`, NOW(), NEW.`FUNOAEAIP`, NEW.`FUNOAECOD`, NEW.`FUNOAEEST`, NEW.`FUNOAEAEC`, NEW.`FUNOAEFUC`, NEW.`FUNOAENOM`, NEW.`FUNOAEOBS`);

CREATE TRIGGER `FUNOAEUPD` AFTER UPDATE ON `FUNOAE`
    FOR EACH ROW 
        INSERT INTO `FUNOAEA` (`FUNOAEAMET`, `FUNOAEAUSU`, `FUNOAEAFEC`, `FUNOAEADIP`, `FUNOAEACODOLD`, `FUNOAEAESTOLD`, `FUNOAEAAECOLD`, `FUNOAEAFUCOLD`, `FUNOAEANOMOLD`, `FUNOAEAOBSOLD`, `FUNOAEACODNEW`, `FUNOAEAESTNEW`, `FUNOAEAAECNEW`, `FUNOAEAFUCNEW`, `FUNOAEANOMNEW`, `FUNOAEAOBSNEW`)  
        VALUES ('UPDATE', NEW.`FUNOAEAUS`, NOW(), NEW.`FUNOAEAIP`, OLD.`FUNOAECOD`, OLD.`FUNOAEEST`, OLD.`FUNOAEAEC`, OLD.`FUNOAEFUC`, OLD.`FUNOAENOM`, OLD.`FUNOAEOBS`, NEW.`FUNOAECOD`, NEW.`FUNOAEEST`, NEW.`FUNOAEAEC`, NEW.`FUNOAEFUC`, NEW.`FUNOAENOM`, NEW.`FUNOAEOBS`);

ALTER TABLE `FUNOAE` ADD PRIMARY KEY (`FUNOAECOD`);
ALTER TABLE `FUNOAE` MODIFY `FUNOAECOD` mediumint(9) NOT NULL AUTO_INCREMENT COMMENT 'CÓDIGO', AUTO_INCREMENT=0;
ALTER TABLE `FUNOAE` ADD KEY `FUNOAEAEC` (`FUNOAEAEC`);
ALTER TABLE `FUNOAE` ADD KEY `FUNOAEFUC` (`FUNOAEFUC`);
ALTER TABLE `FUNOAE` ADD CONSTRAINT `FK_FUNTRA_FUNOAEAEC` FOREIGN KEY (`FUNOAEAEC`) REFERENCES `DOMFIC` (`DOMFICCOD`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `FUNOAE` ADD CONSTRAINT `FK_FUNTRA_FUNOAEFUC` FOREIGN KEY (`FUNOAEFUC`) REFERENCES `FUNFIC` (`FUNFICCOD`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `FUNOAEA` ADD PRIMARY KEY (`FUNOAEACOD`);
ALTER TABLE `FUNOAEA` MODIFY `FUNOAEACOD` int(11) NOT NULL AUTO_INCREMENT COMMENT 'CÓDIGO', AUTO_INCREMENT=0;
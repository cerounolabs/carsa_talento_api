CREATE TABLE IF NOT EXISTS `FUNLOG` (
    `FUNLOGCOD` mediumint(9) NOT NULL COMMENT 'CÓDIGO',
    `FUNLOGEST` char(1) COLLATE utf8_spanish_ci NOT NULL COMMENT 'ESTADO',
    `FUNLOGUSU` varchar(100) COLLATE utf8_spanish_ci NOT NULL COMMENT 'USUARIO',
    `FUNLOGPAS` varchar(100) COLLATE utf8_spanish_ci NOT NULL COMMENT 'CONTRASEÑA',
    `FUNLOGDIR` varchar(100) COLLATE utf8_spanish_ci NOT NULL COMMENT 'DIRECCION IP',
    `FUNLOGHOS` varchar(100) COLLATE utf8_spanish_ci NOT NULL COMMENT 'HOST',
    `FUNLOGAGE` varchar(100) COLLATE utf8_spanish_ci NOT NULL COMMENT 'USER AGENT',
    `FUNLOGREF` varchar(100) COLLATE utf8_spanish_ci NOT NULL COMMENT 'REFERER',
    `FUNLOGAFH` datetime NOT NULL COMMENT 'FECHA HORA'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='FUNCIONARIO LOGIN';

ALTER TABLE `FUNLOG` ADD PRIMARY KEY (`FUNLOGCOD`);
ALTER TABLE `FUNLOG` MODIFY `FUNLOGCOD` mediumint(9) NOT NULL AUTO_INCREMENT COMMENT 'CÓDIGO', AUTO_INCREMENT=0;
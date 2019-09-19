<?php
    function getConnectionMSSQL(){
        $mssqlName = "SRVDESA01, 1433";
        $mssqlInfo = array("Database"=>"DESTRASJUD", "UID"=>"czelaya", "PWD"=>"carsa_2019", "CharacterSet"=>"UTF-8", "MultipleActiveResultSets"=>"false");
        $mssqlConn = sqlsrv_connect($mssqlName, $mssqlInfo);

        return $mssqlConn;
    }

    function getConnectionMYSQL(){
        $mysqlHost = "192.168.16.17";
        $mysqlUser = "root";
        $mysqlPass = "prabhupada1A+";
        $mysqlDb   = "carsa_talento";
        $mysqlConn = new mysqli($mysqlHost, $mysqlUser, $mysqlPass, $mysqlDb);
        $mysqlConn->set_charset("utf8");

        return $mysqlConn;
    }
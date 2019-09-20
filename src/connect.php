<?php
    function getConnectionMSSQL(){
        $serverName = "tcp:SRVDESA01.database.windows.net";
        $serverPort = "1433";
        $serverDb   = "DESTRASJUD";
        $serverUser = "czelaya";
        $serverPass = "carsa_2019";

        try {
            $conn = new PDO("sqlsrv:server=$servername,$serverPort;Database=$serverDb", $serverUser, $serverPass,
                array(
                    PDO::ATTR_PERSISTENT => true,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                )
            );
        } catch (PDOException $e) {
            echo ("Error connecting to MSSQL: " . $e->getMessage());
            die();
        }

        return $conn;
    }

    function getConnectionMYSQL(){
        $serverName = "192.168.16.17";
        $serverPort = "";
        $serverDb   = "carsa_talento";
        $serverUser = "talento_admin";
        $serverPass = "dlFGaCp2v48iPjHK";
        
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$serverDb;charset=utf8", $serverUser, $serverPass,
                array(
                    PDO::ATTR_PERSISTENT => true,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                )
            );
        } catch (PDOException $e) {
            echo ("Error connecting to MySQL: " . $e->getMessage());
            die();
        }

        return $conn;
    }
<?php
    function getConnectionMSSQL(){
        $serverName = "SRVDESA01";
        $serverPort = "1433";
        $serverDb   = "DESTRASJUD";
        $serverUser = "czelaya";
        $serverPass = "carsa_2019";

        try {
            $conn = new PDO("sqlsrv:server=$serverName,$serverPort;Database=$serverDb", $serverUser, $serverPass,
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
        $serverPort = "3306";
        $serverDb   = "carsa_talento";
        $serverUser = "talento_admin";
        $serverPass = "dlFGaCp2v48iPjHK";
        
        try {
            $conn = new PDO("mysql:host=$serverName;port=$serverPort;dbname=$serverDb;charset=utf8", $serverUser, $serverPass,
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
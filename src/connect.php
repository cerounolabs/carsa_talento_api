<?php
    function getConnectionMSSQL(){
        $serverName = "SRVDESA01";
        $serverName = "192.168.16.9";
        $serverPort = "1433";
        $serverDb   = "DESTRASJUD";
        $serverDb   = "PRODUCCION_AYER";
        $serverUser = "czelaya";
        $serverPass = "carsa_2019";
        
        try {
            $conn = new PDO("sqlsrv:Server=$serverName,$serverPort;Database=$serverDb;ConnectionPooling=0", $serverUser, $serverPass,
                array(
                    PDO::ATTR_PERSISTENT => false,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                )
            );
        } catch (PDOException $e) {
            header("Content-Type: application/json; charset=utf-8");
            echo json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error Connecting to MSSQL: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
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
            header("Content-Type: application/json; charset=utf-8");
            echo json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error Connecting to MYSQL: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            die();
        }

        return $conn;
    }

    function getConnectionMSSQLv1(){
        $serverName = "SRVDESA02";
        //$serverName = "192.168.16.9";
        $serverPort = "1433";
        $serverDb   = "PRODUCCION_AYER2";
        $serverUser = "czelaya";
        $serverPass = "carsa_2021";
        
        try {
            $conn = new PDO("sqlsrv:Server=$serverName,$serverPort;Database=$serverDb;ConnectionPooling=0", $serverUser, $serverPass,
                array(
                    PDO::ATTR_PERSISTENT => false,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                )
            );
        } catch (PDOException $e) {
            header("Content-Type: application/json; charset=utf-8");
            echo json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error Connecting to MSSQL: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            die();
        }

        return $conn;
    }

    function getConnectionMSSQLv2(){
        $serverName = "SRVDESA01";
        $serverName = "192.168.16.9";
        $serverPort = "1433";
        $serverDb   = "PRODUCCION_AYER";
        $serverUser = "czelaya";
        $serverPass = "carsa_2019";
        
        try {
            $conn = new PDO("sqlsrv:Server=$serverName,$serverPort;Database=$serverDb;ConnectionPooling=0", $serverUser, $serverPass,
                array(
                    PDO::ATTR_PERSISTENT => false,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                )
            );
        } catch (PDOException $e) {
            header("Content-Type: application/json; charset=utf-8");
            echo json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error Connecting to MSSQL: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            die();
        }

        return $conn;
    }

    function getConnectionPGSQLv1(){
        $serverName = "127.0.0.1";
        $serverPort = "5432";
        $serverDb   = "thholox_v10";
        $serverUser = "user_thholox";
        $serverPass = "ns3r_thh0l0x";
        
        try {
            $conn = new PDO("pgsql:host=$serverName;port=$serverPort;dbname=$serverDb", $serverUser, $serverPass,
                array(
                    PDO::ATTR_PERSISTENT => true,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                )
            );
        } catch (PDOException $e) {
            header("Content-Type: application/json; charset=utf-8");
            echo json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error Connecting to PGSQLv1: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            die();
        }

        return $conn;
    }

    function getConnectionPGSQLv2(){
        $serverName = "localhost";
        $serverPort = "5432";
        $serverDb   = "thholox_v20";
        $serverUser = "user_thholox";
        $serverPass = "ns3r_thh0l0x";
        
        try {
            $conn = new PDO("pgsql:host=$serverName;port=$serverPort;dbname=$serverDb", $serverUser, $serverPass,
                array(
                    PDO::ATTR_PERSISTENT => true,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                )
            );
        } catch (PDOException $e) {
            header("Content-Type: application/json; charset=utf-8");
            echo json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error Connecting to PGSQLv2: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            die();
        }

        return $conn;
    }
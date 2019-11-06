<?php
    require __DIR__.'/../src/connect.php';
    
    function setDepartamento(){
        $LOCDEPEST  = 'A';
        $LOCDEPOBS  = '';
        $LOCDEPAUS  = 'MIGRACION';
        $LOCDEPAFH  = date('Y-m-d H:i:s');
        $LOCDEPAIP  = '192.168.16.92';

        $sql00      = "SELECT a.AiDept AS departamento_codigo, a.AiNomb AS departamento_nombre FROM FST004 a ORDER BY a.AiNomb";
        $sql01      = "SELECT * FROM LOCDEP WHERE LOCDEPEQU = ?";
        $sql02      = "INSERT INTO LOCDEP (LOCDEPEST, LOCDEPNOM, LOCDEPEQU, LOCDEPOBS, LOCDEPAUS, LOCDEPAFH, LOCDEPAIP) VALUES (?, ?, ?, ?, ?, ?, ?)";

        try {
            $connMSSQL  = getConnectionMSSQL();
            $connMYSQL  = getConnectionMYSQL();

            $stmtMSSQL  = $connMSSQL->prepare($sql00);
            $stmtMSSQL->execute();

            $stmtMYSQL1 = $connMYSQL->prepare($sql01);
            $stmtMYSQL2 = $connMYSQL->prepare($sql02);

            while ($rowMSSQL = $stmtMSSQL->fetch()) {
                $LOCDEPEQU = $rowMSSQL['departamento_codigo'];
                $LOCDEPNOM = trim($rowMSSQL['departamento_nombre']);

                $stmtMYSQL1->execute([$LOCDEPEQU]);

                $rowMYSQL1 = $stmtMYSQL1->fetch(PDO::FETCH_ASSOC);
                    
                if (!$rowMYSQL1){
                    $stmtMYSQL2->execute([$LOCDEPEST, $LOCDEPNOM, $LOCDEPEQU, $LOCDEPOBS, $LOCDEPAUS, $LOCDEPAFH, $LOCDEPAIP]);
                }
            }

            $stmtMSSQL->closeCursor();
            $stmtMYSQL1->closeCursor();
            $stmtMYSQL2->closeCursor();

            $stmtMSSQL  = null;
            $stmtMYSQL1 = null;
            $stmtMYSQL2 = null;
        } catch (PDOException $e) {
            echo 'Error setDepartamento(): '.$e;
        }

        $connMSSQL  = null;
        $connMYSQL  = null;
    }

    function setCiudad(){
        $sql00  = "SELECT a.AiDept AS departamento_codigo, a.ApCiud AS ciudad_codigo, a.ApNomb AS ciudad_nombre FROM FST003 a ORDER BY a.AiDept, a.ApNomb";
        $sql01  = "SELECT * FROM LOCCIU a INNER JOIN LOCDEP b ON a.LOCCIUDEC = b.LOCDEPCOD WHERE a.LOCCIUEQU = ? AND b.LOCDEPEQU = ?";
        $sql02  = "INSERT INTO LOCCIU(LOCCIUEST, LOCCIUDEC, LOCCIUNOM, LOCCIUEQU, LOCCIUOBS, LOCCIUAUS, LOCCIUAFH, LOCCIUAIP) VALUES ('A', (SELECT LOCDEPCOD FROM LOCDEP WHERE LOCDEPEQU = ?), ?, ?, '', 'MIGRACION', NOW(), '192.168.16.92')";

        try {
            $connMSSQL  = getConnectionMSSQL();
            $connMYSQL  = getConnectionMYSQL();

            $stmtMSSQL  = $connMSSQL->prepare($sql00);
            $stmtMSSQL->execute();

            $stmtMYSQL1 = $connMYSQL->prepare($sql01);
            $stmtMYSQL2 = $connMYSQL->prepare($sql02);

            while ($rowMSSQL = $stmtMSSQL->fetch()) {
                $codDepto   = $rowMSSQL['departamento_codigo'];
                $codCiudad  = $rowMSSQL['ciudad_codigo'];
                $nomCiudad  = $rowMSSQL['ciudad_nombre'];

                $stmtMYSQL1->execute([$codCiudad, $codDepto]);

                $rowMSYQL1 = $stmtMYSQL1->fetch(PDO::FETCH_ASSOC);
                    
                if (!$rowMSYQL1){
                    $stmtMYSQL2->execute([$codDepto, $nomCiudad, $codCiudad]);
                }
            }

            $stmtMSSQL->closeCursor();
            $stmtMYSQL1->closeCursor();
            $stmtMYSQL2->closeCursor();

            $stmtMSSQL = null;
            $stmtMYSQL1 = null;
            $stmtMYSQL2 = null;
        } catch (PDOException $e) {
            echo 'Error setCiudad(): '.$e;
        }

        $connMSSQL  = null;
        $connMYSQL  = null;
    }

    function setEstadoCivil(){
        $DOMFICEST  = 'A';
        $DOMFICNOM  = '';
        $DOMFICEQU  = '';
        $DOMFICVAL  = 'ESTADOCIVIL';
        $DOMFICOBS  = '';
        $DOMFICAUS  = 'MIGRACION';
        $DOMFICAFH  = date('Y-m-d H:i:s');
        $DOMFICAIP  = '192.168.16.92';

        $sql00      = "SELECT a.ECCod AS estado_civil_codigo, a.ECDsc AS estado_civil_nombre FROM ESTCIV a ORDER BY a.ECDsc";
        $sql01      = "SELECT * FROM DOMFIC WHERE DOMFICEQU = ? AND DOMFICVAL = ?";
        $sql02      = "INSERT INTO DOMFIC (DOMFICEST, DOMFICNOM, DOMFICEQU, DOMFICVAL, DOMFICOBS, DOMFICAUS, DOMFICAFH, DOMFICAIP) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        try {
            $connMSSQL  = getConnectionMSSQL();
            $connMYSQL  = getConnectionMYSQL();

            $stmtMSSQL  = $connMSSQL->prepare($sql00);
            $stmtMSSQL->execute();

            $stmtMYSQL1 = $connMYSQL->prepare($sql01);
            $stmtMYSQL2 = $connMYSQL->prepare($sql02);

            while ($rowMSSQL = $stmtMSSQL->fetch()) {
                $DOMFICEQU = $rowMSSQL['estado_civil_codigo'];
                $DOMFICNOM = trim($rowMSSQL['estado_civil_nombre']);

                $stmtMYSQL1->execute([$DOMFICEQU, $DOMFICVAL]);

                $rowMYSQL1 = $stmtMYSQL1->fetch(PDO::FETCH_ASSOC);
                    
                if (!$rowMYSQL1){
                    $stmtMYSQL2->execute([$DOMFICEST, $DOMFICNOM, $DOMFICEQU, $DOMFICVAL, $DOMFICOBS, $DOMFICAUS, $DOMFICAFH, $DOMFICAIP]);
                }
            }

            $stmtMSSQL->closeCursor();
            $stmtMYSQL1->closeCursor();
            $stmtMYSQL2->closeCursor();

            $stmtMSSQL  = null;
            $stmtMYSQL1 = null;
            $stmtMYSQL2 = null;
        } catch (PDOException $e) {
            echo 'Error setDepartamento(): '.$e;
        }

        $connMSSQL  = null;
        $connMYSQL  = null;
    }

    function setMotivoDespido(){
        $DOMFICEST  = 'A';
        $DOMFICNOM  = '';
        $DOMFICEQU  = '';
        $DOMFICVAL  = 'MOTIVOSALIDA';
        $DOMFICOBS  = '';
        $DOMFICAUS  = 'MIGRACION';
        $DOMFICAFH  = date('Y-m-d H:i:s');
        $DOMFICAIP  = '192.168.16.92';

        $sql00      = "SELECT a.FuDesvCod AS motivo_despido_codigo, a.FuDesvDesc AS motivo_despido_nombre FROM FUMOTDESV a WHERE a.FuDesvDesc IS NOT NULL ORDER BY a.FuDesvDesc";
        $sql01      = "SELECT * FROM DOMFIC WHERE DOMFICEQU = ? AND DOMFICVAL = ?";
        $sql02      = "INSERT INTO DOMFIC (DOMFICEST, DOMFICNOM, DOMFICEQU, DOMFICVAL, DOMFICOBS, DOMFICAUS, DOMFICAFH, DOMFICAIP) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        try {
            $connMSSQL  = getConnectionMSSQL();
            $connMYSQL  = getConnectionMYSQL();

            $stmtMSSQL  = $connMSSQL->prepare($sql00);
            $stmtMSSQL->execute();

            $stmtMYSQL1 = $connMYSQL->prepare($sql01);
            $stmtMYSQL2 = $connMYSQL->prepare($sql02);

            while ($rowMSSQL = $stmtMSSQL->fetch()) {
                $DOMFICEQU = $rowMSSQL['motivo_despido_codigo'];
                $DOMFICNOM = trim($rowMSSQL['motivo_despido_nombre']);

                $stmtMYSQL1->execute([$DOMFICEQU, $DOMFICVAL]);

                $rowMYSQL1 = $stmtMYSQL1->fetch(PDO::FETCH_ASSOC);
                    
                if (!$rowMYSQL1){
                    $stmtMYSQL2->execute([$DOMFICEST, $DOMFICNOM, $DOMFICEQU, $DOMFICVAL, $DOMFICOBS, $DOMFICAUS, $DOMFICAFH, $DOMFICAIP]);
                }
            }

            $stmtMSSQL->closeCursor();
            $stmtMYSQL1->closeCursor();
            $stmtMYSQL2->closeCursor();

            $stmtMSSQL  = null;
            $stmtMYSQL1 = null;
            $stmtMYSQL2 = null;
        } catch (PDOException $e) {
            echo 'Error setDepartamento(): '.$e;
        }

        $connMSSQL  = null;
        $connMYSQL  = null;
    }

    function setHobbies(){
        $DOMFICEST  = 'A';
        $DOMFICNOM  = '';
        $DOMFICEQU  = '';
        $DOMFICVAL  = 'HOBBIES';
        $DOMFICOBS  = '';
        $DOMFICAUS  = 'MIGRACION';
        $DOMFICAFH  = date('Y-m-d H:i:s');
        $DOMFICAIP  = '192.168.16.92';

        $sql00      = "SELECT a.RRHH231ID AS hobbies_codigo, a.RRHH231DSC AS hobbies_nombre FROM RRHH231 a ORDER BY a.RRHH231ID";
        $sql01      = "SELECT * FROM DOMFIC WHERE DOMFICEQU = ? AND DOMFICVAL = ?";
        $sql02      = "INSERT INTO DOMFIC (DOMFICEST, DOMFICNOM, DOMFICEQU, DOMFICVAL, DOMFICOBS, DOMFICAUS, DOMFICAFH, DOMFICAIP) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        try {
            $connMSSQL  = getConnectionMSSQL();
            $connMYSQL  = getConnectionMYSQL();

            $stmtMSSQL  = $connMSSQL->prepare($sql00);
            $stmtMSSQL->execute();

            $stmtMYSQL1 = $connMYSQL->prepare($sql01);
            $stmtMYSQL2 = $connMYSQL->prepare($sql02);

            while ($rowMSSQL = $stmtMSSQL->fetch()) {
                $DOMFICEQU = $rowMSSQL['hobbies_codigo'];
                $DOMFICNOM = trim($rowMSSQL['hobbies_nombre']);

                $stmtMYSQL1->execute([$DOMFICEQU, $DOMFICVAL]);

                $rowMYSQL1 = $stmtMYSQL1->fetch(PDO::FETCH_ASSOC);
                    
                if (!$rowMYSQL1){
                    $stmtMYSQL2->execute([$DOMFICEST, $DOMFICNOM, $DOMFICEQU, $DOMFICVAL, $DOMFICOBS, $DOMFICAUS, $DOMFICAFH, $DOMFICAIP]);
                }
            }

            $stmtMSSQL->closeCursor();
            $stmtMYSQL1->closeCursor();
            $stmtMYSQL2->closeCursor();

            $stmtMSSQL  = null;
            $stmtMYSQL1 = null;
            $stmtMYSQL2 = null;
        } catch (PDOException $e) {
            echo 'Error setDepartamento(): '.$e;
        }

        $connMSSQL  = null;
        $connMYSQL  = null;
    }

    function setParentezco(){
        $DOMFICEST  = 'A';
        $DOMFICNOM  = '';
        $DOMFICEQU  = '';
        $DOMFICVAL  = 'PARENTESCO';
        $DOMFICOBS  = '';
        $DOMFICAUS  = 'MIGRACION';
        $DOMFICAFH  = date('Y-m-d H:i:s');
        $DOMFICAIP  = '192.168.16.92';

        $sql00      = "SELECT a.FGPARAMNUM AS parentezco_codigo, a.FGPARAMVC AS parentezco_nombre FROM FGPARAM a WHERE a.FGPARAMDES = 'Parametros de Parentezco. TH' ORDER BY a.FGPARAMNUM";
        $sql01      = "SELECT * FROM DOMFIC WHERE DOMFICEQU = ? AND DOMFICVAL = ?";
        $sql02      = "INSERT INTO DOMFIC (DOMFICEST, DOMFICNOM, DOMFICEQU, DOMFICVAL, DOMFICOBS, DOMFICAUS, DOMFICAFH, DOMFICAIP) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        try {
            $connMSSQL  = getConnectionMSSQL();
            $connMYSQL  = getConnectionMYSQL();

            $stmtMSSQL  = $connMSSQL->prepare($sql00);
            $stmtMSSQL->execute();

            $stmtMYSQL1 = $connMYSQL->prepare($sql01);
            $stmtMYSQL2 = $connMYSQL->prepare($sql02);

            while ($rowMSSQL = $stmtMSSQL->fetch()) {
                $DOMFICEQU = $rowMSSQL['parentezco_codigo'];
                $DOMFICNOM = trim($rowMSSQL['parentezco_nombre']);

                $stmtMYSQL1->execute([$DOMFICEQU, $DOMFICVAL]);

                $rowMYSQL1 = $stmtMYSQL1->fetch(PDO::FETCH_ASSOC);
                    
                if (!$rowMYSQL1){
                    $stmtMYSQL2->execute([$DOMFICEST, $DOMFICNOM, $DOMFICEQU, $DOMFICVAL, $DOMFICOBS, $DOMFICAUS, $DOMFICAFH, $DOMFICAIP]);
                }
            }

            $stmtMSSQL->closeCursor();
            $stmtMYSQL1->closeCursor();
            $stmtMYSQL2->closeCursor();

            $stmtMSSQL  = null;
            $stmtMYSQL1 = null;
            $stmtMYSQL2 = null;
        } catch (PDOException $e) {
            echo 'Error setDepartamento(): '.$e;
        }

        $connMSSQL  = null;
        $connMYSQL  = null;
    }

    function setCargo(){
        $DOMFICEST  = 'A';
        $DOMFICNOM  = '';
        $DOMFICEQU  = '';
        $DOMFICVAL  = 'CARGOOCUPADO';
        $DOMFICOBS  = '';
        $DOMFICAUS  = 'MIGRACION';
        $DOMFICAFH  = date('Y-m-d H:i:s');
        $DOMFICAIP  = '192.168.16.92';

        $sql00      = "SELECT a.CjCar AS cargo_codigo, a.CjNom AS cargo_nombre, a.CjAbr AS cargo_abreviado FROM FST053 a ORDER BY a.CjNom";
        $sql01      = "SELECT * FROM DOMFIC WHERE DOMFICEQU = ? AND DOMFICVAL = ?";
        $sql02      = "INSERT INTO DOMFIC (DOMFICEST, DOMFICNOM, DOMFICEQU, DOMFICVAL, DOMFICOBS, DOMFICAUS, DOMFICAFH, DOMFICAIP) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        try {
            $connMSSQL  = getConnectionMSSQL();
            $connMYSQL  = getConnectionMYSQL();

            $stmtMSSQL  = $connMSSQL->prepare($sql00);
            $stmtMSSQL->execute();

            $stmtMYSQL1 = $connMYSQL->prepare($sql01);
            $stmtMYSQL2 = $connMYSQL->prepare($sql02);

            while ($rowMSSQL = $stmtMSSQL->fetch()) {
                $DOMFICEQU = $rowMSSQL['cargo_codigo'];
                $DOMFICNOM = trim($rowMSSQL['cargo_nombre']);

                $stmtMYSQL1->execute([$DOMFICEQU, $DOMFICVAL]);

                $rowMYSQL1 = $stmtMYSQL1->fetch(PDO::FETCH_ASSOC);
                    
                if (!$rowMYSQL1){
                    $stmtMYSQL2->execute([$DOMFICEST, $DOMFICNOM, $DOMFICEQU, $DOMFICVAL, $DOMFICOBS, $DOMFICAUS, $DOMFICAFH, $DOMFICAIP]);
                }
            }

            $stmtMSSQL->closeCursor();
            $stmtMYSQL1->closeCursor();
            $stmtMYSQL2->closeCursor();

            $stmtMSSQL  = null;
            $stmtMYSQL1 = null;
            $stmtMYSQL2 = null;
        } catch (PDOException $e) {
            echo 'Error setDepartamento(): '.$e;
        }

        $connMSSQL  = null;
        $connMYSQL  = null;
    }

    echo "\n";
    echo "++++++++++++++++++++++++++PROCESO DE MIGRACIÓN++++++++++++++++++++++++++";
    echo "\n";
    echo "++++++++++++++++ SISTEMA CORPORATIVO => SISTEMA TALENTO ++++++++++++++++";
    echo "\n";
    echo "INICIO setDepartamento() => ".date('Y-m-d H:i:s');
    echo "\n";
    setDepartamento();
    echo "\n";
    echo "FIN setDepartamento() => ".date('Y-m-d H:i:s');
    echo "\n";
    echo "INICIO setCiudad() => ".date('Y-m-d H:i:s');
    echo "\n";
    setCiudad();
    echo "\n";
    echo "FIN setCiudad() => ".date('Y-m-d H:i:s');
    echo "\n";
    echo "INICIO setEstadoCivil() => ".date('Y-m-d H:i:s');
    echo "\n";
    setEstadoCivil();
    echo "\n";
    echo "FIN setEstadoCivil() => ".date('Y-m-d H:i:s');
    echo "\n";
    echo "INICIO setMotivoDespido() => ".date('Y-m-d H:i:s');
    echo "\n";
    setMotivoDespido();
    echo "\n";
    echo "FIN setMotivoDespido() => ".date('Y-m-d H:i:s');
    echo "\n";
    echo "INICIO setHobbies() => ".date('Y-m-d H:i:s');
    echo "\n";
    setHobbies();
    echo "\n";
    echo "FIN setHobbies() => ".date('Y-m-d H:i:s');
    echo "\n";
    echo "INICIO setParentezco() => ".date('Y-m-d H:i:s');
    echo "\n";
    setParentezco();
    echo "\n";
    echo "FIN setParentezco() => ".date('Y-m-d H:i:s');
    echo "\n";
    echo "INICIO setCargo() => ".date('Y-m-d H:i:s');
    echo "\n";
    setCargo();
    echo "\n";
    echo "FIN setCargo() => ".date('Y-m-d H:i:s');
    echo "\n";
    echo "++++++++++++++++++++++++++PROCESO DE MIGRACIÓN++++++++++++++++++++++++++";
    echo "\n";
?>
<?php
    require __DIR__.'/../src/connect.php';

    function getEstadoCivil(){
        $DOMFICEST  = 1;
        $DOMFICNOM  = '';
        $DOMFICEQU  = '';
        $DOMFICVAL  = 'PERSONAESTADOCIVIL';
        $DOMFICOBS  = '';
        $DOMFICAUS  = 'MIGRACION';
        $DOMFICAFH  = date('Y-m-d H:i:s');
        $DOMFICAIP  = '192.168.16.9';

        $sql00      = "SELECT a.ECCod AS estado_civil_codigo, a.ECDsc AS estado_civil_nombre FROM ESTCIV a ORDER BY a.ECDsc";
        $sql01      = "SELECT * FROM sistema.DOMFIC WHERE DOMFICEQU = ? AND DOMFICVAL = ?";
        $sql02      = "INSERT INTO sistema.DOMFIC (DOMFICEST, DOMFICNOM, DOMFICEQU, DOMFICVAL, DOMFICOBS, DOMFICAUS, DOMFICAFH, DOMFICAIP) VALUES (?, ?, ?, ?, ?, ?, NOW(), ?)";

        try {
            $connMSSQL  = getConnectionMSSQLv1();
            $connPGSQL  = getConnectionPGSQLv1();

            $stmtMSSQL  = $connMSSQL->prepare($sql00);
            $stmtMSSQL->execute();

            $stmtPGSQL1 = $connPGSQL->prepare($sql01);
            $stmtPGSQL2 = $connPGSQL->prepare($sql02);

            while ($rowMSSQL = $stmtMSSQL->fetch()) {
                $DOMFICEQU  = $rowMSSQL['estado_civil_codigo'];
                $DOMFICNOM  = strtoupper(strtolower(trim($rowMSSQL['estado_civil_nombre'])));

                $stmtPGSQL1->execute([$DOMFICEQU, $DOMFICVAL]);

                $rowPGSQL1  = $stmtPGSQL1->fetch(PDO::FETCH_ASSOC);
                    
                if (!$rowPGSQL1){
                    $stmtPGSQL2->execute([$DOMFICEST, $DOMFICNOM, $DOMFICEQU, $DOMFICVAL, $DOMFICOBS, $DOMFICAUS, $DOMFICAIP]);
                }
            }

            $stmtMSSQL->closeCursor();
            $stmtPGSQL1->closeCursor();
            $stmtPGSQL2->closeCursor();

            $stmtMSSQL  = null;
            $stmtPGSQL1 = null;
            $stmtPGSQL2 = null;
        } catch (PDOException $e) {
            echo "\n";
            echo 'Error getEstadoCivil(): '.$e;
        }

        $connMSSQL  = null;
        $connPGSQL  = null;
    }

    function getTelCelPrefijo(){
        $DOMFICEST  = 1;
        $DOMFICNOM  = '';
        $DOMFICEQU  = '';
        $DOMFICVAL  = 'TELEFONIAPREFIJOTEL';
        $DOMFICOBS  = '';
        $DOMFICAUS  = 'MIGRACION';
        $DOMFICAFH  = date('Y-m-d H:i:s');
        $DOMFICAIP  = '192.168.16.9';

        $sql00      = "SELECT a.CelLBId AS prefijo_codigo, a.CelLB AS prefijo_numero, a.CelLBTipo AS prefijo_tipo FROM PrefCelLB a ORDER BY a.CelLBTipo";
        $sql01      = "SELECT * FROM sistema.DOMFIC WHERE DOMFICEQU = ? AND DOMFICVAL = ?";
        $sql02      = "INSERT INTO sistema.DOMFIC (DOMFICEST, DOMFICNOM, DOMFICEQU, DOMFICVAL, DOMFICOBS, DOMFICAUS, DOMFICAFH, DOMFICAIP) VALUES (?, ?, ?, ?, ?, ?, NOW(), ?)";

        try {
            $connMSSQL  = getConnectionMSSQLv1();
            $connPGSQL  = getConnectionPGSQLv1();

            $stmtMSSQL  = $connMSSQL->prepare($sql00);
            $stmtMSSQL->execute();

            $stmtPGSQL1 = $connPGSQL->prepare($sql01);
            $stmtPGSQL2 = $connPGSQL->prepare($sql02);

            while ($rowMSSQL = $stmtMSSQL->fetch()) {
                $DOMFICEQU = $rowMSSQL['prefijo_codigo'];
                $DOMFICNOM = '+595 '.substr(trim($rowMSSQL['prefijo_numero']), 1);

                if (trim(strtoupper($rowMSSQL['prefijo_tipo'])) === 'TELEFONO'){
                    $DOMFICVAL  = 'TELEFONIAPREFIJOTEL';
                } else {
                    $DOMFICVAL  = 'TELEFONIAPREFIJOCEL';
                }

                $stmtPGSQL1->execute([$DOMFICEQU, $DOMFICVAL]);

                $rowPGSQL1 = $stmtPGSQL1->fetch(PDO::FETCH_ASSOC);
                    
                if (!$rowPGSQL1){
                    $stmtPGSQL2->execute([$DOMFICEST, $DOMFICNOM, $DOMFICEQU, $DOMFICVAL, $DOMFICOBS, $DOMFICAUS, $DOMFICAIP]);
                }
            }

            $stmtMSSQL->closeCursor();
            $stmtPGSQL1->closeCursor();
            $stmtPGSQL2->closeCursor();

            $stmtMSSQL  = null;
            $stmtPGSQL1 = null;
            $stmtPGSQL2 = null;
        } catch (PDOException $e) {
            echo "\n";
            echo 'Error getTelCelPrefijo(): '.$e;
        }

        $connMSSQL  = null;
        $connPGSQL  = null;
    }

    function getParentesco(){
        $DOMFICEST  = 1;
        $DOMFICNOM  = '';
        $DOMFICEQU  = '';
        $DOMFICVAL  = 'PERSONAPARENTESCO';
        $DOMFICOBS  = '';
        $DOMFICAUS  = 'MIGRACION';
        $DOMFICAFH  = date('Y-m-d H:i:s');
        $DOMFICAIP  = '192.168.16.92';

        $sql00      = "SELECT a.FGPARAMNUM AS parentezco_codigo, a.FGPARAMVC AS parentezco_nombre FROM FGPARAM a WHERE a.FGPARAMDES = 'Parametros de Parentezco. TH' ORDER BY a.FGPARAMNUM";
        $sql01      = "SELECT * FROM sistema.DOMFIC WHERE DOMFICEQU = ? AND DOMFICVAL = ?";
        $sql02      = "INSERT INTO sistema.DOMFIC (DOMFICEST, DOMFICNOM, DOMFICEQU, DOMFICVAL, DOMFICOBS, DOMFICAUS, DOMFICAFH, DOMFICAIP) VALUES (?, ?, ?, ?, ?, ?, NOW(), ?)";

        try {
            $connMSSQL  = getConnectionMSSQLv1();
            $connPGSQL  = getConnectionPGSQLv1();

            $stmtMSSQL  = $connMSSQL->prepare($sql00);
            $stmtMSSQL->execute();

            $stmtPGSQL1 = $connPGSQL->prepare($sql01);
            $stmtPGSQL2 = $connPGSQL->prepare($sql02);

            while ($rowMSSQL = $stmtMSSQL->fetch()) {
                $DOMFICEQU  = $rowMSSQL['parentezco_codigo'];
                $DOMFICNOM  = strtoupper(strtolower(trim($rowMSSQL['parentezco_nombre'])));

                $stmtPGSQL1->execute([$DOMFICEQU, $DOMFICVAL]);

                $rowPGSQL1 = $stmtPGSQL1->fetch(PDO::FETCH_ASSOC);
                    
                if (!$rowPGSQL1){
                    $stmtPGSQL2->execute([$DOMFICEST, $DOMFICNOM, $DOMFICEQU, $DOMFICVAL, $DOMFICOBS, $DOMFICAUS, $DOMFICAIP]);
                }
            }

            $stmtMSSQL->closeCursor();
            $stmtPGSQL1->closeCursor();
            $stmtPGSQL2->closeCursor();

            $stmtMSSQL  = null;
            $stmtPGSQL1 = null;
            $stmtPGSQL2 = null;
        } catch (PDOException $e) {
            echo "\n";
            echo 'Error getParentesco(): '.$e;
        }

        $connMSSQL  = null;
        $connPGSQL  = null;
    }

    function getUniversidad(){
        $DOMFICEST  = 1;
        $DOMFICNOM  = '';
        $DOMFICEQU  = '';
        $DOMFICVAL  = 'ACADEMICOUNIVERSIDAD';
        $DOMFICOBS  = '';
        $DOMFICAUS  = 'MIGRACION';
        $DOMFICAFH  = date('Y-m-d H:i:s');
        $DOMFICAIP  = '192.168.16.92';

        $sql00      = "SELECT a.AyUniv AS universidad_codigo, a.AyNomb AS universidad_nombre, a.AyCort AS universidad_abreviado FROM FST037 a ORDER BY a.AyNomb";
        $sql01      = "SELECT * FROM sistema.DOMFIC WHERE DOMFICEQU = ? AND DOMFICVAL = ?";
        $sql02      = "INSERT INTO sistema.DOMFIC (DOMFICEST, DOMFICNOM, DOMFICEQU, DOMFICVAL, DOMFICOBS, DOMFICAUS, DOMFICAFH, DOMFICAIP) VALUES (?, ?, ?, ?, ?, ?, NOW(), ?)";

        try {
            $connMSSQL  = getConnectionMSSQLv1();
            $connPGSQL  = getConnectionPGSQLv1();

            $stmtMSSQL  = $connMSSQL->prepare($sql00);
            $stmtMSSQL->execute();

            $stmtPGSQL1 = $connPGSQL->prepare($sql01);
            $stmtPGSQL2 = $connPGSQL->prepare($sql02);

            while ($rowMSSQL = $stmtMSSQL->fetch()) {
                $DOMFICEQU  = $rowMSSQL['universidad_codigo'];
                $DOMFICNOM  = strtoupper(strtolower(trim($rowMSSQL['universidad_nombre'])));

                $stmtPGSQL1->execute([$DOMFICEQU, $DOMFICVAL]);

                $rowPGSQL1 = $stmtPGSQL1->fetch(PDO::FETCH_ASSOC);
                    
                if (!$rowPGSQL1){
                    $stmtPGSQL2->execute([$DOMFICEST, $DOMFICNOM, $DOMFICEQU, $DOMFICVAL, $DOMFICOBS, $DOMFICAUS, $DOMFICAIP]);
                }
            }

            $stmtMSSQL->closeCursor();
            $stmtPGSQL1->closeCursor();
            $stmtPGSQL2->closeCursor();

            $stmtMSSQL  = null;
            $stmtPGSQL1 = null;
            $stmtPGSQL2 = null;
        } catch (PDOException $e) {
            echo "\n";
            echo 'Error getUniversidad(): '.$e;
        }

        $connMSSQL  = null;
        $connPGSQL  = null;
    }

    function getCarrera(){
        $DOMFICEST  = 1;
        $DOMFICNOM  = '';
        $DOMFICEQU  = '';
        $DOMFICVAL  = 'ACADEMICOCARRERA';
        $DOMFICOBS  = '';
        $DOMFICAUS  = 'MIGRACION';
        $DOMFICAFH  = date('Y-m-d H:i:s');
        $DOMFICAIP  = '192.168.16.92';

        $sql00      = "SELECT a.aqcarr AS carrera_codigo, a.aqdesc AS carrera_nombre, a.csval8 AS carrera_abreviado FROM FST038 a ORDER BY a.aqdesc";
        $sql01      = "SELECT * FROM sistema.DOMFIC WHERE DOMFICEQU = ? AND DOMFICVAL = ?";
        $sql02      = "INSERT INTO sistema.DOMFIC (DOMFICEST, DOMFICNOM, DOMFICEQU, DOMFICVAL, DOMFICOBS, DOMFICAUS, DOMFICAFH, DOMFICAIP) VALUES (?, ?, ?, ?, ?, ?, NOW(), ?)";

        try {
            $connMSSQL  = getConnectionMSSQLv1();
            $connPGSQL  = getConnectionPGSQLv1();

            $stmtMSSQL  = $connMSSQL->prepare($sql00);
            $stmtMSSQL->execute();

            $stmtPGSQL1 = $connPGSQL->prepare($sql01);
            $stmtPGSQL2 = $connPGSQL->prepare($sql02);

            while ($rowMSSQL = $stmtMSSQL->fetch()) {
                $DOMFICEQU  = $rowMSSQL['carrera_codigo'];
                $DOMFICNOM  = strtoupper(strtolower(trim($rowMSSQL['carrera_nombre'])));

                $stmtPGSQL1->execute([$DOMFICEQU, $DOMFICVAL]);

                $rowPGSQL1  = $stmtPGSQL1->fetch(PDO::FETCH_ASSOC);
                    
                if (!$rowPGSQL1){
                    $stmtPGSQL2->execute([$DOMFICEST, $DOMFICNOM, $DOMFICEQU, $DOMFICVAL, $DOMFICOBS, $DOMFICAUS, $DOMFICAIP]);
                }
            }

            $stmtMSSQL->closeCursor();
            $stmtPGSQL1->closeCursor();
            $stmtPGSQL2->closeCursor();

            $stmtMSSQL  = null;
            $stmtPGSQL1 = null;
            $stmtPGSQL2 = null;
        } catch (PDOException $e) {
            echo "\n";
            echo 'Error getCarrera(): '.$e;
        }

        $connMSSQL  = null;
        $connPGSQL  = null;
    }

    function getHobbies(){
        $DOMFICEST  = 1;
        $DOMFICNOM  = '';
        $DOMFICEQU  = '';
        $DOMFICVAL  = 'PERSONAHOBBIES';
        $DOMFICOBS  = '';
        $DOMFICAUS  = 'MIGRACION';
        $DOMFICAFH  = date('Y-m-d H:i:s');
        $DOMFICAIP  = '192.168.16.92';

        $sql00      = "SELECT a.RRHH231ID AS hobbies_codigo, a.RRHH231DSC AS hobbies_nombre FROM RRHH231 a ORDER BY a.RRHH231ID";
        $sql01      = "SELECT * FROM sistema.DOMFIC WHERE DOMFICEQU = ? AND DOMFICVAL = ?";
        $sql02      = "INSERT INTO sistema.DOMFIC (DOMFICEST, DOMFICNOM, DOMFICEQU, DOMFICVAL, DOMFICOBS, DOMFICAUS, DOMFICAFH, DOMFICAIP) VALUES (?, ?, ?, ?, ?, ?, NOW(), ?)";

        try {
            $connMSSQL  = getConnectionMSSQLv1();
            $connPGSQL  = getConnectionPGSQLv1();

            $stmtMSSQL  = $connMSSQL->prepare($sql00);
            $stmtMSSQL->execute();

            $stmtPGSQL1 = $connPGSQL->prepare($sql01);
            $stmtPGSQL2 = $connPGSQL->prepare($sql02);

            while ($rowMSSQL = $stmtMSSQL->fetch()) {
                $DOMFICEQU  = $rowMSSQL['hobbies_codigo'];
                $DOMFICNOM  = strtoupper(strtolower(trim($rowMSSQL['hobbies_nombre'])));

                $stmtPGSQL1->execute([$DOMFICEQU, $DOMFICVAL]);

                $rowPGSQL1  = $stmtPGSQL1->fetch(PDO::FETCH_ASSOC);
                    
                if (!$rowPGSQL1){
                    $stmtPGSQL2->execute([$DOMFICEST, $DOMFICNOM, $DOMFICEQU, $DOMFICVAL, $DOMFICOBS, $DOMFICAUS, $DOMFICAIP]);
                }
            }

            $stmtMSSQL->closeCursor();
            $stmtPGSQL1->closeCursor();
            $stmtPGSQL2->closeCursor();

            $stmtMSSQL  = null;
            $stmtPGSQL1 = null;
            $stmtPGSQL2 = null;
        } catch (PDOException $e) {
            echo "\n";
            echo 'Error getHobbies(): '.$e;
        }

        $connMSSQL  = null;
        $connPGSQL  = null;
    }

    function getCargo(){
        $DOMFICEST  = 1;
        $DOMFICNOM  = '';
        $DOMFICEQU  = '';
        $DOMFICVAL  = 'COLABORADORCARGOOCUPADO';
        $DOMFICOBS  = '';
        $DOMFICAUS  = 'MIGRACION';
        $DOMFICAFH  = date('Y-m-d H:i:s');
        $DOMFICAIP  = '192.168.16.92';

        $sql00      = "SELECT a.CjCar AS cargo_codigo, a.CjNom AS cargo_nombre, a.CjAbr AS cargo_abreviado FROM FST053 a ORDER BY a.CjNom";
        $sql01      = "SELECT * FROM sistema.DOMFIC WHERE DOMFICEQU = ? AND DOMFICVAL = ?";
        $sql02      = "INSERT INTO sistema.DOMFIC (DOMFICEST, DOMFICNOM, DOMFICEQU, DOMFICVAL, DOMFICOBS, DOMFICAUS, DOMFICAFH, DOMFICAIP) VALUES (?, ?, ?, ?, ?, ?, NOW(), ?)";

        try {
            $connMSSQL  = getConnectionMSSQLv1();
            $connPGSQL  = getConnectionPGSQLv1();

            $stmtMSSQL  = $connMSSQL->prepare($sql00);
            $stmtMSSQL->execute();

            $stmtPGSQL1 = $connPGSQL->prepare($sql01);
            $stmtPGSQL2 = $connPGSQL->prepare($sql02);

            while ($rowMSSQL = $stmtMSSQL->fetch()) {
                $DOMFICEQU  = $rowMSSQL['cargo_codigo'];
                $DOMFICNOM  = strtoupper(strtolower(trim($rowMSSQL['cargo_nombre'])));

                $stmtPGSQL1->execute([$DOMFICEQU, $DOMFICVAL]);

                $rowPGSQL1  = $stmtPGSQL1->fetch(PDO::FETCH_ASSOC);
                    
                if (!$rowPGSQL1){
                    $stmtPGSQL2->execute([$DOMFICEST, $DOMFICNOM, $DOMFICEQU, $DOMFICVAL, $DOMFICOBS, $DOMFICAUS, $DOMFICAIP]);
                }
            }

            $stmtMSSQL->closeCursor();
            $stmtPGSQL1->closeCursor();
            $stmtPGSQL2->closeCursor();

            $stmtMSSQL  = null;
            $stmtPGSQL1 = null;
            $stmtPGSQL2 = null;
        } catch (PDOException $e) {
            echo "\n";
            echo 'Error getCargo(): '.$e;
        }

        $connMSSQL  = null;
        $connPGSQL  = null;
    }

    function getMotivoDespido(){
        $DOMFICEST  = 1;
        $DOMFICNOM  = '';
        $DOMFICEQU  = '';
        $DOMFICVAL  = 'COLABORADORMOTIVOSALIDA';
        $DOMFICOBS  = '';
        $DOMFICAUS  = 'MIGRACION';
        $DOMFICAFH  = date('Y-m-d H:i:s');
        $DOMFICAIP  = '192.168.16.92';

        $sql00      = "SELECT a.FuDesvCod AS motivo_despido_codigo, a.FuDesvDesc AS motivo_despido_nombre FROM FUMOTDESV a WHERE a.FuDesvDesc IS NOT NULL ORDER BY a.FuDesvDesc";
        $sql01      = "SELECT * FROM sistema.DOMFIC WHERE DOMFICEQU = ? AND DOMFICVAL = ?";
        $sql02      = "INSERT INTO sistema.DOMFIC (DOMFICEST, DOMFICNOM, DOMFICEQU, DOMFICVAL, DOMFICOBS, DOMFICAUS, DOMFICAFH, DOMFICAIP) VALUES (?, ?, ?, ?, ?, ?, NOW(), ?)";

        try {
            $connMSSQL  = getConnectionMSSQLv1();
            $connPGSQL  = getConnectionPGSQLv1();

            $stmtMSSQL  = $connMSSQL->prepare($sql00);
            $stmtMSSQL->execute();

            $stmtPGSQL1 = $connPGSQL->prepare($sql01);
            $stmtPGSQL2 = $connPGSQL->prepare($sql02);

            while ($rowMSSQL = $stmtMSSQL->fetch()) {
                $DOMFICEQU  = $rowMSSQL['motivo_despido_codigo'];
                $DOMFICNOM  = strtoupper(strtolower(trim($rowMSSQL['motivo_despido_nombre'])));

                $stmtPGSQL1->execute([$DOMFICEQU, $DOMFICVAL]);

                $rowPGSQL1  = $stmtPGSQL1->fetch(PDO::FETCH_ASSOC);
                    
                if (!$rowPGSQL1){
                    $stmtPGSQL2->execute([$DOMFICEST, $DOMFICNOM, $DOMFICEQU, $DOMFICVAL, $DOMFICOBS, $DOMFICAUS, $DOMFICAIP]);
                }
            }

            $stmtMSSQL->closeCursor();
            $stmtPGSQL1->closeCursor();
            $stmtPGSQL2->closeCursor();

            $stmtMSSQL  = null;
            $stmtPGSQL1 = null;
            $stmtPGSQL2 = null;
        } catch (PDOException $e) {
            echo "\n";
            echo 'Error getMotivoDespido(): '.$e;
        }

        $connMSSQL  = null;
        $connPGSQL  = null;
    }

    function getPais(){
        $LOCPAIEST  = 1;
        $LOCPAICO1  = 0;
        $LOCPAINOM  = '';
        $LOCPAIBCP  = '';
        $LOCPAIGEN  = '';
        $LOCPAIOBS  = '';
        $LOCPAIAUS  = 'MIGRACION';
        $LOCPAIAFH  = date('Y-m-d H:i:s');
        $LOCPAIAIP  = '192.168.16.92';

        $sql00      = "SELECT a.AhPais AS pais_codigo, a.AhNomb AS pais_nombre, a.AhAbr AS pais_bcp, a.AhGent AS pais_gentilicio FROM FST002 a ORDER BY a.AhNomb";
        $sql01      = "SELECT * FROM sistema.LOCPAI WHERE LOCPAICO1 = ? AND LOCPAINOM = ?";
        $sql02      = "INSERT INTO sistema.LOCPAI (LOCPAIEST, LOCPAICO1, LOCPAINOM, LOCPAIBCP, LOCPAIGEN, LOCPAIOBS, LOCPAIAUS, LOCPAIAFH, LOCPAIAIP) VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), ?)";

        try {
            $connMSSQL  = getConnectionMSSQLv1();
            $connPGSQL  = getConnectionPGSQLv1();

            $stmtMSSQL  = $connMSSQL->prepare($sql00);
            $stmtMSSQL->execute();

            $stmtPGSQL1 = $connPGSQL->prepare($sql01);
            $stmtPGSQL2 = $connPGSQL->prepare($sql02);

            while ($rowMSSQL = $stmtMSSQL->fetch()) {
                $LOCPAICO1  = $rowMSSQL['pais_codigo'];
                $LOCPAINOM  = strtoupper(strtolower(trim($rowMSSQL['pais_nombre'])));
                $LOCPAIBCP  = strtoupper(strtolower(trim($rowMSSQL['pais_bcp'])));
                $LOCPAIGEN  = strtoupper(strtolower(trim($rowMSSQL['pais_gentilicio'])));

                $stmtPGSQL1->execute([$LOCPAICO1, $LOCPAINOM]);

                $rowPGSQL1  = $stmtPGSQL1->fetch(PDO::FETCH_ASSOC);
                    
                if (!$rowPGSQL1){
                    $stmtPGSQL2->execute([$LOCPAIEST, $LOCPAICO1, $LOCPAINOM, $LOCPAIBCP, $LOCPAIGEN, $LOCPAIOBS, $LOCPAIAUS, $LOCPAIAIP]);
                }
            }

            $stmtMSSQL->closeCursor();
            $stmtPGSQL1->closeCursor();
            $stmtPGSQL2->closeCursor();

            $stmtMSSQL  = null;
            $stmtPGSQL1 = null;
            $stmtPGSQL2 = null;
        } catch (PDOException $e) {
            echo "\n";
            echo 'Error getPais(): '.$e;
        }

        $connMSSQL  = null;
        $connPGSQL  = null;
    }

    echo "\n";
    echo "++++++++++++++++++++++++++PROCESO DE MIGRACIÓN++++++++++++++++++++++++++";
    echo "\n";
    echo "++++++++++++++++ SISTEMA CORPORATIVO => SISTEMA TALENTO ++++++++++++++++";

    echo "\n";
    echo "INICIO getEstadoCivil() => ".date('Y-m-d H:i:s');
    getEstadoCivil();
    echo "\n";
    echo "FIN getEstadoCivil() => ".date('Y-m-d H:i:s');

    echo "\n";
    echo "INICIO getTelCelPrefijo() => ".date('Y-m-d H:i:s');
    getTelCelPrefijo();
    echo "\n";
    echo "FIN getTelCelPrefijo() => ".date('Y-m-d H:i:s');

    echo "\n";
    echo "INICIO getParentesco() => ".date('Y-m-d H:i:s');
    getParentesco();
    echo "\n";
    echo "FIN getParentesco() => ".date('Y-m-d H:i:s');

    echo "\n";
    echo "INICIO getUniversidad() => ".date('Y-m-d H:i:s');
    getUniversidad();
    echo "\n";
    echo "FIN getUniversidad() => ".date('Y-m-d H:i:s');

    echo "\n";
    echo "INICIO getCarrera() => ".date('Y-m-d H:i:s');
    getCarrera();
    echo "\n";
    echo "FIN getCarrera() => ".date('Y-m-d H:i:s');

    echo "\n";
    echo "INICIO getHobbies() => ".date('Y-m-d H:i:s');
    getHobbies();
    echo "\n";
    echo "FIN getHobbies() => ".date('Y-m-d H:i:s');

    echo "\n";
    echo "INICIO getCargo() => ".date('Y-m-d H:i:s');
    getCargo();
    echo "\n";
    echo "FIN getCargo() => ".date('Y-m-d H:i:s');

    echo "\n";
    echo "INICIO getMotivoDespido() => ".date('Y-m-d H:i:s');
    getMotivoDespido();
    echo "\n";
    echo "FIN getMotivoDespido() => ".date('Y-m-d H:i:s');

    echo "\n";
    echo "INICIO getPais() => ".date('Y-m-d H:i:s');
    getPais();
    echo "\n";
    echo "FIN getPais() => ".date('Y-m-d H:i:s');
?>
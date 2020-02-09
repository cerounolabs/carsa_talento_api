<?php
    require __DIR__.'/../src/connect.php';

    function getEstadoCivil(){
        $DOMFICEST  = 1;
        $DOMFICNOM  = '';
        $DOMFICEQU  = '';
        $DOMFICVAL  = 'ESTADOCIVIL';
        $DOMFICOBS  = '';
        $DOMFICAUS  = 'MIGRACION';
        $DOMFICAFH  = date('Y-m-d H:i:s');
        $DOMFICAIP  = '192.168.16.9';

        $sql00      = "SELECT a.ECCod AS estado_civil_codigo, a.ECDsc AS estado_civil_nombre FROM ESTCIV a ORDER BY a.ECDsc";
        $sql01      = "SELECT * FROM sistema.DOMFIC WHERE DOMFICEQU = ? AND DOMFICVAL = ?";
        $sql02      = "INSERT INTO sistema.DOMFIC (DOMFICEST, DOMFICNOM, DOMFICEQU, DOMFICVAL, DOMFICOBS, DOMFICAUS, DOMFICAFH, DOMFICAIP) VALUES (?, ?, ?, ?, ?, ?, NOW(), ?)";

        try {
            $connMSSQL  = getConnectionMSSQLv2();
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
            $connMSSQL  = getConnectionMSSQLv2();
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
    echo "INICIO getPais() => ".date('Y-m-d H:i:s');
    getPais();
    echo "\n";
    echo "FIN getPais() => ".date('Y-m-d H:i:s');
    echo "\n";
?>
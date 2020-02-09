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
        $sql01      = "SELECT * FROM DOMFIC WHERE DOMFICEQU = ? AND DOMFICVAL = ?";
        $sql02      = "INSERT INTO DOMFIC (DOMFICEST, DOMFICNOM, DOMFICEQU, DOMFICVAL, DOMFICOBS, DOMFICAUS, DOMFICAFH, DOMFICAIP) VALUES (?, ?, ?, ?, ?, ?, NOW(), ?)";

        try {
            $connMSSQL  = getConnectionMSSQLv2();
            $connPGSQL  = getConnectionPGSQLv1();

            $stmtMSSQL  = $connMSSQL->prepare($sql00);
            $stmtMSSQL->execute();

            $stmtPGSQL1 = $connPGSQL->prepare($sql01);
            $stmtPGSQL2 = $connPGSQL->prepare($sql02);

            while ($rowMSSQL = $stmtMSSQL->fetch()) {
                $DOMFICEQU = $rowMSSQL['estado_civil_codigo'];
                $DOMFICNOM = trim($rowMSSQL['estado_civil_nombre']);

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
            echo 'Error setDepartamento(): '.$e;
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
?>
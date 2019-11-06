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
    echo "++++++++++++++++++++++++++PROCESO DE MIGRACIÓN++++++++++++++++++++++++++";
    echo "\n";
?>
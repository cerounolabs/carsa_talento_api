<?php
    $app->post('/v1/login', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getParsedBody()['usuario_var01'];
        $val02      = $request->getParsedBody()['usuario_var02'];
        $val03      = $request->getParsedBody()['usuario_var03'];
        $val04      = $request->getParsedBody()['usuario_var04'];
        $val05      = $request->getParsedBody()['usuario_var05'];
        $val06      = $request->getParsedBody()['usuario_var06'];
        $val07      = $request->getParsedBody()['usuario_var07'];

        if (isset($val01) && isset($val02) && isset($val03)) {
            $sql00  = "SELECT
            a.ClUsu                 AS      login_usuario,
            a.ClCon                 AS      login_contrasenha,
            a.FuCod                 AS      login_funcionario_codigo,
            a.ClNom                 AS      login_funcionario_nombre,

            b.CARGO                 AS      login_cargo,
            b.GERENCIA              AS      login_gerencia,
            b.FOTO_TARGET           AS      login_foto,
            b.CORREO_ELECTRONICO    AS      login_email

            FROM FSD050 a
			INNER JOIN COLABORADOR_BASICOS b ON a.FuCod = b.COD_FUNC

            WHERE a.ClUsu = ?
            
            ORDER BY a.FuCod";

            $sql01  = "INSERT INTO FUNLOG (FUNLOGEST, FUNLOGUSU, FUNLOGPAS, FUNLOGDIR, FUNLOGHOS, FUNLOGAGE, FUNLOGREF, FUNLOGAFH) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $connMYSQL  = getConnectionMYSQL();

                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMYSQL  = $connMYSQL->prepare($sql01);

                $stmtMSSQL->execute([$val01]);
                
                $row_mssql  = $stmtMSSQL->fetch(PDO::FETCH_ASSOC);

                if (!$row_mssql){
                    $val00      = 'E';
                    $detalle    = array(
                        'login_usuario'             => '',
                        'login_foto'                => '',
                        'login_funcionario_codigo'  => '',
                        'login_funcionario_nombre'  => '',
                        'login_cargo'               => '',
                        'login_gerencia'            => '',
                        'login_email'               => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json       = json_encode(array('code' => 201, 'status' => 'Error', 'message' => 'Error LOGIN: Usuario No Existe', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                    
                } else {
                    if($row_mssql['login_contrasenha'] == $val02){
                        $val00      = 'O';
                        $detalle    = array(
                            'login_usuario'             => $row_mssql['login_usuario'],
                            'login_foto'                => $row_mssql['login_foto'],
                            'login_funcionario_codigo'  => $row_mssql['login_funcionario_codigo'],
                            'login_funcionario_nombre'  => $row_mssql['login_funcionario_nombre'],
                            'login_cargo'               => $row_mssql['login_cargo'],
                            'login_gerencia'            => $row_mssql['login_gerencia'],
                            'login_email'               => $row_mssql['login_email']
                        );

                        header("Content-Type: application/json; charset=utf-8");
                        $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success LOGIN', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                    } else {
                        $val00      = 'I';
                        $detalle    = array(
                            'login_usuario'             => $row_mssql['login_usuario'],
                            'login_foto'                => $row_mssql['login_foto'],
                            'login_funcionario_codigo'  => $row_mssql['login_funcionario_codigo'],
                            'login_funcionario_nombre'  => $row_mssql['login_funcionario_nombre'],
                            'login_cargo'               => $row_mssql['login_cargo'],
                            'login_gerencia'            => $row_mssql['login_gerencia'],
                            'login_email'               => $row_mssql['login_email']
                        );

                        header("Content-Type: application/json; charset=utf-8");
                        $json       = json_encode(array('code' => 201, 'status' => 'Error', 'message' => 'Error LOGIN: Usuario y/o Contraseña Incorrecto', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                    }
                }

                $stmtMYSQL->execute([$val00, $val01, $val02, $val03, $val04, $val05, $val06, $val07]); 
                
                $stmtMSSQL->closeCursor();
                $stmtMYSQL->closeCursor();

                $stmtMSSQL = null;
                $stmtMYSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error LOGIN: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        $connMYSQL  = null;
        
        return $json;
    });

    $app->post('/v1/000/dominio', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02      = $request->getParsedBody()['tipo_nombre'];
        $val03      = $request->getParsedBody()['tipo_equivalente'];
        $val04      = $request->getParsedBody()['tipo_dominio'];
        $val05      = $request->getParsedBody()['tipo_observacion'];
        $val06      = $request->getParsedBody()['tipo_usuario'];
        $val07      = $request->getParsedBody()['tipo_fecha_hora'];
        $val08      = $request->getParsedBody()['tipo_ip'];

        if (isset($val01) && isset($val02) && isset($val04) && isset($val06) && isset($val07) && isset($val08)) {
            $sql00  = "INSERT INTO DOMFIC (DOMFICEST, DOMFICNOM, DOMFICEQU, DOMFICVAL, DOMFICOBS, DOMFICAUS, DOMFICAFH, DOMFICAIP) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

            try {
                $connMYSQL  = getConnectionMYSQL();
                $stmtMYSQL  = $connMYSQL->prepare($sql00);
                $stmtMYSQL->execute([$val01, $val02, $val03, $val04, $val05, $val06, $val07, $val08]); 
                
                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success INSERT', 'codigo' => $connMYSQL->lastInsertId()), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMYSQL->closeCursor();
                $stmtMYSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error INSERT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMYSQL  = null;
        
        return $json;
    });

    $app->post('/v1/100/campanha', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getParsedBody()['campanha_estado_codigo'];
        $val02      = $request->getParsedBody()['campanha_nombre'];
        $val03      = $request->getParsedBody()['campanha_fecha_inicio'];
        $val04      = $request->getParsedBody()['campanha_fecha_final'];
        $val05      = $request->getParsedBody()['campanha_observacion'];
        $val06      = $request->getParsedBody()['campanha_usuario'];
        $val07      = $request->getParsedBody()['campanha_fecha_hora'];
        $val08      = $request->getParsedBody()['campanha_ip'];
        $val09      = $request->getParsedBody()['campanha_formulario_1'];
        $val10      = $request->getParsedBody()['campanha_formulario_2'];
        $val11      = $request->getParsedBody()['campanha_formulario_3'];
        $val12      = $request->getParsedBody()['campanha_formulario_4'];
        $val13      = $request->getParsedBody()['campanha_formulario_5'];
        $val14      = $request->getParsedBody()['campanha_formulario_6'];
        $val15      = $request->getParsedBody()['campanha_formulario_7'];
        $val16      = $request->getParsedBody()['campanha_formulario_8'];
        
        if (isset($val01) && isset($val02) && isset($val03) && isset($val04) && isset($val06) && isset($val07) && isset($val08)) {
            $sql00  = "INSERT INTO CAMFIC (CAMFICEST, CAMFICNOM, CAMFICFDE, CAMFICFHA, CAMFICFO1, CAMFICFO2, CAMFICFO3, CAMFICFO4, CAMFICFO5, CAMFICFO6, CAMFICFO7, CAMFICFO8, CAMFICOBS, CAMFICAUS, CAMFICAFH, CAMFICAIP) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            try {
                $connMYSQL  = getConnectionMYSQL();
                $stmtMYSQL  = $connMYSQL->prepare($sql00);
                $stmtMYSQL->execute([$val01, $val02, $val03, $val04, $val09, $val10, $val11, $val12, $val13, $val14, $val15, $val16, $val05, $val06, $val07, $val08]); 
                
                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success INSERT', 'codigo' => $connMYSQL->lastInsertId()), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMYSQL->closeCursor();
                $stmtMYSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error INSERT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMYSQL  = null;
        
        return $json;
    });

    $app->post('/v1/100/procesar/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');
        $val01      = $request->getParsedBody()['campanha_usuario'];
        $val02      = $request->getParsedBody()['campanha_fecha_hora'];
        $val03      = $request->getParsedBody()['campanha_ip'];
        
        if (isset($val00)) {
            $sql00  = "SELECT
            a.FuSexo                        AS      funcionario_sexo_codigo,
            a.ECCod                         AS      funcionario_estado_civil_codigo,
            a.FuCIC                         AS      funcionario_documento,
            a.FuNom                         AS      funcionario_nombre_1,
            a.FNomb2                        AS      funcionario_nombre_2,
            a.FuApe                         AS      funcionario_apellido_1,
            a.Apell2                        AS      funcionario_apellido_2,
            a.FuCod                         AS      funcionario_codigo,
            CONVERT(date, a.FuFchNac, 23)   AS      funcionario_fecha_nacimiento,
            a.FuMail                        AS      funcionario_email,
            b.FOTO_TARGET                   AS      funcionario_foto
            
            FROM FUNCIONARI a
            INNER JOIN COLABORADOR_BASICOS b ON a.FuCod = b.COD_FUNC
            
            WHERE a.FEst = 'A'";

            $sql01  = "SELECT
            a.FUNFICCOD                     AS      funcionario_codigo

            FROM FUNFIC a

            WHERE a.FUNFICCFU = ?";

            $sql02  = "INSERT INTO FUNFIC (FUNFICEST, FUNFICTDC, FUNFICTSC, FUNFICECC, FUNFICCFU, FUNFICNOM, FUNFICAPE, FUNFICDOC, FUNFICFHA, FUNFICEMA, FUNFICFOT, FUNFICAUS, FUNFICAFH, FUNFICAIP) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $sql03  = "SELECT
            a.CAMFUCCAC         AS      campanha_codigo,
            a.CAMFUCFUC         AS      funcionari_codigo
        
            FROM CAMFUC a
            
            WHERE a.CAMFUCCAC = ? AND a.CAMFUCFUC = ?";

            $sql04  = "INSERT INTO CAMFUC (CAMFUCCAC, CAMFUCFUC, CAMFUCEST, CAMFUCAUS, CAMFUCAFH, CAMFUCAIP) VALUES (?, ?, ?, ?, ?, ?)";
            $sql05  = "UPDATE CAMFIC SET CAMFICEST = 3, CAMFICAUS = ?, CAMFICAFH = ?, CAMFICAIP = ? WHERE CAMFICCOD = ? AND CAMFICEST = 2";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $connMYSQL  = getConnectionMYSQL();

                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMYSQL  = $connMYSQL->prepare($sql01);
                $stmtMYSQL2 = $connMYSQL->prepare($sql02);
                $stmtMYSQL3 = $connMYSQL->prepare($sql03);
                $stmtMYSQL4 = $connMYSQL->prepare($sql04);
                $stmtMYSQL5 = $connMYSQL->prepare($sql05);

                $stmtMSSQL->execute();
                
                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $FUNFICEST   = 'A';
                    $row00_mssql = $rowMSSQL['funcionario_sexo_codigo'];
                    $row01_mssql = $rowMSSQL['funcionario_estado_civil_codigo'];
                    $row02_mssql = trim($rowMSSQL['funcionario_documento']);
                    $row03_mssql = trim($rowMSSQL['funcionario_nombre_1']).' '.trim($rowMSSQL['funcionario_nombre_2']);
                    $row04_mssql = trim($rowMSSQL['funcionario_apellido_1']).' '.trim($rowMSSQL['funcionario_apellido_2']);
                    $row05_mssql = $rowMSSQL['funcionario_codigo'];
                    $row06_mssql = $rowMSSQL['funcionario_fecha_nacimiento'];
                    $row07_mssql = trim($rowMSSQL['funcionario_email']);
                    $row08_mssql = trim($rowMSSQL['funcionario_foto']);

                    $stmtMYSQL->execute([$row05_mssql]);
                    $row00_mysql = $stmtMYSQL->fetch(PDO::FETCH_ASSOC);
                    
                    if (!$row00_mysql){
                        $FUNFICTDC = 15;

                        if ($row00_mssql == 'F'){
                            $FUNFICTSC = 13;
                        } else {
                            $FUNFICTSC = 1;
                        }

                        switch ($row01_mssql) {
                            case 1:
                                $FUNFICECC = 7;
                                break;

                            case 2:
                                $FUNFICECC = 8;
                                break;

                            case 3:
                                $FUNFICECC = 9;
                                break;

                            case 4:
                                $FUNFICECC = 10;
                                break;

                            case 5:
                                $FUNFICECC = 11;
                                break;

                            case 6:
                                $FUNFICECC = 12;
                                break;
                            
                            default:
                                $FUNFICECC = 14;
                                break;
                        }

                        $stmtMYSQL2->execute([$FUNFICEST, $FUNFICTDC, $FUNFICTSC, $FUNFICECC, $row05_mssql, $row03_mssql, $row04_mssql, $row02_mssql, $row06_mssql, $row07_mssql, $row08_mssql, $val01, $val02, $val03]);
                        $FUNFICCOD = $connMYSQL->lastInsertId();
                    } else {
                        $FUNFICCOD = $row00_mysql['funcionario_codigo'];
                    }

                    $stmtMYSQL3->execute([$val00, $FUNFICCOD]);
                    $row01_mysql = $stmtMYSQL3->fetch(PDO::FETCH_ASSOC);

                    if(!$row01_mysql){
                        $CAMFUCEST = 'P';
                        $stmtMYSQL4->execute([$val00, $FUNFICCOD, $CAMFUCEST, $val01, $val02, $val03]);
                    }
                }

                $stmtMYSQL5->execute([$val01, $val02, $val03, $val00]);

                $stmtMSSQL->closeCursor();
                $stmtMYSQL->closeCursor();
                $stmtMYSQL2->closeCursor();
                $stmtMYSQL3->closeCursor();
                $stmtMYSQL4->closeCursor();
                $stmtMYSQL5->closeCursor();
                
                $stmtMSSQL  = null;
                $stmtMYSQL  = null;
                $stmtMYSQL2 = null;
                $stmtMYSQL3 = null;
                $stmtMYSQL4 = null;
                $stmtMYSQL5 = null;

                header("Content-Type: application/json; charset=utf-8");
                $json   = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success PROCESO', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json   = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        $connMYSQL  = null;
        
        return $json;
    });

    $app->post('/v1/200', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01  = $request->getParsedBody()['funcionario_usuario'];
        $val02  = $request->getParsedBody()['funcionario_fecha_hora'];
        $val03  = $request->getParsedBody()['funcionario_ip'];
        
        $sql00  = "SELECT
        a.FuSexo                        AS      funcionario_sexo_codigo,
        a.ECCod                         AS      funcionario_estado_civil_codigo,
        a.FuCIC                         AS      funcionario_documento,
        a.FuNom                         AS      funcionario_nombre_1,
        a.FNomb2                        AS      funcionario_nombre_2,
        a.FuApe                         AS      funcionario_apellido_1,
        a.Apell2                        AS      funcionario_apellido_2,
        a.FuCod                         AS      funcionario_codigo,
        CONVERT(date, a.FuFchNac, 23)   AS      funcionario_fecha_nacimiento,
        a.FuMail                        AS      funcionario_email
        
        FROM FUNCIONARI a
        
        WHERE a.FEst = 'A'";

        $sql01  = "SELECT
        a.FUNFICCOD                     AS      funcionario_codigo

        FROM FUNFIC a

        WHERE a.FUNFICCFU = ?";

        $sql02  = "INSERT INTO FUNFIC (FUNFICEST, FUNFICTDC, FUNFICTSC, FUNFICECC, FUNFICCFU, FUNFICNOM, FUNFICAPE, FUNFICDOC, FUNFICFHA, FUNFICEMA, FUNFICAUS, FUNFICAFH, FUNFICAIP) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        try {
            $connMSSQL  = getConnectionMSSQL();
            $connMYSQL  = getConnectionMYSQL();

            $stmtMSSQL  = $connMSSQL->prepare($sql00);
            $stmtMYSQL  = $connMYSQL->prepare($sql01);
            $stmtMYSQL2 = $connMYSQL->prepare($sql02);

            $stmtMSSQL->execute();
            
            while ($rowMSSQL = $stmtMSSQL->fetch()) {
                $FUNFICEST   = 'A';
                $row00_mssql = $rowMSSQL['funcionario_sexo_codigo'];
                $row01_mssql = $rowMSSQL['funcionario_estado_civil_codigo'];
                $row02_mssql = trim($rowMSSQL['funcionario_documento']);
                $row03_mssql = trim($rowMSSQL['funcionario_nombre_1']).' '.trim($rowMSSQL['funcionario_nombre_2']);
                $row04_mssql = trim($rowMSSQL['funcionario_apellido_1']).' '.trim($rowMSSQL['funcionario_apellido_2']);
                $row05_mssql = $rowMSSQL['funcionario_codigo'];
                $row06_mssql = $rowMSSQL['funcionario_fecha_nacimiento'];
                $row07_mssql = trim($rowMSSQL['funcionario_email']);

                $stmtMYSQL->execute([$row05_mssql]);
                $row00_mysql = $stmtMYSQL->fetch(PDO::FETCH_ASSOC);
                
                if (!$row00_mysql){
                    $FUNFICTDC = 15;

                    if ($row00_mssql == 'F'){
                        $FUNFICTSC = 13;
                    } else {
                        $FUNFICTSC = 1;
                    }

                    switch ($row01_mssql) {
                        case 1:
                            $FUNFICECC = 7;
                            break;

                        case 2:
                            $FUNFICECC = 8;
                            break;

                        case 3:
                            $FUNFICECC = 9;
                            break;

                        case 4:
                            $FUNFICECC = 10;
                            break;

                        case 5:
                            $FUNFICECC = 11;
                            break;

                        case 6:
                            $FUNFICECC = 12;
                            break;
                        
                        default:
                            $FUNFICECC = 14;
                            break;
                    }

                    $stmtMYSQL2->execute([$FUNFICEST, $FUNFICTDC, $FUNFICTSC, $FUNFICECC, $row05_mssql, $row03_mssql, $row04_mssql, $row02_mssql, $row06_mssql, $row07_mssql, $val01, $val02, $val03]);
                    $FUNFICCOD = $connMYSQL->lastInsertId();
                }
            }

            $stmtMSSQL->closeCursor();
            $stmtMYSQL->closeCursor();
            $stmtMYSQL2->closeCursor();
            
            $stmtMSSQL  = null;
            $stmtMYSQL  = null;
            $stmtMYSQL2 = null;

            header("Content-Type: application/json; charset=utf-8");
            $json   = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success PROCESO', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        } catch (PDOException $e) {
            header("Content-Type: application/json; charset=utf-8");
            $json   = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        $connMYSQL  = null;
        
        return $json;
    });
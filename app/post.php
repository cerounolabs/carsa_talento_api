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
        $val17      = $request->getParsedBody()['campanha_color'];
        
        if (isset($val01) && isset($val02) && isset($val03) && isset($val04) && isset($val06) && isset($val07) && isset($val08)) {
            $sql00  = "INSERT INTO CAMFIC (CAMFICEST, CAMFICNOM, CAMFICFDE, CAMFICFHA, CAMFICCOL, CAMFICFO1, CAMFICFO2, CAMFICFO3, CAMFICFO4, CAMFICFO5, CAMFICFO6, CAMFICFO7, CAMFICFO8, CAMFICOBS, CAMFICAUS, CAMFICAFH, CAMFICAIP) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            try {
                $connMYSQL  = getConnectionMYSQL();
                $stmtMYSQL  = $connMYSQL->prepare($sql00);
                $stmtMYSQL->execute([$val01, $val02, $val03, $val04, $val17, $val09, $val10, $val11, $val12, $val13, $val14, $val15, $val16, $val05, $val06, $val07, $val08]); 
                
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

    $app->post('/v1/1200/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');
        $val01      = $request->getParsedBody()['datos_personales_nombre_1'];
        $val02      = $request->getParsedBody()['datos_personales_nombre_2'];
        $val03      = $request->getParsedBody()['datos_personales_apellido_1'];
        $val04      = $request->getParsedBody()['datos_personales_apellido_2'];
        $val05      = $request->getParsedBody()['datos_personales_documento'];
        $val06      = $request->getParsedBody()['datos_personales_estado_civil'];
        $val07      = $request->getParsedBody()['datos_personales_sexo'];
        $val08      = $request->getParsedBody()['datos_personales_fecha_nacimiento'];
        $val09      = $request->getParsedBody()['datos_personales_cantidad_hijo'];
        $val10      = $request->getParsedBody()['auditoria_usuario'];
        $val11      = $request->getParsedBody()['auditoria_fecha_hora'];
        $val12      = $request->getParsedBody()['auditoria_ip'];

        switch ($val06) {
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

        $FUNFICEST  = 'P';
        $FUNFICTDC  = 15;
        $FUNFICTSC  = $val07;
        $FUNFICCFU  = $val00;
        $FUNFICNOM  = trim(strtoupper($val01)).' '.trim(strtoupper($val02));
        $FUNFICAPE  = trim(strtoupper($val03)).' '.trim(strtoupper($val04));
        $FUNFICDOC  = trim(strtoupper($val05));
        $FUNFICFHA  = $val08;
        $FUNFICEMA  = '';
        $FUNFICFOT  = 'assets/images/users/default.png';
        $FUNFICOBS  = '';
        $FUNFICAUS  = trim(strtoupper($val10));
        $FUNFICAFH  = $val11;
        $FUNFICAIP  = $val12;

        if (isset($val01) && isset($val03) && isset($val05) && isset($val08)) {
            $sql00  = "INSERT INTO FUNFIC (FUNFICEST, FUNFICTDC, FUNFICTSC, FUNFICECC, FUNFICCFU, FUNFICNOM, FUNFICAPE, FUNFICDOC, FUNFICFHA, FUNFICEMA, FUNFICFOT, FUNFICOBS, FUNFICAUS, FUNFICAFH, FUNFICAIP) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            try {
                $connMYSQL  = getConnectionMYSQL();
                $stmtMYSQL  = $connMYSQL->prepare($sql00);
                $stmtMYSQL->execute([$FUNFICEST, $FUNFICTDC, $FUNFICTSC, $FUNFICECC, $FUNFICCFU, $FUNFICNOM, $FUNFICAPE, $FUNFICDOC, $FUNFICFHA, $FUNFICEMA, $FUNFICFOT, $FUNFICOBS, $FUNFICAUS, $FUNFICAFH, $FUNFICAIP]); 
                
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

    $app->post('/v1/1300/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');
        $val01      = $request->getParsedBody()['datos_conyuge_nombre_1'];
        $val02      = $request->getParsedBody()['datos_conyuge_nombre_2'];
        $val03      = $request->getParsedBody()['datos_conyuge_apellido_1'];
        $val04      = $request->getParsedBody()['datos_conyuge_apellido_2'];
        $val05      = $request->getParsedBody()['datos_conyuge_sexo'];
        $val06      = $request->getParsedBody()['datos_conyuge_fecha_nacimiento'];
        $val07      = $request->getParsedBody()['datos_conyuge_empresa'];
        $val08      = $request->getParsedBody()['auditoria_usuario'];
        $val09      = $request->getParsedBody()['auditoria_fecha_hora'];
        $val10      = $request->getParsedBody()['auditoria_ip'];

        $FUNCONEST  = 'A';
        $FUNCONTSC  = $val05;
        $FUNCONFUC  = $val00;
        $FUNCONNOM  = trim(strtoupper($val01)).' '.trim(strtoupper($val02));
        $FUNCONAPE  = trim(strtoupper($val03)).' '.trim(strtoupper($val04));
        $FUNCONFHA  = $val06;
        $FUNCONEMP  = trim(strtoupper($val07));
        $FUNCONOBS  = '';
        $FUNCONAUS  = trim(strtoupper($val08));
        $FUNCONAFH  = $val09;
        $FUNCONAIP  = $val10;

        if (isset($val01) && isset($val03) && isset($val05)) {
            $sql00  = "INSERT INTO FUNCON (FUNCONEST, FUNCONTSC, FUNCONFUC, FUNCONNOM, FUNCONAPE, FUNCONFHA, FUNCONEMP, FUNCONOBS, FUNCONAUS, FUNCONAFH, FUNCONAIP) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            try {
                $connMYSQL  = getConnectionMYSQL();
                $stmtMYSQL  = $connMYSQL->prepare($sql00);
                $stmtMYSQL->execute([$FUNCONEST, $FUNCONTSC, $FUNCONFUC, $FUNCONNOM, $FUNCONAPE, $FUNCONFHA, $FUNCONEMP, $FUNCONOBS, $FUNCONAUS, $FUNCONAFH, $FUNCONAIP]); 
                
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

    $app->post('/v1/1400/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');
        $val01      = $request->getParsedBody()['datos_laborales_empresa_nombre'];
        $val02      = $request->getParsedBody()['datos_laborales_empresa_fecha_desde'];
        $val03      = $request->getParsedBody()['datos_laborales_empresa_fecha_hasta'];
        $val04      = $request->getParsedBody()['datos_laborales_empresa_cargo'];
        $val05      = $request->getParsedBody()['datos_laborales_empresa_motivo_salida'];
        $val06      = $request->getParsedBody()['auditoria_usuario'];
        $val07      = $request->getParsedBody()['auditoria_fecha_hora'];
        $val08      = $request->getParsedBody()['auditoria_ip'];

        $FUNTRAEST  = 'A';
        $FUNTRATCC  = $val04;
        $FUNTRAMSC  = $val05;
        $FUNTRAFUC  = $val00;
        $FUNTRAEMP  = trim(strtoupper($val01));
        $FUNTRAFDE  = $val02;
        $FUNTRAFHA  = $val03;
        $FUNTRAOBS  = '';
        $FUNTRAAUS  = trim(strtoupper($val06));
        $FUNTRAAFH  = $val07;
        $FUNTRAAIP  = $val08;
        
        if (isset($val00) && isset($val01)) {
            $sql00  = "INSERT INTO FUNTRA (FUNTRAEST, FUNTRATCC, FUNTRAMSC, FUNTRAFUC, FUNTRAEMP, FUNTRAFDE, FUNTRAFHA, FUNTRAOBS, FUNTRAAUS, FUNTRAAFH, FUNTRAAIP) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            try {
                $connMYSQL  = getConnectionMYSQL();
                $stmtMYSQL  = $connMYSQL->prepare($sql00);
                $stmtMYSQL->execute([$FUNTRAEST, $FUNTRATCC, $FUNTRAMSC, $FUNTRAFUC, $FUNTRAEMP, $FUNTRAFDE, $FUNTRAFHA, $FUNTRAOBS, $FUNTRAAUS, $FUNTRAAFH, $FUNTRAAIP]); 
                
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

    $app->post('/v1/1500/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');
        $val01      = $request->getParsedBody()['datos_laborales_otra_actividad'];
        $val02      = $request->getParsedBody()['datos_laborales_especificar'];
        $val03      = $request->getParsedBody()['auditoria_usuario'];
        $val04      = $request->getParsedBody()['auditoria_fecha_hora'];
        $val05      = $request->getParsedBody()['auditoria_ip'];

        $FUNOAEEST  = 'A';
        $FUNOAEAEC  = $val01;
        $FUNOAEFUC  = $val00;
        $FUNOAENOM  = trim(strtoupper($val03));
        $FUNOAEOBS  = '';
        $FUNOAEAUS  = trim(strtoupper($val06));
        $FUNOAEAFH  = $val04;
        $FUNOAEAIP  = $val05;
        
        if (isset($val00) && isset($val01)) {
            $sql00  = "INSERT INTO FUNOAE (FUNOAEEST, FUNOAEAEC, FUNOAEFUC, FUNOAENOM, FUNOAEOBS, FUNOAEAUS, FUNOAEAFH, FUNOAEAIP) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            
            try {
                $connMYSQL  = getConnectionMYSQL();
                $stmtMYSQL  = $connMYSQL->prepare($sql00);
                $stmtMYSQL->execute([$FUNOAEEST, $FUNOAEAEC, $FUNOAEFUC, $FUNOAENOM, $FUNOAEOBS, $FUNOAEAUS, $FUNOAEAFH, $FUNOAEAIP]); 
                
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

    $app->post('/v1/1600/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');
        $val01      = $request->getParsedBody()['datos_particulares_vivienda'];
        $val02      = $request->getParsedBody()['datos_particulares_departamento'];
        $val03      = $request->getParsedBody()['datos_particulares_ciudad'];
        $val04      = $request->getParsedBody()['datos_particulares_barrio'];
        $val05      = $request->getParsedBody()['datos_particulares_nro_casa'];
        $val06      = $request->getParsedBody()['datos_particulares_calle_1'];
        $val07      = $request->getParsedBody()['datos_particulares_calle_2'];
        $val08      = $request->getParsedBody()['datos_particulares_calle_3'];
        $val09      = $request->getParsedBody()['datos_particulares_ubicacion'];
        $val10      = $request->getParsedBody()['datos_particulares_celular_1'];
        $val11      = $request->getParsedBody()['datos_particulares_celular_2'];
        $val12      = $request->getParsedBody()['datos_particulares_telefono'];
        $val13      = $request->getParsedBody()['datos_particulares_email'];
        $val14      = $request->getParsedBody()['datos_particulares_observacion'];

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        $FUNPAREST  = 'A';
        $FUNPARTVC  = $val01;
        $FUNPARFUC  = $val00;
        $FUNPARDEC  = $val02;
        $FUNPARCIC  = $val03;
        $FUNPARBAR  = trim(strtoupper($val04));
        $FUNPARCAS  = trim(strtoupper($val05));
        $FUNPARCA1  = trim(strtoupper($val06));
        $FUNPARCA2  = trim(strtoupper($val07));
        $FUNPARCA3  = trim(strtoupper($val08));
        $FUNPARUBI  = trim(strtoupper($val09));
        $FUNPARTE1  = trim(strtoupper($val12));
        $FUNPARCE1  = trim(strtoupper($val10));
        $FUNPARCE2  = trim(strtoupper($val11));
        $FUNPAREMA  = trim(strtolower($val13));
        $FUNPAROBS  = trim(strtoupper($val14));
        $FUNPARAUS  = trim(strtoupper($aud01));
        $FUNPARAFH  = $aud02;
        $FUNPARAIP  = trim(strtoupper($aud03));
        
        if (isset($val00) && isset($val01)) {
            $sql00  = "INSERT INTO FUNPAR (FUNPAREST, FUNPARTVC, FUNPARFUC, FUNPARDEC, FUNPARCIC, FUNPARBAR, FUNPARCAS, FUNPARCA1, FUNPARCA2, FUNPARCA3, FUNPARUBI, FUNPARTE1, FUNPARCE1, FUNPARCE2, FUNPAREMA, FUNPAROBS, FUNPARAUS, FUNPARAFH, FUNPARAIP) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            try {
                $connMYSQL  = getConnectionMYSQL();
                $stmtMYSQL  = $connMYSQL->prepare($sql00);
                $stmtMYSQL->execute([$FUNPAREST, $FUNPARTVC, $FUNPARFUC, $FUNPARDEC, $FUNPARCIC, $FUNPARBAR, $FUNPARCAS, $FUNPARCA1, $FUNPARCA2, $FUNPARCA3, $FUNPARUBI, $FUNPARTE1, $FUNPARCE1, $FUNPARCE2, $FUNPAREMA, $FUNPAROBS, $FUNPARAUS, $FUNPARAFH, $FUNPARAIP]); 
                
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

    $app->post('/v1/1700/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');
        $val01      = $request->getParsedBody()['referencias_particulares_persona_nombre'];
        $val02      = $request->getParsedBody()['referencias_particulares_persona_telefono1_codigo'];
        $val03      = $request->getParsedBody()['referencias_particulares_persona_telefono1_numero'];
        $val04      = $request->getParsedBody()['referencias_particulares_persona_telefono2_codigo'];
        $val05      = $request->getParsedBody()['referencias_particulares_persona_telefono2_numero'];
        $val06      = $request->getParsedBody()['referencias_particulares_persona_observacion'];

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        $FUNRPPEST  = 'A';
        $FUNRPPTCC  = $val02;
        $FUNRPPTTC  = $val04;
        $FUNRPPFUC  = $val00;
        $FUNRPPNOM  = trim(strtoupper($val01));
        $FUNRPPTCN  = $val03;
        $FUNRPPTTN  = $val05;
        $FUNRPPOBS  = $val06;
        $FUNRPPAUS  = trim(strtoupper($aud01));
        $FUNRPPAFH  = $aud02;
        $FUNRPPAIP  = $aud03;
        
        if (isset($val00) && isset($val01)) {
            $sql00  = "INSERT INTO FUNTRA (FUNRPPEST, FUNRPPTCC, FUNRPPTTC, FUNRPPFUC, FUNRPPNOM, FUNRPPTCN, FUNRPPTTN, FUNRPPOBS, FUNRPPAUS, FUNRPPAFH, FUNRPPAIP) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            try {
                $connMYSQL  = getConnectionMYSQL();
                $stmtMYSQL  = $connMYSQL->prepare($sql00);
                $stmtMYSQL->execute([$FUNRPPEST, $FUNRPPTCC, $FUNRPPTTC, $FUNRPPFUC, $FUNRPPNOM, $FUNRPPTCN, $FUNRPPTTN, $FUNRPPOBS, $FUNRPPAUS, $FUNRPPAFH, $FUNRPPAIP]); 
                
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
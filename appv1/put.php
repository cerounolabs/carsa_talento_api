<?php
    $app->put('/v1/000/dominio/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');
        $val01      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02      = $request->getParsedBody()['tipo_orden'];
        $val03      = strtoupper(strtolower(trim($request->getParsedBody()['tipo_nombre'])));
        $val04      = strtoupper(strtolower(trim($request->getParsedBody()['tipo_equivalente'])));
        $val05      = strtoupper(strtolower(trim($request->getParsedBody()['tipo_dominio'])));
        $val06      = strtoupper(strtolower(trim($request->getParsedBody()['tipo_observacion'])));

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val00) && isset($val01) && isset($val03) && isset($val05)) {
            $sql00  = "UPDATE sistema.DOMFIC SET DOMFICEST = ?, DOMFICORD = ?, DOMFICNOM = ?, DOMFICEQU = ?, DOMFICOBS = ?, DOMFICAUS = ?, DOMFICAFH = NOW(), DOMFICAIP = ? WHERE DOMFICCOD = ?";

            try {
                $connPGSQL  = getConnectionPGSQLv1();
                $stmtPGSQL  = $connPGSQL->prepare($sql00);
                $stmtPGSQL->execute([$val01, $val02, $val03, $val04, $val06, $aud01, $aud03, $val00]); 
                
                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success UPDATE', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtPGSQL->closeCursor();
                $stmtPGSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error UPDATE: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connPGSQL  = null;
        
        return $json;
    });
    
    $app->put('/v1/100/campanha/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');
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
        $val17      = $request->getParsedBody()['campanha_formulario_9'];
        $val18      = $request->getParsedBody()['campanha_color'];
        
        if (isset($val00) && isset($val01) && isset($val02) && isset($val03) && isset($val04) && isset($val06) && isset($val07) && isset($val08)) {
            $sql00  = "UPDATE CAMFIC SET CAMFICEST = ?, CAMFICNOM = ?, CAMFICFDE = ?, CAMFICFHA = ?, CAMFICCOL = ?, CAMFICFO1 = ?, CAMFICFO2 = ?, CAMFICFO3 = ?, CAMFICFO4 = ?, CAMFICFO5 = ?, CAMFICFO6 = ?, CAMFICFO7 = ?, CAMFICFO8 = ?, CAMFICFO9 = ?, CAMFICOBS = ?, CAMFICAUS = ?, CAMFICAFH = ?, CAMFICAIP = ? WHERE CAMFICCOD = ? AND CAMFICEST IN (2, 3)";
            
            try {
                $connMYSQL  = getConnectionMYSQL();
                $stmtMYSQL  = $connMYSQL->prepare($sql00);
                $stmtMYSQL->execute([$val01, $val02, $val03, $val04, $val18, $val09, $val10, $val11, $val12, $val13, $val14, $val15, $val16, $val17, $val05, $val06, $val07, $val08, $val00]); 
                
                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success UPDATE', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMYSQL->closeCursor();
                $stmtMYSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error UPDATE: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMYSQL  = null;
        
        return $json;
    });

    $app->put('/v1/300/detalle/estado/{campanha}/{colaborador}/{estado}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('campanha');
        $val01      = $request->getAttribute('colaborador');
        $val02      = $request->getAttribute('estado');
        
        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val00) && isset($val01) && isset($val02) && isset($aud01) && isset($aud02) && isset($aud03)) {
            $sql00  = "UPDATE CAMFUC SET CAMFUCEST = ?, CAMFUCAUS = ?, CAMFUCAFH = ?, CAMFUCAIP = ? WHERE CAMFUCCAC = ? AND CAMFUCFUC = ?";
            
            try {
                $connMYSQL  = getConnectionMYSQL();
                $stmtMYSQL  = $connMYSQL->prepare($sql00);
                $stmtMYSQL->execute([$val02, $aud01, $aud02, $aud03, $val00, $val01]); 
                
                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success, se actualizo la carga de registro del COLABORADOR', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMYSQL->closeCursor();
                $stmtMYSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error UPDATE: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMYSQL  = null;
        
        return $json;
    });

    $app->put('/v1/400/sistema/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');
        $val01      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02      = $request->getParsedBody()['tipo_conexion_codigo'];
        $val03      = strtoupper(strtolower(trim($request->getParsedBody()['sistema_nombre'])));
        $val04      = strtolower(trim($request->getParsedBody()['sistema_link']));
        $val05      = strtoupper(strtolower(trim($request->getParsedBody()['sistema_observacion'])));

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val01) && isset($val02) && isset($val03)) {
            $sql00  = "UPDATE sistema.LOGFIC SET LOGFICEST = ?, LOGFICTCC = ?, LOGFICNOM = ?, LOGFICURL = ?, LOGFICOBS = ?, LOGFICAUS = ?, LOGFICAFH = NOW(), LOGFICAIP = ? WHERE LOGFICCOD = ?";

            try {
                $connPGSQL  = getConnectionPGSQLv1();
                $stmtPGSQL  = $connPGSQL->prepare($sql00);
                $stmtPGSQL->execute([$val01, $val02, $val03, $val04, $val05, $aud01, $aud03, $val00]); 
                
                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success UPDATE', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtPGSQL->closeCursor();
                $stmtPGSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error UPDATE: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connPGSQL  = null;
        
        return $json;
    });

    $app->put('/v1/400/colaborador/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');
        $val01      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02      = $request->getParsedBody()['funcionario_codigo'];
        $val03      = strtoupper(strtolower(trim($request->getParsedBody()['sistema_colaborador_direccion_ip'])));
        $val04      = strtoupper(strtolower(trim($request->getParsedBody()['sistema_colaborador_observacion'])));

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val00) && isset($val01) && isset($val02) && isset($val03)) {
            $sql00  = "UPDATE sistema.LOGFUN SET LOGFUNEST = ?, LOGFUNDIP = ?, LOGFUNOBS = ?, LOGFUNAUS = ?, LOGFUNAFH = NOW(), LOGFUNAIP = ? WHERE LOGFUNCOD = ? AND LOGFUNFUC = ?";

            try {
                $connPGSQL  = getConnectionPGSQLv1();
                $stmtPGSQL  = $connPGSQL->prepare($sql00);
                $stmtPGSQL->execute([$val01, $val03, $val04, $aud01, $aud03, $val00, $val02]);
                
                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success UPDATE', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtPGSQL->closeCursor();
                $stmtPGSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error UPDATE: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connPGSQL  = null;
        
        return $json;
    });
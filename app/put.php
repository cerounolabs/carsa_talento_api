<?php
    $app->put('/v1/000/dominio/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');
        $val01      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02      = $request->getParsedBody()['tipo_nombre'];
        $val03      = $request->getParsedBody()['tipo_equivalente'];
        $val04      = $request->getParsedBody()['tipo_dominio'];
        $val05      = $request->getParsedBody()['tipo_observacion'];
        $val06      = $request->getParsedBody()['tipo_usuario'];
        $val07      = $request->getParsedBody()['tipo_fecha_hora'];
        $val08      = $request->getParsedBody()['tipo_ip'];

        if (isset($val00) && isset($val01) && isset($val02) && isset($val04) && isset($val06) && isset($val07) && isset($val08)) {
            $sql00  = "UPDATE DOMFIC SET DOMFICEST = ?, DOMFICNOM = ?, DOMFICEQU = ?, DOMFICOBS = ?, DOMFICAUS = ?, DOMFICAFH = ?, DOMFICAIP = ? WHERE DOMFICCOD = ?";

            try {
                $connMYSQL  = getConnectionMYSQL();
                $stmtMYSQL  = $connMYSQL->prepare($sql00);
                $stmtMYSQL->execute([$val01, $val02, $val03, $val05, $val06, $val07, $val08, $val00]); 
                
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
        $val17      = $request->getParsedBody()['campanha_color'];
        
        if (isset($val00) && isset($val01) && isset($val02) && isset($val03) && isset($val04) && isset($val06) && isset($val07) && isset($val08)) {
            $sql00  = "UPDATE CAMFIC SET CAMFICEST = ?, CAMFICNOM = ?, CAMFICFDE = ?, CAMFICFHA = ?, CAMFICCOL = ?, CAMFICFO1 = ?, CAMFICFO2 = ?, CAMFICFO3 = ?, CAMFICFO4 = ?, CAMFICFO5 = ?, CAMFICFO6 = ?, CAMFICFO7 = ?, CAMFICFO8 = ?, CAMFICOBS = ?, CAMFICAUS = ?, CAMFICAFH = ?, CAMFICAIP = ? WHERE CAMFICCOD = ? AND CAMFICEST IN (2, 3)";
            
            try {
                $connMYSQL  = getConnectionMYSQL();
                $stmtMYSQL  = $connMYSQL->prepare($sql00);
                $stmtMYSQL->execute([$val01, $val02, $val03, $val04, $val17, $val09, $val10, $val11, $val12, $val13, $val14, $val15, $val16, $val05, $val06, $val07, $val08, $val00]); 
                
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
                $stmtMYSQL->execute([$val03, $aud01, $aud02, $aud03, $val00, $val01]); 
                
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
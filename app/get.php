<?php
    $app->get('/v1/000/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

		$val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.DOMFICCOD                     AS      tipo_codigo,
            a.DOMFICEST                     AS      tipo_estado_codigo,
            a.DOMFICNOM                     AS      tipo_nombre,
            a.DOMFICEQU                     AS      tipo_equivalente,
            a.DOMFICVAL                     AS      tipo_dominio,
            a.DOMFICOBS                     AS      tipo_observacion,
            a.DOMFICAUS                     AS      tipo_usuario,
            a.DOMFICAFH                     AS      tipo_fecha_hora,
            a.DOMFICAIP                     AS      tipo_ip
            
            FROM DOMFIC a
            
            WHERE a.DOMFICVAL = ?
            ORDER BY a.DOMFICNOM";

            try {
                $connMYSQL  = getConnectionMYSQL();
                $stmtMYSQL  = $connMYSQL->prepare($sql00);
                $stmtMYSQL->execute([$val01]); 

                while ($rowMYSQL = $stmtMYSQL->fetch()) {
                    if ($rowMYSQL['tipo_estado_codigo'] == 'H') {
                        $tipo_estado_nombre = 'ACTIVO';
                    } else {
                        $tipo_estado_nombre = 'INACTIVO';
                    }

                    $detalle    = array(
                        'tipo_codigo'           => $rowMYSQL['tipo_codigo'],
                        'tipo_estado_codigo'    => $rowMYSQL['tipo_estado_codigo'],
                        'tipo_estado_nombre'    => $tipo_estado_nombre,
                        'tipo_nombre'           => $rowMYSQL['tipo_nombre'],
                        'tipo_equivalente'      => $rowMYSQL['tipo_equivalente'],
                        'tipo_dominio'          => $rowMYSQL['tipo_dominio'],
                        'tipo_observacion'      => $rowMYSQL['tipo_observacion'],
                        'tipo_usuario'          => $rowMYSQL['tipo_usuario'],
                        'tipo_fecha_hora'       => $rowMYSQL['tipo_fecha_hora'],
                        'tipo_ip'               => $rowMYSQL['tipo_ip']
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_codigo'           => '',
                        'tipo_estado_codigo'    => '',
                        'tipo_estado_nombre'    => '',
                        'tipo_nombre'           => '',
                        'tipo_equivalente'      => '',
                        'tipo_dominio'          => '',
                        'tipo_observacion'      => '',
                        'tipo_usuario'          => '',
                        'tipo_fecha_hora'       => '',
                        'tipo_ip'               => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMYSQL->closeCursor();
                $stmtMYSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMYSQL  = null;
        
        return $json;
    });

    $app->get('/v1/000/dominio/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

		$val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.DOMFICCOD                     AS      tipo_codigo,
            a.DOMFICEST                     AS      tipo_estado_codigo,
            a.DOMFICNOM                     AS      tipo_nombre,
            a.DOMFICEQU                     AS      tipo_equivalente,
            a.DOMFICVAL                     AS      tipo_dominio,
            a.DOMFICOBS                     AS      tipo_observacion,
            a.DOMFICAUS                     AS      tipo_usuario,
            a.DOMFICAFH                     AS      tipo_fecha_hora,
            a.DOMFICAIP                     AS      tipo_ip
            
            FROM DOMFIC a
            
            WHERE a.DOMFICCOD = ?
            ORDER BY a.DOMFICNOM";

            try {
                $connMYSQL  = getConnectionMYSQL();
                $stmtMYSQL  = $connMYSQL->prepare($sql00);
                $stmtMYSQL->execute([$val01]); 

                while ($rowMYSQL = $stmtMYSQL->fetch()) {
                    if ($rowMYSQL['tipo_estado_codigo'] == 'H') {
                        $tipo_estado_nombre = 'ACTIVO';
                    } else {
                        $tipo_estado_nombre = 'INACTIVO';
                    }

                    $detalle    = array(
                        'tipo_codigo'           => $rowMYSQL['tipo_codigo'],
                        'tipo_estado_codigo'    => $rowMYSQL['tipo_estado_codigo'],
                        'tipo_estado_nombre'    => $tipo_estado_nombre,
                        'tipo_nombre'           => $rowMYSQL['tipo_nombre'],
                        'tipo_equivalente'      => $rowMYSQL['tipo_equivalente'],
                        'tipo_dominio'          => $rowMYSQL['tipo_dominio'],
                        'tipo_observacion'      => $rowMYSQL['tipo_observacion'],
                        'tipo_usuario'          => $rowMYSQL['tipo_usuario'],
                        'tipo_fecha_hora'       => $rowMYSQL['tipo_fecha_hora'],
                        'tipo_ip'               => $rowMYSQL['tipo_ip']
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_codigo'           => '',
                        'tipo_estado_codigo'    => '',
                        'tipo_estado_nombre'    => '',
                        'tipo_nombre'           => '',
                        'tipo_equivalente'      => '',
                        'tipo_dominio'          => '',
                        'tipo_observacion'      => '',
                        'tipo_usuario'          => '',
                        'tipo_fecha_hora'       => '',
                        'tipo_ip'               => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMYSQL->closeCursor();
                $stmtMYSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMYSQL  = null;
        
        return $json;
    });

    $app->get('/v1/000/auditoria/{dominio}', function($request) {
        require __DIR__.'/../src/connect.php';

		$val01      = $request->getAttribute('dominio');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.DOMFICACOD                    AS      auditoria_codigo,
            a.DOMFICAMET                    AS      auditoria_metodo,
            a.DOMFICAUSU                    AS      auditoria_usuario,
            a.DOMFICAFEC                    AS      auditoria_fecha_hora,
            a.DOMFICADIP                    AS      auditoria_ip,

            a.DOMFICACODOLD                 AS      auditoria_antes_tipo_codigo,
            a.DOMFICAESTOLD                 AS      auditoria_antes_tipo_estado_codigo,
            a.DOMFICANOMOLD                 AS      auditoria_antes_tipo_nombre,
            a.DOMFICAEQUOLD                 AS      auditoria_antes_tipo_equivalente,
            a.DOMFICAVALOLD                 AS      auditoria_antes_tipo_dominio,
            a.DOMFICAOBSOLD                 AS      auditoria_antes_tipo_observacion,

            a.DOMFICACODNEW                 AS      auditoria_despues_tipo_codigo,
            a.DOMFICAESTNEW                 AS      auditoria_despues_tipo_estado_codigo,
            a.DOMFICANOMNEW                 AS      auditoria_despues_tipo_nombre,
            a.DOMFICAEQUNEW                 AS      auditoria_despues_tipo_equivalente,
            a.DOMFICAVALNEW                 AS      auditoria_despues_tipo_dominio,
            a.DOMFICAOBSNEW                 AS      auditoria_despues_tipo_observacion
            
            FROM DOMFICA a
            
            WHERE a.DOMFICAVALOLD = ? OR a.DOMFICAVALNEW = ?";

            try {
                $connMYSQL  = getConnectionMYSQL();
                $stmtMYSQL  = $connMYSQL->prepare($sql00);
                $stmtMYSQL->execute([$val01, $val01]); 

                while ($rowMYSQL = $stmtMYSQL->fetch()) {
                    if ($rowMYSQL['auditoria_antes_tipo_estado_codigo'] == 'H') {
                        $tipo_estado_nombre_antes   = 'ACTIVO';
                    } else {
                        $tipo_estado_nombre_antes   = 'INACTIVO';
                    }

                    if ($rowMYSQL['auditoria_despues_tipo_estado_codigo'] == 'H') {
                        $tipo_estado_nombre_despues = 'ACTIVO';
                    } else {
                        $tipo_estado_nombre_despues = 'INACTIVO';
                    }

                    $detalle    = array(
                        'auditoria_codigo'                      => $rowMYSQL['auditoria_codigo'],
                        'auditoria_metodo'                      => $rowMYSQL['auditoria_metodo'],
                        'auditoria_usuario'                     => $rowMYSQL['auditoria_usuario'],
                        'auditoria_fecha_hora'                  => $rowMYSQL['auditoria_fecha_hora'],
                        'auditoria_ip'                          => $rowMYSQL['auditoria_ip'],

                        'auditoria_antes_tipo_codigo'           => $rowMYSQL['auditoria_antes_tipo_codigo'],
                        'auditoria_antes_tipo_estado_codigo'    => $rowMYSQL['auditoria_antes_tipo_estado_codigo'],
                        'auditoria_antes_tipo_estado_nombre'    => $tipo_estado_nombre_antes,
                        'auditoria_antes_tipo_nombre'           => $rowMYSQL['auditoria_antes_tipo_nombre'],
                        'auditoria_antes_tipo_equivalente'      => $rowMYSQL['auditoria_antes_tipo_equivalente'],
                        'auditoria_antes_tipo_dominio'          => $rowMYSQL['auditoria_antes_tipo_dominio'],
                        'auditoria_antes_tipo_observacion'      => $rowMYSQL['auditoria_antes_tipo_observacion'],

                        'auditoria_despues_tipo_codigo'         => $rowMYSQL['auditoria_despues_tipo_codigo'],
                        'auditoria_despues_tipo_estado_codigo'  => $rowMYSQL['auditoria_despues_tipo_estado_codigo'],
                        'auditoria_despues_tipo_estado_nombre'  => $tipo_estado_nombre_despues,
                        'auditoria_despues_tipo_nombre'         => $rowMYSQL['auditoria_despues_tipo_nombre'],
                        'auditoria_despues_tipo_equivalente'    => $rowMYSQL['auditoria_despues_tipo_equivalente'],
                        'auditoria_despues_tipo_dominio'        => $rowMYSQL['auditoria_despues_tipo_dominio'],
                        'auditoria_despues_tipo_observacion'    => $rowMYSQL['auditoria_despues_tipo_observacion']
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'auditoria_codigo'                      => '',
                        'auditoria_metodo'                      => '',
                        'auditoria_usuario'                     => '',
                        'auditoria_fecha_hora'                  => '',
                        'auditoria_ip'                          => '',
                        'auditoria_antes_tipo_codigo'           => '',
                        'auditoria_antes_tipo_estado_codigo'    => '',
                        'auditoria_antes_tipo_estado_nombre'    => '',
                        'auditoria_antes_tipo_nombre'           => '',
                        'auditoria_antes_tipo_equivalente'      => '',
                        'auditoria_antes_tipo_dominio'          => '',
                        'auditoria_antes_tipo_observacion'      => '',
                        'auditoria_despues_tipo_codigo'         => '',
                        'auditoria_despues_tipo_estado_codigo'  => '',
                        'auditoria_despues_tipo_estado_nombre'  => '',
                        'auditoria_despues_tipo_nombre'         => '',
                        'auditoria_despues_tipo_equivalente'    => '',
                        'auditoria_despues_tipo_dominio'        => '',
                        'auditoria_despues_tipo_observacion'    => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMYSQL->closeCursor();
                $stmtMYSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMYSQL  = null;
        
        return $json;
    });
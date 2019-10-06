<?php
    $app->get('/v1/000', function($request) {
        require __DIR__.'/../src/connect.php';
        
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

        $connMYSQL  = null;
        
        return $json;
    });

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
            
            WHERE a.DOMFICAVALOLD = ? OR a.DOMFICAVALNEW = ?
            
            ORDER BY a.DOMFICACOD DESC";

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

    $app->get('/v1/100', function($request) {
        require __DIR__.'/../src/connect.php';

        $sql00  = "SELECT
        a.CAMFICCOD                     AS      campanha_codigo,
        a.CAMFICNOM                     AS      campanha_nombre,
        a.CAMFICFDE                     AS      campanha_fecha_inicio,
        a.CAMFICFHA                     AS      campanha_fecha_final,
        a.CAMFICFO1                     AS      campanha_formulario_1,
        a.CAMFICFO2                     AS      campanha_formulario_2,
        a.CAMFICFO3                     AS      campanha_formulario_3,
        a.CAMFICFO4                     AS      campanha_formulario_4,
        a.CAMFICFO5                     AS      campanha_formulario_5,
        a.CAMFICFO6                     AS      campanha_formulario_6,
        a.CAMFICFO7                     AS      campanha_formulario_7,
        a.CAMFICFO8                     AS      campanha_formulario_8,
        a.CAMFICOBS                     AS      campanha_observacion,
        a.CAMFICAUS                     AS      campanha_usuario,
        a.CAMFICAFH                     AS      campanha_fecha_hora,
        a.CAMFICAIP                     AS      campanha_ip,

        b.DOMFICCOD                     AS      campanha_estado_codigo,
        b.DOMFICNOM                     AS      campanha_estado_nombre
        
        FROM CAMFIC a
        INNER JOIN DOMFIC b ON a.CAMFICEST = b.DOMFICCOD
        
        ORDER BY a.CAMFICFDE DESC";

        try {
            $connMYSQL  = getConnectionMYSQL();
            $stmtMYSQL  = $connMYSQL->prepare($sql00);
            $stmtMYSQL->execute(); 

            while ($rowMYSQL = $stmtMYSQL->fetch()) {
                if($rowMYSQL['campanha_formulario_1'] === 'S'){
                    $campanha_formulario_1 = 'checked';
                } else {
                    $campanha_formulario_1 = '';
                }

                if($rowMYSQL['campanha_formulario_2'] === 'S'){
                    $campanha_formulario_2 = 'checked';
                } else {
                    $campanha_formulario_2 = '';
                }

                if($rowMYSQL['campanha_formulario_3'] === 'S'){
                    $campanha_formulario_3 = 'checked';
                } else {
                    $campanha_formulario_3 = '';
                }

                if($rowMYSQL['campanha_formulario_4'] === 'S'){
                    $campanha_formulario_4 = 'checked';
                } else {
                    $campanha_formulario_4 = '';
                }

                if($rowMYSQL['campanha_formulario_5'] === 'S'){
                    $campanha_formulario_5 = 'checked';
                } else {
                    $campanha_formulario_5 = '';
                }

                if($rowMYSQL['campanha_formulario_6'] === 'S'){
                    $campanha_formulario_6 = 'checked';
                } else {
                    $campanha_formulario_6 = '';
                }

                if($rowMYSQL['campanha_formulario_7'] === 'S'){
                    $campanha_formulario_7 = 'checked';
                } else {
                    $campanha_formulario_7 = '';
                }

                if($rowMYSQL['campanha_formulario_8'] === 'S'){
                    $campanha_formulario_8 = 'checked';
                } else {
                    $campanha_formulario_8 = '';
                }

                $detalle    = array(
                    'campanha_codigo'           => $rowMYSQL['campanha_codigo'],
                    'campanha_estado_codigo'    => $rowMYSQL['campanha_estado_codigo'],
                    'campanha_estado_nombre'    => $rowMYSQL['campanha_estado_nombre'],
                    'campanha_nombre'           => $rowMYSQL['campanha_nombre'],
                    'campanha_fecha_inicio'     => $rowMYSQL['campanha_fecha_inicio'],
                    'campanha_fecha_inicio_2'   => date('d/m/Y', strtotime($rowMYSQL['campanha_fecha_inicio'])),
                    'campanha_fecha_final'      => $rowMYSQL['campanha_fecha_final'],
                    'campanha_fecha_final_2'    => date("d/m/Y", strtotime($rowMYSQL['campanha_fecha_final'])),
                    'campanha_formulario_1'     => $campanha_formulario_1,
                    'campanha_formulario_2'     => $campanha_formulario_2,
                    'campanha_formulario_3'     => $campanha_formulario_3,
                    'campanha_formulario_4'     => $campanha_formulario_4,
                    'campanha_formulario_5'     => $campanha_formulario_5,
                    'campanha_formulario_6'     => $campanha_formulario_6,
                    'campanha_formulario_7'     => $campanha_formulario_7,
                    'campanha_formulario_8'     => $campanha_formulario_8,
                    'campanha_observacion'      => $rowMYSQL['campanha_observacion'],
                    'campanha_usuario'          => $rowMYSQL['campanha_usuario'],
                    'campanha_fecha_hora'       => $rowMYSQL['campanha_fecha_hora'],
                    'campanha_ip'               => $rowMYSQL['campanha_ip']
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle = array(
                    'campanha_codigo'           => '',
                    'campanha_estado_codigo'    => '',
                    'campanha_estado_nombre'    => '',
                    'campanha_nombre'           => '',
                    'campanha_fecha_inicio'     => '',
                    'campanha_fecha_inicio_2'   => '',
                    'campanha_fecha_final'      => '',
                    'campanha_fecha_final_2'    => '',
                    'campanha_formulario_1'     => '',
                    'campanha_formulario_2'     => '',
                    'campanha_formulario_3'     => '',
                    'campanha_formulario_4'     => '',
                    'campanha_formulario_5'     => '',
                    'campanha_formulario_6'     => '',
                    'campanha_formulario_7'     => '',
                    'campanha_formulario_8'     => '',
                    'campanha_observacion'      => '',
                    'campanha_usuario'          => '',
                    'campanha_fecha_hora'       => '',
                    'campanha_ip'               => ''
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

        $connMYSQL  = null;
        
        return $json;
    });

    $app->get('/v1/100/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getAttribute('codigo');

        if (isset($val01)) {
            $sql00  = "SELECT
            a.CAMFICCOD                     AS      campanha_codigo,
            a.CAMFICNOM                     AS      campanha_nombre,
            a.CAMFICFDE                     AS      campanha_fecha_inicio,
            a.CAMFICFHA                     AS      campanha_fecha_final,
            a.CAMFICFO1                     AS      campanha_formulario_1,
            a.CAMFICFO2                     AS      campanha_formulario_2,
            a.CAMFICFO3                     AS      campanha_formulario_3,
            a.CAMFICFO4                     AS      campanha_formulario_4,
            a.CAMFICFO5                     AS      campanha_formulario_5,
            a.CAMFICFO6                     AS      campanha_formulario_6,
            a.CAMFICFO7                     AS      campanha_formulario_7,
            a.CAMFICFO8                     AS      campanha_formulario_8,
            a.CAMFICOBS                     AS      campanha_observacion,
            a.CAMFICAUS                     AS      campanha_usuario,
            a.CAMFICAFH                     AS      campanha_fecha_hora,
            a.CAMFICAIP                     AS      campanha_ip,
            b.DOMFICCOD                     AS      campanha_estado_codigo,
            b.DOMFICNOM                     AS      campanha_estado_nombre
            
            FROM CAMFIC a
            INNER JOIN DOMFIC b ON a.CAMFICEST = b.DOMFICCOD

            WHERE a.CAMFICCOD = ?
            
            ORDER BY a.CAMFICFDE DESC";

            try {
                $connMYSQL  = getConnectionMYSQL();
                $stmtMYSQL  = $connMYSQL->prepare($sql00);
                $stmtMYSQL->execute([$val01]); 

                while ($rowMYSQL = $stmtMYSQL->fetch()) {
                    if($rowMYSQL['campanha_formulario_1'] === 'S'){
                        $campanha_formulario_1 = 'checked';
                    } else {
                        $campanha_formulario_1 = '';
                    }
    
                    if($rowMYSQL['campanha_formulario_2'] === 'S'){
                        $campanha_formulario_2 = 'checked';
                    } else {
                        $campanha_formulario_2 = '';
                    }
    
                    if($rowMYSQL['campanha_formulario_3'] === 'S'){
                        $campanha_formulario_3 = 'checked';
                    } else {
                        $campanha_formulario_3 = '';
                    }
    
                    if($rowMYSQL['campanha_formulario_4'] === 'S'){
                        $campanha_formulario_4 = 'checked';
                    } else {
                        $campanha_formulario_4 = '';
                    }
    
                    if($rowMYSQL['campanha_formulario_5'] === 'S'){
                        $campanha_formulario_5 = 'checked';
                    } else {
                        $campanha_formulario_5 = '';
                    }
    
                    if($rowMYSQL['campanha_formulario_6'] === 'S'){
                        $campanha_formulario_6 = 'checked';
                    } else {
                        $campanha_formulario_6 = '';
                    }
    
                    if($rowMYSQL['campanha_formulario_7'] === 'S'){
                        $campanha_formulario_7 = 'checked';
                    } else {
                        $campanha_formulario_7 = '';
                    }
    
                    if($rowMYSQL['campanha_formulario_8'] === 'S'){
                        $campanha_formulario_8 = 'checked';
                    } else {
                        $campanha_formulario_8 = '';
                    }
    
                    $detalle    = array(
                        'campanha_codigo'           => $rowMYSQL['campanha_codigo'],
                        'campanha_estado_codigo'    => $rowMYSQL['campanha_estado_codigo'],
                        'campanha_estado_nombre'    => $rowMYSQL['campanha_estado_nombre'],
                        'campanha_nombre'           => $rowMYSQL['campanha_nombre'],
                        'campanha_fecha_inicio'     => $rowMYSQL['campanha_fecha_inicio'],
                        'campanha_fecha_inicio_2'   => date('d/m/Y', strtotime($rowMYSQL['campanha_fecha_inicio'])),
                        'campanha_fecha_final'      => $rowMYSQL['campanha_fecha_final'],
                        'campanha_fecha_final_2'    => date("d/m/Y", strtotime($rowMYSQL['campanha_fecha_final'])),
                        'campanha_formulario_1'     => $campanha_formulario_1,
                        'campanha_formulario_2'     => $campanha_formulario_2,
                        'campanha_formulario_3'     => $campanha_formulario_3,
                        'campanha_formulario_4'     => $campanha_formulario_4,
                        'campanha_formulario_5'     => $campanha_formulario_5,
                        'campanha_formulario_6'     => $campanha_formulario_6,
                        'campanha_formulario_7'     => $campanha_formulario_7,
                        'campanha_formulario_8'     => $campanha_formulario_8,
                        'campanha_observacion'      => $rowMYSQL['campanha_observacion'],
                        'campanha_usuario'          => $rowMYSQL['campanha_usuario'],
                        'campanha_fecha_hora'       => $rowMYSQL['campanha_fecha_hora'],
                        'campanha_ip'               => $rowMYSQL['campanha_ip']
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'campanha_codigo'           => '',
                        'campanha_estado_codigo'    => '',
                        'campanha_estado_nombre'    => '',
                        'campanha_nombre'           => '',
                        'campanha_fecha_inicio'     => '',
                        'campanha_fecha_inicio_2'   => '',
                        'campanha_fecha_final'      => '',
                        'campanha_fecha_final_2'    => '',
                        'campanha_formulario_1'     => '',
                        'campanha_formulario_2'     => '',
                        'campanha_formulario_3'     => '',
                        'campanha_formulario_4'     => '',
                        'campanha_formulario_5'     => '',
                        'campanha_formulario_6'     => '',
                        'campanha_formulario_7'     => '',
                        'campanha_formulario_8'     => '',
                        'campanha_observacion'      => '',
                        'campanha_usuario'          => '',
                        'campanha_fecha_hora'       => '',
                        'campanha_ip'               => ''
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

    $app->get('/v1/200', function($request) {
        require __DIR__.'/../src/connect.php';

        $sql00  = "SELECT
        a.FUNFICCOD                     AS      funcionario_codigo,
        a.FUNFICEST                     AS      funcionario_estado_codigo,

        b.DOMFICCOD                     AS      funcionario_documento_codigo,
        b.DOMFICNOM                     AS      funcionario_documento_nombre,
        a.FUNFICDOC                     AS      funcionario_documento_numero,

        c.DOMFICCOD                     AS      funcionario_sexo_codigo,
        c.DOMFICNOM                     AS      funcionario_sexo_nombre,

        d.DOMFICCOD                     AS      funcionario_estado_civil_codigo,
        d.DOMFICNOM                     AS      funcionario_estado_civil_nombre,

        a.FUNFICCFU                     AS      funcionario_codigo_sistema,
        a.FUNFICNOM                     AS      funcionario_nombre,
        a.FUNFICAPE                     AS      funcionario_apellido,
        a.FUNFICFHA                     AS      funcionario_fecha_nacimiento,
        a.FUNFICEMA                     AS      funcionario_email,
        a.FUNFICFOT                     AS      funcionario_foto,
        a.FUNFICOBS                     AS      funcionario_observacion,
        a.FUNFICAUS                     AS      funcionario_usuario,
        a.FUNFICAFH                     AS      funcionario_fecha_hora,
        a.FUNFICAIP                     AS      funcionario_ip

        
        FROM FUNFIC a
        INNER JOIN DOMFIC b ON a.FUNFICTDC = b.DOMFICCOD
        INNER JOIN DOMFIC c ON a.FUNFICTSC = c.DOMFICCOD
        INNER JOIN DOMFIC d ON a.FUNFICECC = d.DOMFICCOD
        
        ORDER BY a.FUNFICCOD";

        try {
            $connMYSQL  = getConnectionMYSQL();
            $stmtMYSQL  = $connMYSQL->prepare($sql00);
            $stmtMYSQL->execute(); 

            while ($rowMYSQL = $stmtMYSQL->fetch()) {
                if ($rowMYSQL['funcionario_estado_codigo'] == 'A') {
                    $funcionario_estado_nombre = 'ACTIVO';
                } else {
                    $funcionario_estado_nombre = 'INACTIVO';
                }

                $detalle    = array(
                    'funcionario_codigo'                => $rowMYSQL['funcionario_codigo'],
                    'funcionario_estado_codigo'         => $rowMYSQL['funcionario_estado_codigo'],
                    'funcionario_estado_nombre'         => $funcionario_estado_nombre,
                    'funcionario_documento_codigo'      => $rowMYSQL['funcionario_documento_codigo'],
                    'funcionario_documento_nombre'      => $rowMYSQL['funcionario_documento_nombre'],
                    'funcionario_documento_numero'      => $rowMYSQL['funcionario_documento_numero'],
                    'funcionario_sexo_codigo'           => $rowMYSQL['funcionario_sexo_codigo'],
                    'funcionario_sexo_nombre'           => $rowMYSQL['funcionario_sexo_nombre'],
                    'funcionario_estado_civil_codigo'   => $rowMYSQL['funcionario_estado_civil_codigo'],
                    'funcionario_estado_civil_nombre'   => $rowMYSQL['funcionario_estado_civil_nombre'],
                    'funcionario_codigo_sistema'        => $rowMYSQL['funcionario_codigo_sistema'],
                    'funcionario_nombre'                => $rowMYSQL['funcionario_nombre'],
                    'funcionario_apellido'              => $rowMYSQL['funcionario_apellido'],
                    'funcionario_persona'               => $rowMYSQL['funcionario_nombre'].' '.$rowMYSQL['funcionario_apellido'],
                    'funcionario_fecha_nacimiento'      => $rowMYSQL['funcionario_fecha_nacimiento'],
                    'funcionario_fecha_nacimiento_2'    => date("d/m/Y", strtotime($rowMYSQL['funcionario_fecha_nacimiento'])),
                    'funcionario_email'                 => $rowMYSQL['funcionario_email'],
                    'funcionario_foto'                  => $rowMYSQL['funcionario_foto'],
                    'funcionario_observacion'           => $rowMYSQL['funcionario_observacion'],
                    'funcionario_usuario'               => $rowMYSQL['funcionario_usuario'],
                    'funcionario_fecha_hora'            => $rowMYSQL['funcionario_fecha_hora'],
                    'funcionario_ip'                    => $rowMYSQL['funcionario_ip']
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle = array(
                    'funcionario_codigo'                => '',
                    'funcionario_estado_codigo'         => '',
                    'funcionario_estado_nombre'         => '',
                    'funcionario_documento_codigo'      => '',
                    'funcionario_documento_nombre'      => '',
                    'funcionario_documento_numero'      => '',
                    'funcionario_sexo_codigo'           => '',
                    'funcionario_sexo_nombre'           => '',
                    'funcionario_estado_civil_codigo'   => '',
                    'funcionario_estado_civil_nombre'   => '',
                    'funcionario_codigo_sistema'        => '',
                    'funcionario_nombre'                => '',
                    'funcionario_apellido'              => '',
                    'funcionario_persona'               => '',
                    'funcionario_fecha_nacimiento'      => '',
                    'funcionario_fecha_nacimiento_2'    => '',
                    'funcionario_email'                 => '',
                    'funcionario_foto'                  => '',
                    'funcionario_observacion'           => '',
                    'funcionario_usuario'               => '',
                    'funcionario_fecha_hora'            => '',
                    'funcionario_ip'                    => ''
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

        $connMYSQL  = null;
        
        return $json;
    });

    $app->get('/v1/200/auditoria', function($request) {
        require __DIR__.'/../src/connect.php';

        $sql00  = "SELECT
        a.FUNFICACOD            AS      auditoria_codigo,
        a.FUNFICAMET            AS      auditoria_metodo,
        a.FUNFICAUSU            AS      auditoria_usuario,
        a.FUNFICAFEC            AS      auditoria_fecha_hora,
        a.FUNFICADIP            AS      auditoria_ip,

        a.FUNFICACODOLD         AS      auditoria_antes_codigo,
        a.FUNFICAESTOLD         AS      auditoria_antes_estado_codigo,
        b.DOMFICCOD             AS      auditoria_antes_documento_codigo,
        b.DOMFICNOM             AS      auditoria_antes_documento_nombre,
        a.FUNFICADOCOLD         AS      auditoria_antes_documento_numero,
        c.DOMFICCOD             AS      auditoria_antes_sexo_codigo,
        c.DOMFICNOM             AS      auditoria_antes_sexo_nombre,
        d.DOMFICCOD             AS      auditoria_antes_estado_civil_codigo,
        d.DOMFICNOM             AS      auditoria_antes_estado_civil_nombre,
        a.FUNFICACFUOLD         AS      auditoria_antes_codigo_sistema,
        a.FUNFICANOMOLD         AS      auditoria_antes_nombre,
        a.FUNFICAAPEOLD         AS      auditoria_antes_apellido,
        a.FUNFICAFHAOLD         AS      auditoria_antes_fecha_nacimiento,
        a.FUNFICAEMAOLD         AS      auditoria_antes_email,
        a.FUNFICAFOTOLD         AS      auditoria_antes_foto,
        a.FUNFICAOBSOLD         AS      auditoria_antes_observacion,

        a.FUNFICACODNEW         AS      auditoria_despues_codigo,
        a.FUNFICAESTNEW         AS      auditoria_despues_estado_codigo,
        e.DOMFICCOD             AS      auditoria_despues_documento_codigo,
        e.DOMFICNOM             AS      auditoria_despues_documento_nombre,
        a.FUNFICADOCNEW         AS      auditoria_despues_documento_numero,
        f.DOMFICCOD             AS      auditoria_despues_sexo_codigo,
        f.DOMFICNOM             AS      auditoria_despues_sexo_nombre,
        g.DOMFICCOD             AS      auditoria_despues_estado_civil_codigo,
        g.DOMFICNOM             AS      auditoria_despues_estado_civil_nombre,
        a.FUNFICACFUNEW         AS      auditoria_despues_codigo_sistema,
        a.FUNFICANOMNEW         AS      auditoria_despues_nombre,
        a.FUNFICAAPENEW         AS      auditoria_despues_apellido,
        a.FUNFICAFHANEW         AS      auditoria_despues_fecha_nacimiento,
        a.FUNFICAEMANEW         AS      auditoria_despues_email,
        a.FUNFICAFOTNEW         AS      auditoria_despues_foto,
        a.FUNFICAOBSNEW         AS      auditoria_despues_observacion

        FROM FUNFICA a
        LEFT JOIN DOMFIC b ON a.FUNFICATDCOLD = b.DOMFICCOD
        LEFT JOIN DOMFIC c ON a.FUNFICATSCOLD = c.DOMFICCOD
        LEFT JOIN DOMFIC d ON a.FUNFICAECCOLD = d.DOMFICCOD

        LEFT JOIN DOMFIC e ON a.FUNFICATDCNEW = e.DOMFICCOD
        LEFT JOIN DOMFIC f ON a.FUNFICATSCNEW = f.DOMFICCOD
        LEFT JOIN DOMFIC g ON a.FUNFICAECCNEW = g.DOMFICCOD
        
        ORDER BY a.FUNFICACOD DESC";

        try {
            $connMYSQL  = getConnectionMYSQL();
            $stmtMYSQL  = $connMYSQL->prepare($sql00);
            $stmtMYSQL->execute(); 

            while ($rowMYSQL = $stmtMYSQL->fetch()) {
                if ($rowMYSQL['auditoria_antes_estado_codigo'] == 'A') {
                    $auditoria_antes_estado_nombre = 'ACTIVO';
                } else {
                    $auditoria_antes_estado_nombre = 'INACTIVO';
                }

                if ($rowMYSQL['auditoria_despues_estado_codigo'] == 'A') {
                    $auditoria_despues_estado_nombre = 'ACTIVO';
                } else {
                    $auditoria_despues_estado_nombre = 'INACTIVO';
                }

                $detalle    = array(
                    'auditoria_codigo'                          => $rowMYSQL['auditoria_codigo'],
                    'auditoria_metodo'                          => $rowMYSQL['auditoria_metodo'],
                    'auditoria_usuario'                         => $rowMYSQL['auditoria_usuario'],
                    'auditoria_fecha_hora'                      => $rowMYSQL['auditoria_fecha_hora'],
                    'auditoria_ip'                              => $rowMYSQL['auditoria_ip'],

                    'auditoria_antes_codigo'                    => $rowMYSQL['auditoria_antes_codigo'],
                    'auditoria_antes_estado_codigo'             => $rowMYSQL['auditoria_antes_estado_codigo'],
                    'auditoria_antes_estado_nombre'             => $auditoria_antes_estado_nombre,
                    'auditoria_antes_documento_codigo'          => $rowMYSQL['auditoria_antes_documento_codigo'],
                    'auditoria_antes_documento_nombre'          => $rowMYSQL['auditoria_antes_documento_nombre'],
                    'auditoria_antes_documento_numero'          => $rowMYSQL['auditoria_antes_documento_numero'],
                    'auditoria_antes_sexo_codigo'               => $rowMYSQL['auditoria_antes_sexo_codigo'],
                    'auditoria_antes_sexo_nombre'               => $rowMYSQL['auditoria_antes_sexo_nombre'],
                    'auditoria_antes_estado_civil_codigo'       => $rowMYSQL['auditoria_antes_estado_civil_codigo'],
                    'auditoria_antes_estado_civil_nombre'       => $rowMYSQL['auditoria_antes_estado_civil_nombre'],
                    'auditoria_antes_codigo_sistema'            => $rowMYSQL['auditoria_antes_codigo_sistema'],
                    'auditoria_antes_nombre'                    => $rowMYSQL['auditoria_antes_nombre'],
                    'auditoria_antes_apellido'                  => $rowMYSQL['auditoria_antes_apellido'],
                    'auditoria_antes_persona'                   => $rowMYSQL['auditoria_antes_nombre'].' '.$rowMYSQL['auditoria_antes_apellido'],
                    'auditoria_antes_fecha_nacimiento'          => $rowMYSQL['auditoria_antes_fecha_nacimiento'],
                    'auditoria_antes_fecha_nacimiento_2'        => date("d/m/Y", strtotime($rowMYSQL['auditoria_antes_fecha_nacimiento'])),
                    'auditoria_antes_email'                     => $rowMYSQL['auditoria_antes_email'],
                    'auditoria_antes_foto'                      => $rowMYSQL['auditoria_antes_foto'],
                    'auditoria_antes_observacion'               => $rowMYSQL['auditoria_antes_observacion'],

                    'auditoria_despues_codigo'                  => $rowMYSQL['auditoria_despues_codigo'],
                    'auditoria_despues_estado_codigo'           => $rowMYSQL['auditoria_despues_estado_codigo'],
                    'auditoria_despues_estado_nombre'           => $auditoria_despues_estado_nombre,
                    'auditoria_despues_documento_codigo'        => $rowMYSQL['auditoria_despues_documento_codigo'],
                    'auditoria_despues_documento_nombre'        => $rowMYSQL['auditoria_despues_documento_nombre'],
                    'auditoria_despues_documento_numero'        => $rowMYSQL['auditoria_despues_documento_numero'],
                    'auditoria_despues_sexo_codigo'             => $rowMYSQL['auditoria_despues_sexo_codigo'],
                    'auditoria_despues_sexo_nombre'             => $rowMYSQL['auditoria_despues_sexo_nombre'],
                    'auditoria_despues_estado_civil_codigo'     => $rowMYSQL['auditoria_despues_estado_civil_codigo'],
                    'auditoria_despues_estado_civil_nombre'     => $rowMYSQL['auditoria_despues_estado_civil_nombre'],
                    'auditoria_despues_codigo_sistema'          => $rowMYSQL['auditoria_despues_codigo_sistema'],
                    'auditoria_despues_nombre'                  => $rowMYSQL['auditoria_despues_nombre'],
                    'auditoria_despues_apellido'                => $rowMYSQL['auditoria_despues_apellido'],
                    'auditoria_despues_persona'                 => $rowMYSQL['auditoria_despues_nombre'].' '.$rowMYSQL['auditoria_despues_apellido'],
                    'auditoria_despues_fecha_nacimiento'        => $rowMYSQL['auditoria_despues_fecha_nacimiento'],
                    'auditoria_despues_fecha_nacimiento_2'      => date("d/m/Y", strtotime($rowMYSQL['auditoria_despues_fecha_nacimiento'])),
                    'auditoria_despues_email'                   => $rowMYSQL['auditoria_despues_email'],
                    'auditoria_despues_foto'                    => $rowMYSQL['auditoria_despues_foto'],
                    'auditoria_despues_observacion'             => $rowMYSQL['auditoria_despues_observacion']
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle = array(
                    'auditoria_codigo'                          => '',
                    'auditoria_metodo'                          => '',
                    'auditoria_usuario'                         => '',
                    'auditoria_fecha_hora'                      => '',
                    'auditoria_ip'                              => '',

                    'auditoria_antes_codigo'                    => '',
                    'auditoria_antes_estado_codigo'             => '',
                    'auditoria_antes_estado_nombre'             => '',
                    'auditoria_antes_documento_codigo'          => '',
                    'auditoria_antes_documento_nombre'          => '',
                    'auditoria_antes_documento_numero'          => '',
                    'auditoria_antes_sexo_codigo'               => '',
                    'auditoria_antes_sexo_nombre'               => '',
                    'auditoria_antes_estado_civil_codigo'       => '',
                    'auditoria_antes_estado_civil_nombre'       => '',
                    'auditoria_antes_codigo_sistema'            => '',
                    'auditoria_antes_nombre'                    => '',
                    'auditoria_antes_apellido'                  => '',
                    'auditoria_antes_persona'                   => '',
                    'auditoria_antes_fecha_nacimiento'          => '',
                    'auditoria_antes_fecha_nacimiento_2'        => '',
                    'auditoria_antes_email'                     => '',
                    'auditoria_antes_foto'                      => '',
                    'auditoria_antes_observacion'               => '',

                    'auditoria_despues_codigo'                  => '',
                    'auditoria_despues_estado_codigo'           => '',
                    'auditoria_despues_estado_nombre'           => '',
                    'auditoria_despues_documento_codigo'        => '',
                    'auditoria_despues_documento_nombre'        => '',
                    'auditoria_despues_documento_numero'        => '',
                    'auditoria_despues_sexo_codigo'             => '',
                    'auditoria_despues_sexo_nombre'             => '',
                    'auditoria_despues_estado_civil_codigo'     => '',
                    'auditoria_despues_estado_civil_nombre'     => '',
                    'auditoria_despues_codigo_sistema'          => '',
                    'auditoria_despues_nombre'                  => '',
                    'auditoria_despues_apellido'                => '',
                    'auditoria_despues_persona'                 => '',
                    'auditoria_despues_fecha_nacimiento'        => '',
                    'auditoria_despues_fecha_nacimiento_2'      => '',
                    'auditoria_despues_email'                   => '',
                    'auditoria_despues_foto'                    => '',
                    'auditoria_despues_observacion'             => ''
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

        $connMYSQL  = null;
        
        return $json;
    });

    $app->get('/v1/200/estadocivil', function($request) {
        require __DIR__.'/../src/connect.php';

        $sql00  = "SELECT
        a.FUNFICECC                     AS      funcionario_estado_civil_codigo,
        a.FUNFICTSC                     AS      funcionario_sexo_codigo,
        b.DOMFICNOM                     AS      funcionario_estado_civil_nombre,
        c.DOMFICNOM                     AS      funcionario_sexo_nombre,
        COUNT(*)                        AS      funcionario_cantidad
        
        FROM FUNFIC a
        INNER JOIN DOMFIC b ON a.FUNFICECC = b.DOMFICCOD
        INNER JOIN DOMFIC c ON a.FUNFICTSC = c.DOMFICCOD

        WHERE a.FUNFICEST = 'A'
        
        GROUP BY a.FUNFICECC, a.FUNFICTSC
        ORDER BY a.FUNFICECC, a.FUNFICTSC";

        try {
            $connMYSQL  = getConnectionMYSQL();
            $stmtMYSQL  = $connMYSQL->prepare($sql00);
            $stmtMYSQL->execute(); 

            while ($rowMYSQL = $stmtMYSQL->fetch()) {
                $detalle    = array(
                    'funcionario_estado_civil_codigo'   => $rowMYSQL['funcionario_estado_civil_codigo'],
                    'funcionario_estado_civil_nombre'   => $rowMYSQL['funcionario_estado_civil_nombre'],
                    'funcionario_sexo_codigo'           => $rowMYSQL['funcionario_sexo_codigo'],
                    'funcionario_sexo_nombre'           => $rowMYSQL['funcionario_sexo_nombre'],
                    'funcionario_cantidad'              => $rowMYSQL['funcionario_cantidad']
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle = array(
                    'funcionario_estado_civil_codigo'   => '',
                    'funcionario_estado_civil_nombre'   => 'No hay registro',
                    'funcionario_sexo_codigo'           => '',
                    'funcionario_sexo_nombre'           => 'No hay registro',
                    'funcionario_cantidad'              => 0
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

        $connMYSQL  = null;
        
        return $json;
    });

    $app->get('/v1/200/cumpleanho', function($request) {
        require __DIR__.'/../src/connect.php';

        $sql00  = "SELECT
        MONTH(a.FUNFICFHA)          AS      funcionario_mes_codigo,
        COUNT(*)                    AS      funcionario_mes_cantidad
        
        FROM FUNFIC a

        WHERE a.FUNFICEST = 'A'
        
        GROUP BY MONTH(a.FUNFICFHA)
        ORDER BY MONTH(a.FUNFICFHA)";

        try {
            $connMYSQL  = getConnectionMYSQL();
            $stmtMYSQL  = $connMYSQL->prepare($sql00);
            $stmtMYSQL->execute(); 

            while ($rowMYSQL = $stmtMYSQL->fetch()) {
                switch ($rowMYSQL['funcionario_mes_codigo']) {
                    case '1':
                        $funcionario_mes_nombre = 'Enero';
                        break;

                    case '2':
                        $funcionario_mes_nombre = 'Febrero';
                        break;

                    case '3':
                        $funcionario_mes_nombre = 'Marzo';
                        break;

                    case '4':
                        $funcionario_mes_nombre = 'Abril';
                        break;

                    case '5':
                        $funcionario_mes_nombre = 'Mayo';
                        break;

                    case '6':
                        $funcionario_mes_nombre = 'Junio';
                        break;

                    case '7':
                        $funcionario_mes_nombre = 'Julio';
                        break;

                    case '8':
                        $funcionario_mes_nombre = 'Agosto';
                        break;

                    case '9':
                        $funcionario_mes_nombre = 'Septiembre';
                        break;

                    case '10':
                        $funcionario_mes_nombre = 'Octubre';
                        break;

                    case '11':
                        $funcionario_mes_nombre = 'Noviembre';
                        break;

                    case '12':
                        $funcionario_mes_nombre = 'Diciembre';
                        break;
                }

                $detalle    = array(
                    'funcionario_mes_codigo'    => $rowMYSQL['funcionario_mes_codigo'],
                    'funcionario_mes_nombre'    => $funcionario_mes_nombre,
                    'funcionario_mes_cantidad'  => $rowMYSQL['funcionario_mes_cantidad']
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle = array(
                    'funcionario_mes_codigo'    => '',
                    'funcionario_mes_nombre'    => 'No hay registro',
                    'funcionario_mes_cantidad'  => 0
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

        $connMYSQL  = null;
        
        return $json;
    });

    $app->get('/v1/300/participacion', function($request) {
        require __DIR__.'/../src/connect.php';

        $sql00  = "SELECT
        a.CAMFUCCAC         AS      campanha_codigo,
        b.CAMFICNOM         AS      campanha_nombre,
        COUNT(*)            AS      campanha_cantidad
        
        FROM CAMFUC a
        INNER JOIN CAMFIC b ON a.CAMFUCCAC = b.CAMFICCOD

        WHERE b.CAMFICEST IN (4, 5)
        
        GROUP BY CAMFUCCAC
        ORDER BY CAMFUCCAC";

        try {
            $connMYSQL  = getConnectionMYSQL();
            $stmtMYSQL  = $connMYSQL->prepare($sql00);
            $stmtMYSQL->execute(); 

            while ($rowMYSQL = $stmtMYSQL->fetch()) {
                $detalle    = array(
                    'campanha_codigo'       => $rowMYSQL['campanha_codigo'],
                    'campanha_nombre'       => $rowMYSQL['campanha_nombre'],
                    'campanha_cantidad'     => $rowMYSQL['campanha_cantidad']
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle = array(
                    'campanha_codigo'       => '',
                    'campanha_nombre'       => 'No hay registro',
                    'campanha_cantidad'     => 0
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

        $connMYSQL  = null;
        
        return $json;
    });

    $app->get('/v1/300/detalle/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            b.CAMFICCOD         AS      campanha_codigo,
            b.CAMFICNOM         AS      campanha_nombre,

            c.FUNFICCOD         AS      funcionario_codigo,
            c.FUNFICCFU         AS      funcionario_sistema_codigo,
            c.FUNFICNOM         AS      funcionario_nombre,
            c.FUNFICAPE         AS      funcionario_apellido,
            c.FUNFICFOT         AS      funcionario_foto,
            
            a.CAMFUCEST         AS      funcionario_estado_codigo
            
            FROM CAMFUC a
            INNER JOIN CAMFIC b ON a.CAMFUCCAC = b.CAMFICCOD
            INNER JOIN FUNFIC c ON a.CAMFUCFUC = c.FUNFICCOD

            WHERE a.CAMFUCCAC = ?
            
            ORDER BY a.CAMFUCCAC";

            try {
                $connMYSQL  = getConnectionMYSQL();
                $stmtMYSQL  = $connMYSQL->prepare($sql00);
                $stmtMYSQL->execute([$val01]);

                while ($rowMYSQL = $stmtMYSQL->fetch()) {
                    if ($rowMYSQL['funcionario_estado_codigo'] === 'P') {
                        $funcionario_estado_nombre = 'PENDIENTE';
                    } elseif ($rowMYSQL['funcionario_estado_codigo'] === 'C') {
                        $funcionario_estado_nombre = 'CARGADO';
                    } elseif ($rowMYSQL['funcionario_estado_codigo'] === 'F') {
                        $funcionario_estado_nombre = 'CONFIRMADO';
                    }

                    $detalle    = array(
                        'campanha_codigo'               => $rowMYSQL['campanha_codigo'],
                        'campanha_nombre'               => $rowMYSQL['campanha_nombre'],
                        'funcionario_codigo'            => $rowMYSQL['funcionario_codigo'],
                        'funcionario_sistema_codigo'    => $rowMYSQL['funcionario_sistema_codigo'],
                        'funcionario_nombre'            => $rowMYSQL['funcionario_nombre'],
                        'funcionario_apellido'          => $rowMYSQL['funcionario_apellido'],
                        'funcionario_persona'           => $rowMYSQL['funcionario_nombre'].' '.$rowMYSQL['funcionario_apellido'],
                        'funcionario_foto'              => $rowMYSQL['funcionario_foto'],
                        'funcionario_estado_codigo'     => $rowMYSQL['funcionario_estado_codigo'],
                        'funcionario_estado_nombre'     => $funcionario_estado_nombre
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'campanha_codigo'               => '',
                        'campanha_nombre'               => '',
                        'funcionario_codigo'            => '',
                        'funcionario_sistema_codigo'    => '',
                        'funcionario_nombre'            => '',
                        'funcionario_apellido'          => '',
                        'funcionario_persona'           => '',
                        'funcionario_foto'              => '',
                        'funcionario_estado_codigo'     => '',
                        'funcionario_estado_nombre'     => ''
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
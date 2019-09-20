<?php
    $app->get('/v1/000/{dominio}', function($request) {
        require __DIR__.'/../src/connect.php';

		$val01      = $request->getAttribute('dominio');
        
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
                $stmtMYSQL  = $connMYSQL->query($sql00);
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
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Consulta con exito', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
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
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Hubo un error al momento de ingresar: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMYSQL  = null;
        
        return $json;
    });
<?php
    $app->get('/v1/000/dominio', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $sql00  = "SELECT
        a.DOMFICCOD                     AS      tipo_codigo,
        a.DOMFICORD                     AS      tipo_orden,
        a.DOMFICNOM                     AS      tipo_nombre,
        a.DOMFICEQU                     AS      tipo_equivalente,
        a.DOMFICVAL                     AS      tipo_dominio,
        a.DOMFICOBS                     AS      tipo_observacion,
        a.DOMFICAUS                     AS      auditoria_usuario,
        a.DOMFICAFH                     AS      auditoria_fecha_hora,
        a.DOMFICAIP                     AS      auditoria_ip,

        b.DOMFICCOD                     AS      tipo_estado_codigo,
        b.DOMFICNOM                     AS      tipo_estado_nombre

        FROM sistema.DOMFIC a
        INNER JOIN sistema.DOMFIC b ON a.DOMFICEST = b.DOMFICCOD

        ORDER BY a.DOMFICORD, a.DOMFICNOM";

        try {
            $connPGSQL  = getConnectionPGSQLv1();
            $stmtPGSQL  = $connPGSQL->prepare($sql00);
            $stmtPGSQL->execute([]); 

            while ($rowPGSQL = $stmtPGSQL->fetch()) {
                $detalle    = array(
                    'tipo_codigo'           => $rowPGSQL['tipo_codigo'],
                    'tipo_estado_codigo'    => $rowPGSQL['tipo_estado_codigo'],
                    'tipo_estado_nombre'    => strtoupper(strtolower(trim($rowPGSQL['tipo_estado_nombre']))),
                    'tipo_orden'            => $rowPGSQL['tipo_orden'],
                    'tipo_nombre'           => strtoupper(strtolower(trim($rowPGSQL['tipo_nombre']))),
                    'tipo_equivalente'      => strtoupper(strtolower(trim($rowPGSQL['tipo_equivalente']))),
                    'tipo_dominio'          => strtoupper(strtolower(trim($rowPGSQL['tipo_dominio']))),
                    'tipo_observacion'      => strtoupper(strtolower(trim($rowPGSQL['tipo_observacion']))),
                    'auditoria_usuario'     => strtoupper(strtolower(trim($rowPGSQL['auditoria_usuario']))),
                    'auditoria_fecha_hora'  => $rowPGSQL['auditoria_fecha_hora'],
                    'auditoria_ip'          => strtoupper(strtolower(trim($rowPGSQL['auditoria_ip'])))
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
                    'tipo_orden'            => '',
                    'tipo_nombre'           => '',
                    'tipo_equivalente'      => '',
                    'tipo_dominio'          => '',
                    'tipo_observacion'      => '',
                    'auditoria_usuario'     => '',
                    'auditoria_fecha_hora'  => '',
                    'auditoria_ip'          => ''
                );

                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }

            $stmtPGSQL->closeCursor();
            $stmtPGSQL = null;
        } catch (PDOException $e) {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connPGSQL  = null;
        
        return $json;
    });

    $app->get('/v1/000/codigo/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

		$val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
                a.DOMFICCOD                     AS      tipo_codigo,
                a.DOMFICORD                     AS      tipo_orden,
                a.DOMFICNOM                     AS      tipo_nombre,
                a.DOMFICEQU                     AS      tipo_equivalente,
                a.DOMFICVAL                     AS      tipo_dominio,
                a.DOMFICOBS                     AS      tipo_observacion,
                a.DOMFICAUS                     AS      auditoria_usuario,
                a.DOMFICAFH                     AS      auditoria_fecha_hora,
                a.DOMFICAIP                     AS      auditoria_ip,

                b.DOMFICCOD                     AS      tipo_estado_codigo,
                b.DOMFICNOM                     AS      tipo_estado_nombre

                FROM sistema.DOMFIC a
                INNER JOIN sistema.DOMFIC b ON a.DOMFICEST = b.DOMFICCOD

                WHERE a.DOMFICCOD = ?

                ORDER BY a.DOMFICORD, a.DOMFICNOM";

            try {
                $connPGSQL  = getConnectionPGSQLv1();
                $stmtPGSQL  = $connPGSQL->prepare($sql00);
                $stmtPGSQL->execute([$val01]); 

                while ($rowPGSQL = $stmtPGSQL->fetch()) {
                    $detalle    = array(
                        'tipo_codigo'           => $rowPGSQL['tipo_codigo'],
                        'tipo_estado_codigo'    => $rowPGSQL['tipo_estado_codigo'],
                        'tipo_estado_nombre'    => strtoupper(strtolower(trim($rowPGSQL['tipo_estado_nombre']))),
                        'tipo_orden'            => $rowPGSQL['tipo_orden'],
                        'tipo_nombre'           => strtoupper(strtolower(trim($rowPGSQL['tipo_nombre']))),
                        'tipo_equivalente'      => strtoupper(strtolower(trim($rowPGSQL['tipo_equivalente']))),
                        'tipo_dominio'          => strtoupper(strtolower(trim($rowPGSQL['tipo_dominio']))),
                        'tipo_observacion'      => strtoupper(strtolower(trim($rowPGSQL['tipo_observacion']))),
                        'auditoria_usuario'     => strtoupper(strtolower(trim($rowPGSQL['auditoria_usuario']))),
                        'auditoria_fecha_hora'  => $rowPGSQL['auditoria_fecha_hora'],
                        'auditoria_ip'          => strtoupper(strtolower(trim($rowPGSQL['auditoria_ip'])))
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
                        'tipo_orden'            => '',
                        'tipo_nombre'           => '',
                        'tipo_equivalente'      => '',
                        'tipo_dominio'          => '',
                        'tipo_observacion'      => '',
                        'auditoria_usuario'     => '',
                        'auditoria_fecha_hora'  => '',
                        'auditoria_ip'          => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtPGSQL->closeCursor();
                $stmtPGSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connPGSQL  = null;
        
        return $json;
    });

    $app->get('/v1/000/dominio/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

		$val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
                a.DOMFICCOD                     AS      tipo_codigo,
                a.DOMFICORD                     AS      tipo_orden,
                a.DOMFICNOM                     AS      tipo_nombre,
                a.DOMFICEQU                     AS      tipo_equivalente,
                a.DOMFICVAL                     AS      tipo_dominio,
                a.DOMFICOBS                     AS      tipo_observacion,
                a.DOMFICAUS                     AS      auditoria_usuario,
                a.DOMFICAFH                     AS      auditoria_fecha_hora,
                a.DOMFICAIP                     AS      auditoria_ip,

                b.DOMFICCOD                     AS      tipo_estado_codigo,
                b.DOMFICNOM                     AS      tipo_estado_nombre

                FROM sistema.DOMFIC a
                INNER JOIN sistema.DOMFIC b ON a.DOMFICEST = b.DOMFICCOD

                WHERE a.DOMFICVAL = ?

                ORDER BY a.DOMFICNOM";

            try {
                $connPGSQL  = getConnectionPGSQLv1();
                $stmtPGSQL  = $connPGSQL->prepare($sql00);
                $stmtPGSQL->execute([$val01]); 

                while ($rowPGSQL = $stmtPGSQL->fetch()) {
                    $detalle    = array(
                        'tipo_codigo'           => $rowPGSQL['tipo_codigo'],
                        'tipo_estado_codigo'    => $rowPGSQL['tipo_estado_codigo'],
                        'tipo_estado_nombre'    => strtoupper(strtolower(trim($rowPGSQL['tipo_estado_nombre']))),
                        'tipo_orden'            => $rowPGSQL['tipo_orden'],
                        'tipo_nombre'           => strtoupper(strtolower(trim($rowPGSQL['tipo_nombre']))),
                        'tipo_equivalente'      => strtoupper(strtolower(trim($rowPGSQL['tipo_equivalente']))),
                        'tipo_dominio'          => strtoupper(strtolower(trim($rowPGSQL['tipo_dominio']))),
                        'tipo_observacion'      => strtoupper(strtolower(trim($rowPGSQL['tipo_observacion']))),
                        'auditoria_usuario'     => strtoupper(strtolower(trim($rowPGSQL['auditoria_usuario']))),
                        'auditoria_fecha_hora'  => $rowPGSQL['auditoria_fecha_hora'],
                        'auditoria_ip'          => strtoupper(strtolower(trim($rowPGSQL['auditoria_ip'])))
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
                        'tipo_orden'            => '',
                        'tipo_nombre'           => '',
                        'tipo_equivalente'      => '',
                        'tipo_dominio'          => '',
                        'tipo_observacion'      => '',
                        'auditoria_usuario'     => '',
                        'auditoria_fecha_hora'  => '',
                        'auditoria_ip'          => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtPGSQL->closeCursor();
                $stmtPGSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connPGSQL  = null;
        
        return $json;
    });

    $app->get('/v1/100/colaborador', function($request) {
        require __DIR__.'/../src/connect.php';

        $sql00  = "SELECT
        a.FUNFICCOD         AS          funcionario_codigo,
        a.FUNFICCFU         AS          funcionario_codigo_sistema,
        a.FUNFICNO1         AS          funcionario_nombre_1,
        a.FUNFICNO2         AS          funcionario_nombre_2,
        a.FUNFICAP1         AS          funcionario_apellido_1,
        a.FUNFICAP2         AS          funcionario_apellido_2,
        a.FUNFICAP3         AS          funcionario_apellido_3,
        a.FUNFICFNA         AS          funcionario_fecha_nacimiento_1,
        a.FUNFICEMA         AS          funcionario_email,
        a.FUNFICFOT         AS          funcionario_foto,
        a.FUNFICOBS         AS          funcionario_observacion,
        a.FUNFICAUS         AS          auditoria_usuario,
        a.FUNFICAFH         AS          auditoria_fecha_hora,
        a.FUNFICAIP         AS          auditoria_ip,

        b.DOMFICCOD         AS          tipo_estado_codigo,
        b.DOMFICNOM         AS          tipo_estado_nombre,

        c.DOMFICCOD         AS          tipo_documento_codigo,
        c.DOMFICNOM         AS          tipo_documento_nombre,
        a.FUNFICDNU         AS          tipo_documento_numero,
        a.FUNFICDVE         AS          tipo_documento_vencimiento_1,

        d.DOMFICCOD         AS          tipo_sexo_codigo,
        d.DOMFICNOM         AS          tipo_sexo_nombre,

        e.DOMFICCOD         AS          tipo_estado_civil_codigo,
        e.DOMFICNOM         AS          tipo_estado_civil_nombre,

        f.LOCPAICOD         AS          pais_codigo,
        f.LOCPAINOM         AS          pais_nombre,
        f.LOCPAIGEN         AS          pais_gentilicio

        FROM sistema.FUNFIC a
        INNER JOIN sistema.DOMFIC b ON a.FUNFICEST = b.DOMFICCOD
        INNER JOIN sistema.DOMFIC c ON a.FUNFICTDC = c.DOMFICCOD
        INNER JOIN sistema.DOMFIC d ON a.FUNFICTSC = d.DOMFICCOD
        INNER JOIN sistema.DOMFIC e ON a.FUNFICECC = e.DOMFICCOD
        INNER JOIN sistema.LOCPAI f ON a.FUNFICNAC = f.LOCPAICOD
        
        ORDER BY a.FUNFICCOD";

        try {
            $connPGSQL  = getConnectionPGSQLv1();
            $stmtPGSQL  = $connPGSQL->prepare($sql00);
            $stmtPGSQL->execute(); 

            while ($rowPGSQL = $stmtPGSQL->fetch()) {
                $detalle    = array(
                    'funcionario_codigo'                => $rowPGSQL['funcionario_codigo'],
                    'funcionario_codigo_sistema'        => $rowPGSQL['funcionario_codigo_sistema'],
                    'funcionario_nombre_completo'       => strtoupper(strtolower(trim($rowPGSQL['funcionario_nombre_1']))).' '.strtoupper(strtolower(trim($rowPGSQL['funcionario_nombre_2']))).' '.strtoupper(strtolower(trim($rowPGSQL['funcionario_apellido_1']))).' '.strtoupper(strtolower(trim($rowPGSQL['funcionario_apellido_2']))),
                    'funcionario_nombre_1'              => strtoupper(strtolower(trim($rowPGSQL['funcionario_nombre_1']))),
                    'funcionario_nombre_2'              => strtoupper(strtolower(trim($rowPGSQL['funcionario_nombre_2']))),
                    'funcionario_apellido_1'            => strtoupper(strtolower(trim($rowPGSQL['funcionario_apellido_1']))),
                    'funcionario_apellido_2'            => strtoupper(strtolower(trim($rowPGSQL['funcionario_apellido_2']))),
                    'funcionario_apellido_3'            => strtoupper(strtolower(trim($rowPGSQL['funcionario_apellido_3']))),
                    'funcionario_fecha_nacimiento_1'    => $rowPGSQL['funcionario_fecha_nacimiento_1'],
                    'funcionario_fecha_nacimiento_2'    => date("d/m/Y", strtotime($rowPGSQL['funcionario_fecha_nacimiento_1'])),
                    'funcionario_email'                 => strtolower(trim($rowPGSQL['funcionario_email'])),
                    'funcionario_foto'                  => strtolower(trim($rowPGSQL['funcionario_foto'])),
                    'funcionario_observacion'           => strtoupper(strtolower(trim($rowPGSQL['funcionario_observacion']))),
                    'auditoria_usuario'                 => strtoupper(strtolower(trim($rowPGSQL['auditoria_usuario']))),
                    'auditoria_fecha_hora'              => $rowPGSQL['auditoria_fecha_hora'],
                    'auditoria_ip'                      => strtoupper(strtolower(trim($rowPGSQL['auditoria_ip']))),

                    'tipo_estado_codigo'                => $rowPGSQL['tipo_estado_codigo'],
                    'tipo_estado_nombre'                => strtoupper(strtolower(trim($rowPGSQL['tipo_estado_nombre']))),

                    'tipo_documento_codigo'             => $rowPGSQL['tipo_documento_codigo'],
                    'tipo_documento_nombre'             => strtoupper(strtolower(trim($rowPGSQL['tipo_documento_nombre']))),
                    'tipo_documento_numero'             => strtoupper(strtolower(trim($rowPGSQL['tipo_documento_numero']))),
                    'tipo_documento_vencimiento_1'      => $rowPGSQL['tipo_documento_vencimiento_1'],
                    'tipo_documento_vencimiento_2'      => date("d/m/Y", strtotime($rowPGSQL['tipo_documento_vencimiento_1'])),

                    'tipo_sexo_codigo'                  => $rowPGSQL['tipo_sexo_codigo'],
                    'tipo_sexo_nombre'                  => strtoupper(strtolower(trim($rowPGSQL['tipo_sexo_nombre']))),

                    'tipo_estado_civil_codigo'          => $rowPGSQL['tipo_estado_civil_codigo'],
                    'tipo_estado_civil_nombre'          => strtoupper(strtolower(trim($rowPGSQL['tipo_estado_civil_nombre']))),

                    'pais_codigo'                       => $rowPGSQL['pais_codigo'],
                    'pais_nombre'                       => strtoupper(strtolower(trim($rowPGSQL['pais_nombre']))),
                    'pais_gentilicio'                   => strtoupper(strtolower(trim($rowPGSQL['pais_gentilicio'])))
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle = array(
                    'funcionario_codigo'                => '',
                    'funcionario_codigo_sistema'        => '',
                    'funcionario_nombre_completo'       => '',
                    'funcionario_nombre_1'              => '',
                    'funcionario_nombre_2'              => '',
                    'funcionario_apellido_1'            => '',
                    'funcionario_apellido_2'            => '',
                    'funcionario_apellido_3'            => '',
                    'funcionario_fecha_nacimiento_1'    => '',
                    'funcionario_fecha_nacimiento_2'    => '',
                    'funcionario_email'                 => '',
                    'funcionario_foto'                  => '',
                    'funcionario_observacion'           => '',
                    'auditoria_usuario'                 => '',
                    'auditoria_fecha_hora'              => '',
                    'auditoria_ip'                      => '',
                    'tipo_estado_codigo'                => '',
                    'tipo_estado_nombre'                => '',
                    'tipo_documento_codigo'             => '',
                    'tipo_documento_nombre'             => '',
                    'tipo_documento_numero'             => '',
                    'tipo_documento_vencimiento_1'      => '',
                    'tipo_documento_vencimiento_2'      => '',
                    'tipo_sexo_codigo'                  => '',
                    'tipo_sexo_nombre'                  => '',
                    'tipo_estado_civil_codigo'          => '',
                    'tipo_estado_civil_nombre'          => '',
                    'pais_codigo'                       => '',
                    'pais_nombre'                       => '',
                    'pais_gentilicio'                   => ''
                );

                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }

            $stmtPGSQL->closeCursor();
            $stmtPGSQL = null;
        } catch (PDOException $e) {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connPGSQL  = null;
        
        return $json;
    });

    $app->get('/v1/100/colaborador/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        $val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.FUNFICCOD         AS          funcionario_codigo,
            a.FUNFICCFU         AS          funcionario_codigo_sistema,
            a.FUNFICNO1         AS          funcionario_nombre_1,
            a.FUNFICNO2         AS          funcionario_nombre_2,
            a.FUNFICAP1         AS          funcionario_apellido_1,
            a.FUNFICAP2         AS          funcionario_apellido_2,
            a.FUNFICAP3         AS          funcionario_apellido_3,
            a.FUNFICFNA         AS          funcionario_fecha_nacimiento_1,
            a.FUNFICEMA         AS          funcionario_email,
            a.FUNFICFOT         AS          funcionario_foto,
            a.FUNFICOBS         AS          funcionario_observacion,
            a.FUNFICAUS         AS          auditoria_usuario,
            a.FUNFICAFH         AS          auditoria_fecha_hora,
            a.FUNFICAIP         AS          auditoria_ip,

            b.DOMFICCOD         AS          tipo_estado_codigo,
            b.DOMFICNOM         AS          tipo_estado_nombre,

            c.DOMFICCOD         AS          tipo_documento_codigo,
            c.DOMFICNOM         AS          tipo_documento_nombre,
            a.FUNFICDNU         AS          tipo_documento_numero,
            a.FUNFICDVE         AS          tipo_documento_vencimiento_1,

            d.DOMFICCOD         AS          tipo_sexo_codigo,
            d.DOMFICNOM         AS          tipo_sexo_nombre,

            e.DOMFICCOD         AS          tipo_estado_civil_codigo,
            e.DOMFICNOM         AS          tipo_estado_civil_nombre,

            f.LOCPAICOD         AS          pais_codigo,
            f.LOCPAINOM         AS          pais_nombre,
            f.LOCPAIGEN         AS          pais_gentilicio

            FROM sistema.FUNFIC a
            INNER JOIN sistema.DOMFIC b ON a.FUNFICEST = b.DOMFICCOD
            INNER JOIN sistema.DOMFIC c ON a.FUNFICTDC = c.DOMFICCOD
            INNER JOIN sistema.DOMFIC d ON a.FUNFICTSC = d.DOMFICCOD
            INNER JOIN sistema.DOMFIC e ON a.FUNFICECC = e.DOMFICCOD
            INNER JOIN sistema.LOCPAI f ON a.FUNFICNAC = f.LOCPAICOD
            
            WHERE a.FUNFICCOD = ?

            ORDER BY a.FUNFICCOD";

            try {
                $connPGSQL  = getConnectionPGSQLv1();
                $stmtPGSQL  = $connPGSQL->prepare($sql00);
                $stmtPGSQL->execute([$val01]); 

                while ($rowPGSQL = $stmtPGSQL->fetch()) {
                    $detalle    = array(
                        'funcionario_codigo'                => $rowPGSQL['funcionario_codigo'],
                        'funcionario_codigo_sistema'        => $rowPGSQL['funcionario_codigo_sistema'],
                        'funcionario_nombre_completo'       => strtoupper(strtolower(trim($rowPGSQL['funcionario_nombre_1']))).' '.strtoupper(strtolower(trim($rowPGSQL['funcionario_nombre_2']))).' '.strtoupper(strtolower(trim($rowPGSQL['funcionario_apellido_1']))).' '.strtoupper(strtolower(trim($rowPGSQL['funcionario_apellido_2']))),
                        'funcionario_nombre_1'              => strtoupper(strtolower(trim($rowPGSQL['funcionario_nombre_1']))),
                        'funcionario_nombre_2'              => strtoupper(strtolower(trim($rowPGSQL['funcionario_nombre_2']))),
                        'funcionario_apellido_1'            => strtoupper(strtolower(trim($rowPGSQL['funcionario_apellido_1']))),
                        'funcionario_apellido_2'            => strtoupper(strtolower(trim($rowPGSQL['funcionario_apellido_2']))),
                        'funcionario_apellido_3'            => strtoupper(strtolower(trim($rowPGSQL['funcionario_apellido_3']))),
                        'funcionario_fecha_nacimiento_1'    => $rowPGSQL['funcionario_fecha_nacimiento_1'],
                        'funcionario_fecha_nacimiento_2'    => date("d/m/Y", strtotime($rowPGSQL['funcionario_fecha_nacimiento_1'])),
                        'funcionario_email'                 => strtolower(trim($rowPGSQL['funcionario_email'])),
                        'funcionario_foto'                  => strtolower(trim($rowPGSQL['funcionario_foto'])),
                        'funcionario_observacion'           => strtoupper(strtolower(trim($rowPGSQL['funcionario_observacion']))),
                        'auditoria_usuario'                 => strtoupper(strtolower(trim($rowPGSQL['auditoria_usuario']))),
                        'auditoria_fecha_hora'              => $rowPGSQL['auditoria_fecha_hora'],
                        'auditoria_ip'                      => strtoupper(strtolower(trim($rowPGSQL['auditoria_ip']))),

                        'tipo_estado_codigo'                => $rowPGSQL['tipo_estado_codigo'],
                        'tipo_estado_nombre'                => strtoupper(strtolower(trim($rowPGSQL['tipo_estado_nombre']))),

                        'tipo_documento_codigo'             => $rowPGSQL['tipo_documento_codigo'],
                        'tipo_documento_nombre'             => strtoupper(strtolower(trim($rowPGSQL['tipo_documento_nombre']))),
                        'tipo_documento_numero'             => strtoupper(strtolower(trim($rowPGSQL['tipo_documento_numero']))),
                        'tipo_documento_vencimiento_1'      => $rowPGSQL['tipo_documento_vencimiento_1'],
                        'tipo_documento_vencimiento_2'      => date("d/m/Y", strtotime($rowPGSQL['tipo_documento_vencimiento_1'])),

                        'tipo_sexo_codigo'                  => $rowPGSQL['tipo_sexo_codigo'],
                        'tipo_sexo_nombre'                  => strtoupper(strtolower(trim($rowPGSQL['tipo_sexo_nombre']))),

                        'tipo_estado_civil_codigo'          => $rowPGSQL['tipo_estado_civil_codigo'],
                        'tipo_estado_civil_nombre'          => strtoupper(strtolower(trim($rowPGSQL['tipo_estado_civil_nombre']))),

                        'pais_codigo'                       => $rowPGSQL['pais_codigo'],
                        'pais_nombre'                       => strtoupper(strtolower(trim($rowPGSQL['pais_nombre']))),
                        'pais_gentilicio'                   => strtoupper(strtolower(trim($rowPGSQL['pais_gentilicio'])))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'funcionario_codigo'                => '',
                        'funcionario_codigo_sistema'        => '',
                        'funcionario_nombre_completo'       => '',
                        'funcionario_nombre_1'              => '',
                        'funcionario_nombre_2'              => '',
                        'funcionario_apellido_1'            => '',
                        'funcionario_apellido_2'            => '',
                        'funcionario_apellido_3'            => '',
                        'funcionario_fecha_nacimiento_1'    => '',
                        'funcionario_fecha_nacimiento_2'    => '',
                        'funcionario_email'                 => '',
                        'funcionario_foto'                  => '',
                        'funcionario_observacion'           => '',
                        'auditoria_usuario'                 => '',
                        'auditoria_fecha_hora'              => '',
                        'auditoria_ip'                      => '',
                        'tipo_estado_codigo'                => '',
                        'tipo_estado_nombre'                => '',
                        'tipo_documento_codigo'             => '',
                        'tipo_documento_nombre'             => '',
                        'tipo_documento_numero'             => '',
                        'tipo_documento_vencimiento_1'      => '',
                        'tipo_documento_vencimiento_2'      => '',
                        'tipo_sexo_codigo'                  => '',
                        'tipo_sexo_nombre'                  => '',
                        'tipo_estado_civil_codigo'          => '',
                        'tipo_estado_civil_nombre'          => '',
                        'pais_codigo'                       => '',
                        'pais_nombre'                       => '',
                        'pais_gentilicio'                   => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtPGSQL->closeCursor();
                $stmtPGSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connPGSQL  = null;
        
        return $json;
    });

    $app->get('/v1/100/estadocivil', function($request) {
        require __DIR__.'/../src/connect.php';

        $sql00  = "SELECT
        a.FUNFICECC                     AS      funcionario_estado_civil_codigo,
        a.FUNFICTSC                     AS      funcionario_sexo_codigo,
        b.DOMFICNOM                     AS      funcionario_estado_civil_nombre,
        c.DOMFICNOM                     AS      funcionario_sexo_nombre,
        COUNT(*)                        AS      funcionario_cantidad
        
        FROM sistema.FUNFIC a
        INNER JOIN sistema.DOMFIC b ON a.FUNFICECC = b.DOMFICCOD
        INNER JOIN sistema.DOMFIC c ON a.FUNFICTSC = c.DOMFICCOD

        WHERE a.FUNFICEST = (SELECT DOMFICCOD FROM sistema.DOMFIC WHERE DOMFICVAL = 'COLABORADORESTADO' AND DOMFICEQU = 'A')
        
        GROUP BY a.FUNFICECC, a.FUNFICTSC, b.DOMFICNOM, c.DOMFICNOM
        ORDER BY a.FUNFICECC, a.FUNFICTSC, b.DOMFICNOM, c.DOMFICNOM";

        try {
            $connPGSQL  = getConnectionPGSQLv1();
            $stmtPGSQL  = $connPGSQL->prepare($sql00);
            $stmtPGSQL->execute(); 

            while ($rowPGSQL = $stmtPGSQL->fetch()) {
                $detalle    = array(
                    'funcionario_estado_civil_codigo'   => $rowPGSQL['funcionario_estado_civil_codigo'],
                    'funcionario_estado_civil_nombre'   => $rowPGSQL['funcionario_estado_civil_nombre'],
                    'funcionario_sexo_codigo'           => $rowPGSQL['funcionario_sexo_codigo'],
                    'funcionario_sexo_nombre'           => $rowPGSQL['funcionario_sexo_nombre'],
                    'funcionario_cantidad'              => $rowPGSQL['funcionario_cantidad']
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

            $stmtPGSQL->closeCursor();
            $stmtPGSQL = null;
        } catch (PDOException $e) {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connPGSQL  = null;
        
        return $json;
    });

    $app->get('/v1/100/cumpleanho', function($request) {
        require __DIR__.'/../src/connect.php';

        $sql00  = "SELECT
		EXTRACT(MONTH FROM FUNFICFNA)::INTEGER  AS      funcionario_mes_codigo,
        COUNT(*)                                AS      funcionario_mes_cantidad
        
        FROM sistema.FUNFIC a

        WHERE a.FUNFICEST = (SELECT DOMFICCOD FROM sistema.DOMFIC WHERE DOMFICVAL = 'COLABORADORESTADO' AND DOMFICEQU = 'A')
        
        GROUP BY EXTRACT(MONTH FROM FUNFICFNA)::INTEGER
        ORDER BY EXTRACT(MONTH FROM FUNFICFNA)::INTEGER";

        try {
            $connPGSQL  = getConnectionPGSQLv1();
            $stmtPGSQL  = $connPGSQL->prepare($sql00);
            $stmtPGSQL->execute(); 

            while ($rowPGSQL = $stmtPGSQL->fetch()) {
                switch ($rowPGSQL['funcionario_mes_codigo']) {
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
                    'funcionario_mes_codigo'    => $rowPGSQL['funcionario_mes_codigo'],
                    'funcionario_mes_nombre'    => $funcionario_mes_nombre,
                    'funcionario_mes_cantidad'  => $rowPGSQL['funcionario_mes_cantidad']
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

            $stmtPGSQL->closeCursor();
            $stmtPGSQL = null;
        } catch (PDOException $e) {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connPGSQL  = null;
        
        return $json;
    });

    $app->get('/v1/400/sistema', function($request) {
        require __DIR__.'/../src/connect.php';

        $sql00  = "SELECT
            a.LOGFICCOD                     AS      sistema_codigo,
            a.LOGFICNOM                     AS      sistema_nombre,
            a.LOGFICURL                     AS      sistema_link,
            a.LOGFICOBS                     AS      sistema_observacion,
            a.LOGFICAUS                     AS      auditoria_usuario,
            a.LOGFICAFH                     AS      auditoria_fecha_hora,
            a.LOGFICAIP                     AS      auditoria_ip,

            b.DOMFICCOD                     AS      tipo_estado_codigo,
            b.DOMFICNOM                     AS      tipo_estado_nombre,

            c.DOMFICCOD                     AS      tipo_conexion_codigo,
            c.DOMFICNOM                     AS      tipo_conexion_nombre

            FROM sistema.LOGFIC a
            INNER JOIN sistema.DOMFIC b ON a.LOGFICEST = b.DOMFICCOD
            INNER JOIN sistema.DOMFIC c ON a.LOGFICTCC = c.DOMFICCOD

            ORDER BY a.LOGFICCOD";

        try {
            $connPGSQL  = getConnectionPGSQLv1();
            $stmtPGSQL  = $connPGSQL->prepare($sql00);
            $stmtPGSQL->execute(); 

            while ($rowPGSQL = $stmtPGSQL->fetch()) {
                $detalle    = array(
                    'sistema_codigo'            => $rowPGSQL['sistema_codigo'],
                    'tipo_estado_codigo'        => $rowPGSQL['tipo_estado_codigo'],
                    'tipo_estado_nombre'        => strtoupper(strtolower(trim($rowPGSQL['tipo_estado_nombre']))),
                    'tipo_conexion_codigo'      => $rowPGSQL['tipo_conexion_codigo'],
                    'tipo_conexion_nombre'      => strtoupper(strtolower(trim($rowPGSQL['tipo_conexion_nombre']))),
                    'sistema_nombre'            => strtoupper(strtolower(trim($rowPGSQL['sistema_nombre']))),
                    'sistema_link'              => strtolower(trim($rowPGSQL['sistema_link'])),
                    'sistema_observacion'       => strtoupper(strtolower(trim($rowPGSQL['sistema_observacion']))),
                    'auditoria_usuario'         => strtoupper(strtolower(trim($rowPGSQL['auditoria_usuario']))),
                    'auditoria_fecha_hora'      => $rowPGSQL['auditoria_fecha_hora'],
                    'auditoria_ip'              => strtoupper(strtolower(trim($rowPGSQL['auditoria_ip'])))
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle = array(
                    'sistema_codigo'            => '',
                    'tipo_estado_codigo'        => '',
                    'tipo_estado_nombre'        => '',
                    'tipo_conexion_codigo'      => '',
                    'tipo_conexion_nombre'      => '',
                    'sistema_nombre'            => '',
                    'sistema_link'              => '',
                    'sistema_observacion'       => '',
                    'auditoria_usuario'         => '',
                    'auditoria_fecha_hora'      => '',
                    'auditoria_ip'              => ''
                );

                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }

            $stmtPGSQL->closeCursor();
            $stmtPGSQL = null;
        } catch (PDOException $e) {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connPGSQL  = null;
        
        return $json;
    });

    $app->get('/v1/400/sistema/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

		$val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
                a.LOGFICCOD                     AS      sistema_codigo,
                a.LOGFICNOM                     AS      sistema_nombre,
                a.LOGFICURL                     AS      sistema_link,
                a.LOGFICOBS                     AS      sistema_observacion,
                a.LOGFICAUS                     AS      auditoria_usuario,
                a.LOGFICAFH                     AS      auditoria_fecha_hora,
                a.LOGFICAIP                     AS      auditoria_ip,

                b.DOMFICCOD                     AS      tipo_estado_codigo,
                b.DOMFICNOM                     AS      tipo_estado_nombre,

                c.DOMFICCOD                     AS      tipo_conexion_codigo,
                c.DOMFICNOM                     AS      tipo_conexion_nombre

                FROM sistema.LOGFIC a
                INNER JOIN sistema.DOMFIC b ON a.LOGFICEST = b.DOMFICCOD
                INNER JOIN sistema.DOMFIC c ON a.LOGFICTCC = c.DOMFICCOD

                WHERE a.LOGFICCOD = ?

                ORDER BY a.LOGFICCOD";

            try {
                $connPGSQL  = getConnectionPGSQLv1();
                $stmtPGSQL  = $connPGSQL->prepare($sql00);
                $stmtPGSQL->execute([$val01]); 

                while ($rowPGSQL = $stmtPGSQL->fetch()) {
                    $detalle    = array(
                        'sistema_codigo'            => $rowPGSQL['sistema_codigo'],
                        'tipo_estado_codigo'        => $rowPGSQL['tipo_estado_codigo'],
                        'tipo_estado_nombre'        => strtoupper(strtolower(trim($rowPGSQL['tipo_estado_nombre']))),
                        'tipo_conexion_codigo'      => $rowPGSQL['tipo_conexion_codigo'],
                        'tipo_conexion_nombre'      => strtoupper(strtolower(trim($rowPGSQL['tipo_conexion_nombre']))),
                        'sistema_nombre'            => strtoupper(strtolower(trim($rowPGSQL['sistema_nombre']))),
                        'sistema_link'              => strtolower(trim($rowPGSQL['sistema_link'])),
                        'sistema_observacion'       => strtoupper(strtolower(trim($rowPGSQL['sistema_observacion']))),
                        'auditoria_usuario'         => strtoupper(strtolower(trim($rowPGSQL['auditoria_usuario']))),
                        'auditoria_fecha_hora'      => $rowPGSQL['auditoria_fecha_hora'],
                        'auditoria_ip'              => strtoupper(strtolower(trim($rowPGSQL['auditoria_ip'])))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'sistema_codigo'            => '',
                        'tipo_estado_codigo'        => '',
                        'tipo_estado_nombre'        => '',
                        'tipo_conexion_codigo'      => '',
                        'tipo_conexion_nombre'      => '',
                        'sistema_nombre'            => '',
                        'sistema_link'              => '',
                        'sistema_observacion'       => '',
                        'auditoria_usuario'         => '',
                        'auditoria_fecha_hora'      => '',
                        'auditoria_ip'              => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtPGSQL->closeCursor();
                $stmtPGSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connPGSQL  = null;
        
        return $json;
    });

    $app->get('/v1/400/colaborador', function($request) {
        require __DIR__.'/../src/connect.php';

        $sql00  = "SELECT
            a.LOGFUNCOD         AS          sistema_colaborador_codigo,
            a.LOGFUNDIP         AS          sistema_colaborador_direccion_ip,
            a.LOGFUNOBS         AS          sistema_colaborador_observacion,
            a.LOGFUNAUS         AS          auditoria_usuario,
            a.LOGFUNAFH         AS          auditoria_fecha_hora,
            a.LOGFUNAIP         AS          auditoria_ip,

            b.DOMFICCOD         AS          tipo_estado_codigo,
            b.DOMFICNOM         AS          tipo_estado_nombre,

            c.FUNFICCOD         AS          funcionario_codigo,
            c.FUNFICCFU         AS          funcionario_codigo_sistema,
            c.FUNFICNO1         AS          funcionario_nombre_1,
            c.FUNFICNO2         AS          funcionario_nombre_2,
            c.FUNFICAP1         AS          funcionario_apellido_1,
            c.FUNFICAP2         AS          funcionario_apellido_2,
            c.FUNFICAP3         AS          funcionario_apellido_3,
            c.FUNFICDNU         AS          funcionario_documento_numero,
            c.FUNFICFOT         AS          funcionario_foto

            FROM sistema.LOGFUN a
            INNER JOIN sistema.DOMFIC b ON a.LOGFUNEST = b.DOMFICCOD
            INNER JOIN sistema.FUNFIC c ON a.LOGFUNFUC = c.FUNFICCOD

            ORDER BY a.LOGFUNCOD";

        try {
            $connPGSQL  = getConnectionPGSQLv1();
            $stmtPGSQL  = $connPGSQL->prepare($sql00);
            $stmtPGSQL->execute(); 

            while ($rowPGSQL = $stmtPGSQL->fetch()) {
                $detalle    = array(
                    'sistema_colaborador_codigo'        => $rowPGSQL['sistema_colaborador_codigo'],
                    'tipo_estado_codigo'                => $rowPGSQL['tipo_estado_codigo'],
                    'tipo_estado_nombre'                => strtoupper(strtolower(trim($rowPGSQL['tipo_estado_nombre']))),
                    'sistema_colaborador_direccion_ip'  => strtoupper(strtolower(trim($rowPGSQL['sistema_colaborador_direccion_ip']))),
                    'sistema_colaborador_observacion'   => strtoupper(strtolower(trim($rowPGSQL['sistema_colaborador_observacion']))),
                    'funcionario_codigo'                => $rowPGSQL['funcionario_codigo'],
                    'funcionario_codigo_sistema'        => $rowPGSQL['funcionario_codigo_sistema'],
                    'funcionario_nombre_completo'       => strtoupper(strtolower(trim($rowPGSQL['funcionario_nombre_1']))).' '.strtoupper(strtolower(trim($rowPGSQL['funcionario_nombre_2']))).' '.strtoupper(strtolower(trim($rowPGSQL['funcionario_apellido_1']))).' '.strtoupper(strtolower(trim($rowPGSQL['funcionario_apellido_2']))),
                    'funcionario_documento_numero'      => strtoupper(strtolower(trim($rowPGSQL['funcionario_documento_numero']))),
                    'funcionario_foto'                  => strtolower(trim($rowPGSQL['funcionario_foto'])),
                    'auditoria_usuario'                 => strtoupper(strtolower(trim($rowPGSQL['auditoria_usuario']))),
                    'auditoria_fecha_hora'              => $rowPGSQL['auditoria_fecha_hora'],
                    'auditoria_ip'                      => strtoupper(strtolower(trim($rowPGSQL['auditoria_ip'])))
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle = array(
                    'sistema_colaborador_codigo'        => '',
                    'tipo_estado_codigo'                => '',
                    'tipo_estado_nombre'                => '',
                    'sistema_colaborador_direccion_ip'  => '',
                    'sistema_colaborador_observacion'   => '',
                    'funcionario_codigo'                => '',
                    'funcionario_codigo_sistema'        => '',
                    'funcionario_nombre_completo'       => '',
                    'funcionario_documento_numero'      => '',
                    'funcionario_foto'                  => '',
                    'auditoria_usuario'                 => '',
                    'auditoria_fecha_hora'              => '',
                    'auditoria_ip'                      => ''
                );

                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }

            $stmtPGSQL->closeCursor();
            $stmtPGSQL = null;
        } catch (PDOException $e) {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connPGSQL  = null;
        
        return $json;
    });

    $app->get('/v1/400/colaborador/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

		$val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
                a.LOGFUNCOD         AS          sistema_colaborador_codigo,
                a.LOGFUNDIP         AS          sistema_colaborador_direccion_ip,
                a.LOGFUNOBS         AS          sistema_colaborador_observacion,
                a.LOGFUNAUS         AS          auditoria_usuario,
                a.LOGFUNAFH         AS          auditoria_fecha_hora,
                a.LOGFUNAIP         AS          auditoria_ip,

                b.DOMFICCOD         AS          tipo_estado_codigo,
                b.DOMFICNOM         AS          tipo_estado_nombre,

                c.FUNFICCOD         AS          funcionario_codigo,
                c.FUNFICCFU         AS          funcionario_codigo_sistema,
                c.FUNFICNO1         AS          funcionario_nombre_1,
                c.FUNFICNO2         AS          funcionario_nombre_2,
                c.FUNFICAP1         AS          funcionario_apellido_1,
                c.FUNFICAP2         AS          funcionario_apellido_2,
                c.FUNFICAP3         AS          funcionario_apellido_3,
                c.FUNFICDNU         AS          funcionario_documento_numero,
                c.FUNFICFOT         AS          funcionario_foto

                FROM sistema.LOGFUN a
                INNER JOIN sistema.DOMFIC b ON a.LOGFUNEST = b.DOMFICCOD
                INNER JOIN sistema.FUNFIC c ON a.LOGFUNFUC = c.FUNFICCOD

                WHERE a.LOGFUNCOD = ?

                ORDER BY a.LOGFUNCOD";

            try {
                $connPGSQL  = getConnectionPGSQLv1();
                $stmtPGSQL  = $connPGSQL->prepare($sql00);
                $stmtPGSQL->execute([$val01]); 

                while ($rowPGSQL = $stmtPGSQL->fetch()) {
                    $detalle    = array(
                        'sistema_colaborador_codigo'        => $rowPGSQL['sistema_colaborador_codigo'],
                        'tipo_estado_codigo'                => $rowPGSQL['tipo_estado_codigo'],
                        'tipo_estado_nombre'                => strtoupper(strtolower(trim($rowPGSQL['tipo_estado_nombre']))),
                        'sistema_colaborador_direccion_ip'  => strtoupper(strtolower(trim($rowPGSQL['sistema_colaborador_direccion_ip']))),
                        'sistema_colaborador_observacion'   => strtoupper(strtolower(trim($rowPGSQL['sistema_colaborador_observacion']))),
                        'funcionario_codigo'                => $rowPGSQL['funcionario_codigo'],
                        'funcionario_codigo_sistema'        => $rowPGSQL['funcionario_codigo_sistema'],
                        'funcionario_nombre_completo'       => strtoupper(strtolower(trim($rowPGSQL['funcionario_nombre_1']))).' '.strtoupper(strtolower(trim($rowPGSQL['funcionario_nombre_2']))).' '.strtoupper(strtolower(trim($rowPGSQL['funcionario_apellido_1']))).' '.strtoupper(strtolower(trim($rowPGSQL['funcionario_apellido_2']))),
                        'funcionario_documento_numero'      => strtoupper(strtolower(trim($rowPGSQL['funcionario_documento_numero']))),
                        'funcionario_foto'                  => strtolower(trim($rowPGSQL['funcionario_foto'])),
                        'auditoria_usuario'                 => strtoupper(strtolower(trim($rowPGSQL['auditoria_usuario']))),
                        'auditoria_fecha_hora'              => $rowPGSQL['auditoria_fecha_hora'],
                        'auditoria_ip'                      => strtoupper(strtolower(trim($rowPGSQL['auditoria_ip'])))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'sistema_colaborador_codigo'        => '',
                        'tipo_estado_codigo'                => '',
                        'tipo_estado_nombre'                => '',
                        'sistema_colaborador_direccion_ip'  => '',
                        'sistema_colaborador_observacion'   => '',
                        'funcionario_codigo'                => '',
                        'funcionario_codigo_sistema'        => '',
                        'funcionario_nombre_completo'       => '',
                        'funcionario_documento_numero'      => '',
                        'funcionario_foto'                  => '',
                        'auditoria_usuario'                 => '',
                        'auditoria_fecha_hora'              => '',
                        'auditoria_ip'                      => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtPGSQL->closeCursor();
                $stmtPGSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connPGSQL  = null;
        
        return $json;
    });

    $app->get('/v1/100', function($request) {
        require __DIR__.'/../src/connect.php';

        $sql00  = "SELECT
        a.CAMFICCOD                     AS      campanha_codigo,
        a.CAMFICNOM                     AS      campanha_nombre,
        a.CAMFICFDE                     AS      campanha_fecha_inicio,
        a.CAMFICFHA                     AS      campanha_fecha_final,
        a.CAMFICCOL                     AS      campanha_color,
        a.CAMFICFO1                     AS      campanha_formulario_1,
        a.CAMFICFO2                     AS      campanha_formulario_2,
        a.CAMFICFO3                     AS      campanha_formulario_3,
        a.CAMFICFO4                     AS      campanha_formulario_4,
        a.CAMFICFO5                     AS      campanha_formulario_5,
        a.CAMFICFO6                     AS      campanha_formulario_6,
        a.CAMFICFO7                     AS      campanha_formulario_7,
        a.CAMFICFO8                     AS      campanha_formulario_8,
        a.CAMFICFO9                     AS      campanha_formulario_9,
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

                if($rowMYSQL['campanha_formulario_9'] === 'S'){
                    $campanha_formulario_9 = 'checked';
                } else {
                    $campanha_formulario_9 = '';
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
                    'campanha_color'            => $rowMYSQL['campanha_color'],
                    'campanha_formulario_1'     => $campanha_formulario_1,
                    'campanha_formulario_2'     => $campanha_formulario_2,
                    'campanha_formulario_3'     => $campanha_formulario_3,
                    'campanha_formulario_4'     => $campanha_formulario_4,
                    'campanha_formulario_5'     => $campanha_formulario_5,
                    'campanha_formulario_6'     => $campanha_formulario_6,
                    'campanha_formulario_7'     => $campanha_formulario_7,
                    'campanha_formulario_8'     => $campanha_formulario_8,
                    'campanha_formulario_9'     => $campanha_formulario_9,
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
                    'campanha_color'            => '',
                    'campanha_formulario_1'     => '',
                    'campanha_formulario_2'     => '',
                    'campanha_formulario_3'     => '',
                    'campanha_formulario_4'     => '',
                    'campanha_formulario_5'     => '',
                    'campanha_formulario_6'     => '',
                    'campanha_formulario_7'     => '',
                    'campanha_formulario_8'     => '',
                    'campanha_formulario_9'     => '',
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

    $app->get('/v1/100/campanha/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getAttribute('codigo');

        if (isset($val01)) {
            $sql00  = "SELECT
            a.CAMFICCOD                     AS      campanha_codigo,
            a.CAMFICNOM                     AS      campanha_nombre,
            a.CAMFICFDE                     AS      campanha_fecha_inicio,
            a.CAMFICFHA                     AS      campanha_fecha_final,
            a.CAMFICCOL                     AS      campanha_color,
            a.CAMFICFO1                     AS      campanha_formulario_1,
            a.CAMFICFO2                     AS      campanha_formulario_2,
            a.CAMFICFO3                     AS      campanha_formulario_3,
            a.CAMFICFO4                     AS      campanha_formulario_4,
            a.CAMFICFO5                     AS      campanha_formulario_5,
            a.CAMFICFO6                     AS      campanha_formulario_6,
            a.CAMFICFO7                     AS      campanha_formulario_7,
            a.CAMFICFO8                     AS      campanha_formulario_8,
            a.CAMFICFO9                     AS      campanha_formulario_9,
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

                    if($rowMYSQL['campanha_formulario_9'] === 'S'){
                        $campanha_formulario_9 = 'checked';
                    } else {
                        $campanha_formulario_9 = '';
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
                        'campanha_color'            => $rowMYSQL['campanha_color'],
                        'campanha_formulario_1'     => $campanha_formulario_1,
                        'campanha_formulario_2'     => $campanha_formulario_2,
                        'campanha_formulario_3'     => $campanha_formulario_3,
                        'campanha_formulario_4'     => $campanha_formulario_4,
                        'campanha_formulario_5'     => $campanha_formulario_5,
                        'campanha_formulario_6'     => $campanha_formulario_6,
                        'campanha_formulario_7'     => $campanha_formulario_7,
                        'campanha_formulario_8'     => $campanha_formulario_8,
                        'campanha_formulario_9'     => $campanha_formulario_9,
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
                        'campanha_color'            => '',
                        'campanha_formulario_1'     => '',
                        'campanha_formulario_2'     => '',
                        'campanha_formulario_3'     => '',
                        'campanha_formulario_4'     => '',
                        'campanha_formulario_5'     => '',
                        'campanha_formulario_6'     => '',
                        'campanha_formulario_7'     => '',
                        'campanha_formulario_8'     => '',
                        'campanha_formulario_9'     => '',
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

    $app->get('/v1/100/listado', function($request) {
        require __DIR__.'/../src/connect.php';

        $sql00  = "SELECT
        a.CAMFICCOD                     AS      campanha_codigo,
        a.CAMFICNOM                     AS      campanha_nombre,
        a.CAMFICFDE                     AS      campanha_fecha_inicio,
        a.CAMFICFHA                     AS      campanha_fecha_final,
        a.CAMFICCOL                     AS      campanha_color,
        a.CAMFICFO1                     AS      campanha_formulario_1,
        a.CAMFICFO2                     AS      campanha_formulario_2,
        a.CAMFICFO3                     AS      campanha_formulario_3,
        a.CAMFICFO4                     AS      campanha_formulario_4,
        a.CAMFICFO5                     AS      campanha_formulario_5,
        a.CAMFICFO6                     AS      campanha_formulario_6,
        a.CAMFICFO7                     AS      campanha_formulario_7,
        a.CAMFICFO8                     AS      campanha_formulario_8,
        a.CAMFICFO9                     AS      campanha_formulario_9,
        a.CAMFICOBS                     AS      campanha_observacion,
        a.CAMFICAUS                     AS      campanha_usuario,
        a.CAMFICAFH                     AS      campanha_fecha_hora,
        a.CAMFICAIP                     AS      campanha_ip,
        b.DOMFICCOD                     AS      campanha_estado_codigo,
        b.DOMFICNOM                     AS      campanha_estado_nombre
        
        FROM CAMFIC a
        INNER JOIN DOMFIC b ON a.CAMFICEST = b.DOMFICCOD

        WHERE a.CAMFICEST IN (4, 5) 
        
        ORDER BY a.CAMFICEST, a.CAMFICFDE DESC 
        
        LIMIT 3";

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

                if($rowMYSQL['campanha_formulario_9'] === 'S'){
                    $campanha_formulario_9 = 'checked';
                } else {
                    $campanha_formulario_9 = '';
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
                    'campanha_color'            => $rowMYSQL['campanha_color'],
                    'campanha_formulario_1'     => $campanha_formulario_1,
                    'campanha_formulario_2'     => $campanha_formulario_2,
                    'campanha_formulario_3'     => $campanha_formulario_3,
                    'campanha_formulario_4'     => $campanha_formulario_4,
                    'campanha_formulario_5'     => $campanha_formulario_5,
                    'campanha_formulario_6'     => $campanha_formulario_6,
                    'campanha_formulario_7'     => $campanha_formulario_7,
                    'campanha_formulario_8'     => $campanha_formulario_8,
                    'campanha_formulario_9'     => $campanha_formulario_9,
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
                    'campanha_color'            => '',
                    'campanha_formulario_1'     => '',
                    'campanha_formulario_2'     => '',
                    'campanha_formulario_3'     => '',
                    'campanha_formulario_4'     => '',
                    'campanha_formulario_5'     => '',
                    'campanha_formulario_6'     => '',
                    'campanha_formulario_7'     => '',
                    'campanha_formulario_8'     => '',
                    'campanha_formulario_9'     => '',
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

    $app->get('/v1/200/estado/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
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

            WHERE a.FUNFICEST = ?
            
            ORDER BY a.FUNFICCOD";

            try {
                $connMYSQL  = getConnectionMYSQL();
                $stmtMYSQL  = $connMYSQL->prepare($sql00);
                $stmtMYSQL->execute([$val01]); 

                while ($rowMYSQL = $stmtMYSQL->fetch()) {
                    switch ($rowMYSQL['funcionario_estado_codigo']) {
                        case 'A':
                            $funcionario_estado_nombre = 'ACTIVO';
                            break;

                        case 'I':
                            $funcionario_estado_nombre = 'INACTIVO';
                            break;

                        case 'P':
                            $funcionario_estado_nombre = 'PENDIENTE';
                            break;
                        
                        default:
                            $funcionario_estado_nombre = 'SIN ESTADO';
                            break;
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
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
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
                switch ($rowMYSQL['auditoria_antes_estado_codigo']) {
                    case 'A':
                        $funcionario_estado_nombre = 'ACTIVO';
                        break;

                    case 'I':
                        $funcionario_estado_nombre = 'INACTIVO';
                        break;

                    case 'P':
                        $funcionario_estado_nombre = 'PENDIENTE';
                        break;
                    
                    default:
                        $funcionario_estado_nombre = 'SIN ESTADO';
                        break;
                }

                switch ($rowMYSQL['auditoria_despues_estado_codigo']) {
                    case 'A':
                        $funcionario_estado_nombre = 'ACTIVO';
                        break;

                    case 'I':
                        $funcionario_estado_nombre = 'INACTIVO';
                        break;

                    case 'P':
                        $funcionario_estado_nombre = 'PENDIENTE';
                        break;
                    
                    default:
                        $funcionario_estado_nombre = 'SIN ESTADO';
                        break;
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

    $app->get('/v1/200/nuevo', function($request) {
        require __DIR__.'/../src/connect.php';

        $sql00  = "SELECT
        MAX(a.FUNFICCFU)            AS      funcionario_codigo_sistema

        FROM FUNFIC a
        
        ORDER BY a.FUNFICCFU";

        try {
            $connMYSQL  = getConnectionMYSQL();
            $stmtMYSQL  = $connMYSQL->prepare($sql00);
            $stmtMYSQL->execute(); 

            while ($rowMYSQL = $stmtMYSQL->fetch()) {
                $detalle    = array(
                    'funcionario_codigo_sistema'                => $rowMYSQL['funcionario_codigo_sistema'] + 1
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle = array(
                    'funcionario_codigo_sistema'                => ''
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
            c.FUNFICCFU         AS      funcionario_codigo_sistema,
            c.FUNFICNOM         AS      funcionario_nombre,
            c.FUNFICAPE         AS      funcionario_apellido,
            c.FUNFICFOT         AS      funcionario_foto,
            
            a.CAMFUCEST         AS      funcionario_estado_codigo
            
            FROM CAMFUC a
            INNER JOIN CAMFIC b ON a.CAMFUCCAC = b.CAMFICCOD
            INNER JOIN FUNFIC c ON a.CAMFUCFUC = c.FUNFICCOD

            WHERE a.CAMFUCCAC = ?
            
            ORDER BY a.CAMFUCCAC";

            $sql01  = "SELECT
            a.COD_CARGO             AS      funcionario_cargo_codigo,
            a.CARGO                 AS      funcionario_cargo_nombre,
            a.COD_GERENCIA          AS      funcionario_gerencia_codigo,
            a.GERENCIA              AS      funcionario_gerencia_nombre,
            a.COD_DEPARTAMENTO_AREA AS      funcionario_departamento_codigo,
            a.DEPARTAMENTO          AS      funcionario_departamento_nombre,
            a.COD_UNIDAD            AS      funcionario_unidad_codigo,
            a.UNIDAD                AS      funcionario_unidad_nombre,
            a.COD_SUPERVISION       AS      funcionario_supervision_codigo,
            a.SUPERVISION           AS      funcionario_supervision_nombre

            FROM COLABORADOR_BASICOS a

            WHERE a.COD_FUNC = ?

            ORDER BY a.COD_FUNC";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $connMYSQL  = getConnectionMYSQL();

                $stmtMYSQL  = $connMYSQL->prepare($sql00);
                $stmtMSSQL  = $connMSSQL->prepare($sql01);

                $stmtMYSQL->execute([$val01]);

                while ($rowMYSQL = $stmtMYSQL->fetch()) {
                    $stmtMSSQL->execute([$rowMYSQL['funcionario_codigo_sistema']]);
                    $row_mssql  = $stmtMSSQL->fetch(PDO::FETCH_ASSOC);

                    if ($row_mssql){
                        if ($rowMYSQL['funcionario_estado_codigo'] === 'P') {
                            $funcionario_estado_nombre = 'PENDIENTE';
                        } elseif ($rowMYSQL['funcionario_estado_codigo'] === 'C') {
                            $funcionario_estado_nombre = 'CARGADO';
                        } elseif ($rowMYSQL['funcionario_estado_codigo'] === 'F') {
                            $funcionario_estado_nombre = 'CONFIRMADO';
                        }

                        $detalle    = array(
                            'campanha_codigo'                   => $rowMYSQL['campanha_codigo'],
                            'campanha_nombre'                   => $rowMYSQL['campanha_nombre'],
                            'funcionario_codigo'                => $rowMYSQL['funcionario_codigo'],
                            'funcionario_codigo_sistema'        => $rowMYSQL['funcionario_codigo_sistema'],
                            'funcionario_nombre'                => $rowMYSQL['funcionario_nombre'],
                            'funcionario_apellido'              => $rowMYSQL['funcionario_apellido'],
                            'funcionario_persona'               => $rowMYSQL['funcionario_nombre'].' '.$rowMYSQL['funcionario_apellido'],
                            'funcionario_foto'                  => $rowMYSQL['funcionario_foto'],
                            'funcionario_estado_codigo'         => $rowMYSQL['funcionario_estado_codigo'],
                            'funcionario_estado_nombre'         => $funcionario_estado_nombre,
                            'funcionario_cargo_codigo'          => $row_mssql['funcionario_cargo_codigo'],
                            'funcionario_cargo_nombre'          => $row_mssql['funcionario_cargo_nombre'],
                            'funcionario_gerencia_codigo'       => $row_mssql['funcionario_gerencia_codigo'],
                            'funcionario_gerencia_nombre'       => $row_mssql['funcionario_gerencia_nombre'],
                            'funcionario_departamento_codigo'   => $row_mssql['funcionario_departamento_codigo'],
                            'funcionario_departamento_nombre'   => $row_mssql['funcionario_departamento_nombre'],
                            'funcionario_unidad_codigo'         => $row_mssql['funcionario_unidad_codigo'],
                            'funcionario_unidad_nombre'         => $row_mssql['funcionario_unidad_nombre'],
                            'funcionario_supervision_codigo'    => $row_mssql['funcionario_supervision_codigo'],
                            'funcionario_supervision_nombre'    => $row_mssql['funcionario_supervision_nombre']
                        );
                    }

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'campanha_codigo'                   => '',
                        'campanha_nombre'                   => '',
                        'funcionario_codigo'                => '',
                        'funcionario_codigo_sistema'        => '',
                        'funcionario_nombre'                => '',
                        'funcionario_apellido'              => '',
                        'funcionario_persona'               => '',
                        'funcionario_foto'                  => '',
                        'funcionario_estado_codigo'         => '',
                        'funcionario_estado_nombre'         => '',
                        'funcionario_cargo_codigo'          => '',
                        'funcionario_cargo_nombre'          => '',
                        'funcionario_gerencia_codigo'       => '',
                        'funcionario_gerencia_nombre'       => '',
                        'funcionario_departamento_codigo'   => '',
                        'funcionario_departamento_nombre'   => '',
                        'funcionario_unidad_codigo'         => '',
                        'funcionario_unidad_nombre'         => '',
                        'funcionario_supervision_codigo'    => '',
                        'funcionario_supervision_nombre'    => ''
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

    $app->get('/v1/400/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.COD_FUNC                      AS          funcionario_codigo,
            a.USUARIO                       AS          funcionario_usuario,
            a.NOMBRE_Y_APELLIDO             AS          funcionario_completo,
            a.NRO_CEDULA                    AS          funcionario_documento,
            a.FEC_NACIMIENTO                AS          funcionario_fecha_nacimiento,
            a.EDAD                          AS          funcionario_edad,
            a.SEXO                          AS          funcionario_sexo,
            a.ESTADO_CIVIL                  AS          funcionario_estado_civil,
            a.NACIONALIDAD                  AS          funcionario_nacionalidad,
            a.CORREO_ELECTRONICO            AS          funcionario_email,
            a.FECHA_INGRESO                 AS          funcionario_fecha_ingreso,
            a.GERENCIA                      AS          funcionario_gerencia,
            a.DEPARTAMENTO                  AS          funcionario_deparmento,
            a.CARGO                         AS          funcionario_cargo,
            a.FOTO_TARGET                   AS          funcionario_foto,
            a.ANTIGUEDAD                    AS          funcionario_antiguedad
            FROM COLABORADOR_BASICOS a
            WHERE a.COD_FUNC = ?
            ORDER BY a.COD_FUNC";

            $sql02  = "SELECT
            a.FUNTRACOD         AS          funcionario_trabajo_anterior_codigo,
            a.FUNTRAEST         AS          funcionario_trabajo_anterior_estado_codigo,
            a.FUNTRAFDE         AS          funcionario_trabajo_anterior_fecha_desde,
            a.FUNTRAFHA         AS          funcionario_trabajo_anterior_fecha_hasta,
            a.FUNTRAOBS         AS          funcionario_trabajo_anterior_observacion,
            a.FUNTRAAUS         AS          auditoria_usuario,
            a.FUNTRAAFH         AS          auditoria_fecha,
            a.FUNTRAAIP         AS          auditoria_ip,
            b.DOMFICCOD         AS          funcionario_trabajo_anterior_cargo_codigo,
            b.DOMFICNOM         AS          funcionario_trabajo_anterior_cargo_nombre,
            c.DOMFICCOD         AS          funcionario_trabajo_anterior_motivo_salida_codigo,
            c.DOMFICNOM         AS          funcionario_trabajo_anterior_motivo_salida_nombre,
            d.DOMFICCOD         AS          funcionario_trabajo_anterior_empresa_codigo,
            d.DOMFICNOM         AS          funcionario_trabajo_anterior_empresa_nombre
            FROM FUNTRA a
            INNER JOIN DOMFIC b ON a.FUNTRATCC = b.DOMFICCOD
            INNER JOIN DOMFIC c ON a.FUNTRAMSC = c.DOMFICCOD
            INNER JOIN DOMFIC d ON a.FUNTRAEMP = d.DOMFICCOD
            WHERE a.FUNTRAFUC = (SELECT FUNFICCOD FROM FUNFIC WHERE FUNFICCFU = ?)
            ORDER BY a.FUNTRAAFH DESC";

            $sql03  = "SELECT
            a.FUNOAECOD         AS          funcionario_actividad_economica_codigo,
            a.FUNOAEEST         AS          funcionario_actividad_economica_estado_codigo,
            a.FUNOAENOM         AS          funcionario_actividad_economica_nombre,
            a.FUNOAEOBS         AS          funcionario_actividad_economica_observacion,
            a.FUNOAEAUS         AS          auditoria_usuario,
            a.FUNOAEAFH         AS          auditoria_fecha,
            a.FUNOAEAIP         AS          auditoria_ip,
            b.DOMFICCOD         AS          funcionario_actividad_economica_tipo_codigo,
            b.DOMFICNOM         AS          funcionario_actividad_economica_tipo_nombre
            FROM FUNOAE a
            INNER JOIN DOMFIC b ON a.FUNOAEAEC = b.DOMFICCOD
            WHERE a.FUNOAEFUC = (SELECT FUNFICCOD FROM FUNFIC WHERE FUNFICCFU = ?)
            ORDER BY a.FUNOAEAFH DESC";

            $sql04  = "SELECT
            a.FUNPARCOD         AS          funcionario_particulares_codigo,
            a.FUNPAREST         AS          funcionario_particulares_estado_codigo,
            a.FUNPARCAS         AS          funcionario_particulares_casa_numero,
            a.FUNPARCA1         AS          funcionario_particulares_calle_1,
            a.FUNPARCA2         AS          funcionario_particulares_calle_2,
            a.FUNPARCA3         AS          funcionario_particulares_calle_3,
            a.FUNPARUBI         AS          funcionario_particulares_posicion,
            a.FUNPARTE1         AS          funcionario_particulares_telefono_numero_1,
            a.FUNPARCE1         AS          funcionario_particulares_celular_numero_1,
            a.FUNPARCE2         AS          funcionario_particulares_celular_numero_2,
            a.FUNPAREMA         AS          funcionario_particulares_email,
            a.FUNPAROBS         AS          funcionario_particulares_observacion,
            a.FUNPARAUS         AS          auditoria_usuario,
            a.FUNPARAFH         AS          auditoria_fecha,
            a.FUNPARAIP         AS          auditoria_ip,
            b.DOMFICCOD         AS          funcionario_particulares_vivienda_codigo,
            b.DOMFICNOM         AS          funcionario_particulares_vivienda_nombre,
            c.DOMFICCOD         AS          funcionario_particulares_celular_codigo_1,
            c.DOMFICNOM         AS          funcionario_particulares_celular_nombre_1,
            d.DOMFICCOD         AS          funcionario_particulares_celular_codigo_2,
            d.DOMFICNOM         AS          funcionario_particulares_celular_nombre_2,
            e.DOMFICCOD         AS          funcionario_particulares_telefono_codigo_1,
            e.DOMFICNOM         AS          funcionario_particulares_telefono_nombre_1,
            f.LOCCIUCOD         AS          funcionario_particulares_ciudad_codigo,
            f.LOCCIUNOM         AS          funcionario_particulares_ciudad_nombre,
            g.LOCBARCOD         AS          funcionario_particulares_barrio_codigo,
            g.LOCBARNOM         AS          funcionario_particulares_barrio_nombre
            FROM FUNPAR a
            INNER JOIN DOMFIC b ON a.FUNPARTVC = b.DOMFICCOD
            INNER JOIN DOMFIC c ON a.FUNPARTCC = c.DOMFICCOD
            INNER JOIN DOMFIC d ON a.FUNPARTEC = d.DOMFICCOD
            INNER JOIN DOMFIC e ON a.FUNPARTTC = e.DOMFICCOD
            INNER JOIN LOCCIU f ON a.FUNPARCIC = f.LOCCIUCOD
            INNER JOIN LOCBAR g ON a.FUNPARBAC = g.LOCBARCOD
            WHERE a.FUNPARFUC = (SELECT FUNFICCOD FROM FUNFIC WHERE FUNFICCFU = ?)
            ORDER BY a.FUNPARAFH DESC";

            $sql05  = "SELECT
            a.FUNRPPCOD         AS          funcionario_referencia_codigo,
            a.FUNRPPEST         AS          funcionario_referencia_estado_codigo,
            a.FUNRPPNOM         AS          funcionario_referencia_nombre,
            a.FUNRPPTCN         AS          funcionario_referencia_celular_numero,
            a.FUNRPPTTN         AS          funcionario_referencia_telefono_numero,
            a.FUNRPPOBS         AS          funcionario_referencia_observacion,
            a.FUNRPPAUS         AS          auditoria_usuario,
            a.FUNRPPAFH         AS          auditoria_fecha,
            a.FUNRPPAIP         AS          auditoria_ip,
            b.DOMFICCOD         AS          funcionario_referencia_celular_codigo,
            b.DOMFICNOM         AS          funcionario_referencia_celular_nombre,
            c.DOMFICCOD         AS          funcionario_referencia_telefono_codigo,
            c.DOMFICNOM         AS          funcionario_referencia_telefono_nombre
            FROM FUNRPP a
            INNER JOIN DOMFIC b ON a.FUNRPPTCC = b.DOMFICCOD
            INNER JOIN DOMFIC c ON a.FUNRPPTTC = c.DOMFICCOD
            WHERE a.FUNRPPFUC = (SELECT FUNFICCOD FROM FUNFIC WHERE FUNFICCFU = ?)
            ORDER BY a.FUNRPPAFH DESC";

            $sql06  = "SELECT
            a.FUNOAPCOD         AS          funcionario_actividad_codigo,
            a.FUNOAPEST         AS          funcionario_actividad_estado_codigo,
            a.FUNOAPTMC         AS          funcionario_actividad_movilidad_codigo,
            a.FUNOAPTHE         AS          funcionario_actividad_hobbie_especificar,
            a.FUNOAPTPE         AS          funcionario_actividad_proyecto_especificar,
            a.FUNOAPCAD         AS          funcionario_actividad_cantidad_dependiente,
            a.FUNOAPCAC         AS          funcionario_actividad_cantidad_contribuyente,
            a.FUNOAPTDT         AS          funcionario_actividad_tiempo_traslado,
            a.FUNOAPOBS         AS          funcionario_actividad_observacion,
            a.FUNOAPAUS         AS          auditoria_usuario,
            a.FUNOAPAFH         AS          auditoria_fecha,
            a.FUNOAPAIP         AS          auditoria_ip,
            b.DOMFICCOD         AS          funcionario_actividad_hobbie_codigo,
            b.DOMFICNOM         AS          funcionario_actividad_hobbis_nombre,
            c.DOMFICCOD         AS          funcionario_actividad_proyecto_codigo,
            c.DOMFICNOM         AS          funcionario_actividad_proyecto_nombre
            FROM FUNOAP a
            INNER JOIN DOMFIC b ON a.FUNOAPTHC = b.DOMFICCOD
            INNER JOIN DOMFIC c ON a.FUNOAPTPC = c.DOMFICCOD
            WHERE a.FUNOAPFUC = (SELECT FUNFICCOD FROM FUNFIC WHERE FUNFICCFU = ?)
            ORDER BY a.FUNOAPAFH DESC";

            $sql07  = "SELECT
            a.FUNFAMCOD         AS          funcionario_familiares_codigo,
            a.FUNFAMEST         AS          funcionario_familiares_estado_codigo,
            a.FUNFAMNOM         AS          funcionario_familiares_nombre,
            a.FUNFAMAPE         AS          funcionario_familiares_apellido,
            a.FUNFAMCIC         AS          funcionario_familiares_documento_numero,
            a.FUNFAMFHA         AS          funcionario_familiares_fecha_nacimiento,
            a.FUNFAMEMP         AS          funcionario_familiares_empresa,
            a.FUNFAMOCU         AS          funcionario_familiares_ocupacion,
            a.FUNFAMCEL         AS          funcionario_familiares_celular_numero,
            a.FUNFAMTEL         AS          funcionario_familiares_telefono_numero,
            a.FUNFAMOBS         AS          funcionario_familiares_observacion,
            a.FUNFAMAUS         AS          auditoria_usuario,
            a.FUNFAMAFH         AS          auditoria_fecha,
            a.FUNFAMAIP         AS          auditoria_ip,
            b.DOMFICCOD         AS          funcionario_familiares_parentezco_codigo,
            b.DOMFICNOM         AS          funcionario_familiares_parentezco_nombre,
            c.DOMFICCOD         AS          funcionario_familiares_celular_codigo,
            c.DOMFICNOM         AS          funcionario_familiares_celular_nombre,
            d.DOMFICCOD         AS          funcionario_familiares_telefono_codigo,
            d.DOMFICNOM         AS          funcionario_familiares_telefono_nombre
            FROM FUNFAM a
            INNER JOIN DOMFIC b ON a.FUNFAMTPC = b.DOMFICCOD
            INNER JOIN DOMFIC c ON a.FUNFAMTCC = c.DOMFICCOD
            INNER JOIN DOMFIC d ON a.FUNFAMTTC = d.DOMFICCOD
            WHERE a.FUNFAMFUC = (SELECT FUNFICCOD FROM FUNFIC WHERE FUNFICCFU = ?)
            ORDER BY a.FUNFAMAFH DESC";

            $sql08  = "SELECT
            a.FUNCELCOD         AS          funcionario_movil_codigo,
            a.FUNCELEST         AS          funcionario_movil_estado_codigo,
            a.FUNCELMOD         AS          funcionario_movil_modelo,
            a.FUNCELANO         AS          funcionario_movil_anho_compra,
            a.FUNCELOBS         AS          funcionario_movil_observacion,
            a.FUNCELAUS         AS          auditoria_usuario,
            a.FUNCELAFH         AS          auditoria_fecha,
            a.FUNCELAIP         AS          auditoria_ip,
            b.DOMFICCOD         AS          funcionario_movil_marca_codigo,
            b.DOMFICNOM         AS          funcionario_movil_marca_nombre,
            c.DOMFICCOD         AS          funcionario_movil_color_codigo,
            c.DOMFICNOM         AS          funcionario_movil_color_nombre
            FROM FUNCEL a
            INNER JOIN DOMFIC b ON a.FUNCELTMC = b.DOMFICCOD
            INNER JOIN DOMFIC c ON a.FUNCELTCC = c.DOMFICCOD
            WHERE a.FUNCELFUC = (SELECT FUNFICCOD FROM FUNFIC WHERE FUNFICCFU = ?)
            ORDER BY a.FUNCELAFH DESC";

            $sql09  = "SELECT
            a.FUNFICCOD         AS          funcionario_datos_codigo,
            a.FUNFICEST         AS          funcionario_datos_estado_codigo,
            a.FUNFICNOM         AS          funcionario_datos_nombre,
            a.FUNFICAPE         AS          funcionario_datos_apellido,
            a.FUNFICDOC         AS          funcionario_datos_documento_numero,
            a.FUNFICDOF         AS          funcionario_datos_documento_vencimiento,
            a.FUNFICFHA         AS          funcionario_datos_fecha_nacimiento,
            a.FUNFICEMA         AS          funcionario_datos_email,
            a.FUNFICFOT         AS          funcionario_datos_foto,
            a.FUNFICOBS         AS          funcionario_datos_observacion,
            a.FUNFICAUS         AS          auditoria_usuario,
            a.FUNFICAFH         AS          auditoria_fecha,
            a.FUNFICAIP         AS          auditoria_ip,
            b.DOMFICCOD         AS          funcionario_datos_documento_codigo,
            b.DOMFICNOM         AS          funcionario_datos_documento_nombre,
            c.DOMFICCOD         AS          funcionario_datos_sexo_codigo,
            c.DOMFICNOM         AS          funcionario_datos_sexo_nombre,
            d.DOMFICCOD         AS          funcionario_datos_estado_civil_codigo,
            d.DOMFICNOM         AS          funcionario_datos_estado_civil_nombre,
            e.DOMFICCOD         AS          funcionario_datos_nacionalidad_codigo,
            e.DOMFICNOM         AS          funcionario_datos_nacionalidad_nombre
            FROM FUNFIC a
            INNER JOIN DOMFIC b ON a.FUNFICTDC = b.DOMFICCOD
            INNER JOIN DOMFIC c ON a.FUNFICTSC = c.DOMFICCOD
            INNER JOIN DOMFIC d ON a.FUNFICECC = d.DOMFICCOD
            INNER JOIN DOMFIC e ON a.FUNFICTNC = e.DOMFICCOD
            WHERE a.FUNFICCFU =  ?
            ORDER BY a.FUNFICAFH DESC";

            $sql10  = "SELECT
            a.FUNACACOD         AS          funcionario_academico_codigo,
            a.FUNACAEST         AS          funcionario_academico_estado_codigo,
            a.FUNACAOBS         AS          funcionario_academico_observacion,
            a.FUNACAAUS         AS          auditoria_usuario,
            a.FUNACAAFH         AS          auditoria_fecha,
            a.FUNACAAIP         AS          auditoria_ip,
            b.DOMFICCOD         AS          funcionario_academico_universidad_codigo,
            b.DOMFICNOM         AS          funcionario_academico_universidad_nombre,
            c.DOMFICCOD         AS          funcionario_academico_carrera_codigo,
            c.DOMFICNOM         AS          funcionario_academico_carrera_nombre,
            d.DOMFICCOD         AS          funcionario_academico_grado_academico_codigo,
            d.DOMFICNOM         AS          funcionario_academico_grado_academico_nombre,
            e.DOMFICCOD         AS          funcionario_academico_grado_estado_codigo,
            e.DOMFICNOM         AS          funcionario_academico_grado_estado_nombre
            FROM FUNACA a
            INNER JOIN DOMFIC b ON a.FUNACATUC = b.DOMFICCOD
            INNER JOIN DOMFIC c ON a.FUNACATCC = c.DOMFICCOD
            INNER JOIN DOMFIC d ON a.FUNACATGC = d.DOMFICCOD
            INNER JOIN DOMFIC e ON a.FUNACATEC = e.DOMFICCOD
            WHERE a.FUNACAFUC = (SELECT FUNFICCOD FROM FUNFIC WHERE FUNFICCFU = ?)
            ORDER BY a.FUNACAAFH DESC";

            $sql11  = "SELECT
            a.FUNCAPCOD         AS          funcionario_capacitacion_codigo,
            a.FUNCAPEST         AS          funcionario_capacitacion_estado_codigo,
            a.FUNCAPEMP         AS          funcionario_capacitacion_empresa,
            a.FUNCAPCAP         AS          funcionario_capacitacion_curso,
            a.FUNCAPPER         AS          funcionario_capacitacion_periodo,
            a.FUNCAPOBS         AS          funcionario_capacitacion_observacion,
            a.FUNCAPAUS         AS          auditoria_usuario,
            a.FUNCAPAFH         AS          auditoria_fecha,
            a.FUNCAPAIP         AS          auditoria_ip

            FROM FUNCAP a
            WHERE a.FUNCAPFUC = (SELECT FUNFICCOD FROM FUNFIC WHERE FUNFICCFU = ?)
            ORDER BY a.FUNCAPAFH DESC";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $connMYSQL  = getConnectionMYSQL();

                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]);

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    if (isset($rowMSSQL['funcionario_foto'])) {
                        $funcionario_foto = strtolower($rowMSSQL['funcionario_foto']);
                    } else {
                        $funcionario_foto = '../assets/images/users/photo.png';
                    }
                    
                    $detalle    = array(
                        'funcionario_codigo'                                        => $rowMSSQL['funcionario_codigo'],
                        'funcionario_usuario'                                       => strtoupper($rowMSSQL['funcionario_usuario']),
                        'funcionario_completo'                                      => strtoupper($rowMSSQL['funcionario_completo']),
                        'funcionario_documento'                                     => strtoupper($rowMSSQL['funcionario_documento']),
                        'funcionario_fecha_nacimiento'                              => date("d/m/Y", strtotime($rowMSSQL['funcionario_fecha_nacimiento'])),
                        'funcionario_edad'                                          => $rowMSSQL['funcionario_edad'],
                        'funcionario_sexo'                                          => strtoupper($rowMSSQL['funcionario_sexo']),
                        'funcionario_estado_civil'                                  => strtoupper($rowMSSQL['funcionario_estado_civil']),
                        'funcionario_nacionalidad'                                  => strtoupper($rowMSSQL['funcionario_nacionalidad']),
                        'funcionario_email'                                         => strtolower($rowMSSQL['funcionario_email']),
                        'funcionario_fecha_ingreso'                                 => date("d/m/Y", strtotime($rowMSSQL['funcionario_fecha_ingreso'])),
                        'funcionario_gerencia'                                      => strtoupper($rowMSSQL['funcionario_gerencia']),
                        'funcionario_deparmento'                                    => strtoupper($rowMSSQL['funcionario_deparmento']),
                        'funcionario_cargo'                                         => strtoupper($rowMSSQL['funcionario_cargo']),
                        'funcionario_foto'                                          => $funcionario_foto,
                        'funcionario_antiguedad'                                    => strtoupper($rowMSSQL['funcionario_antiguedad'])
                    );

                    $result_funcionario[]   = $detalle;
                }

                if (!isset($result_funcionario)){
                    $detalle    = array(
                        'funcionario_codigo'                                        => '',
                        'funcionario_usuario'                                       => '',
                        'funcionario_completo'                                      => '',
                        'funcionario_documento'                                     => '',
                        'funcionario_fecha_nacimiento'                              => '',
                        'funcionario_edad'                                          => '',
                        'funcionario_sexo'                                          => '',
                        'funcionario_estado_civil'                                  => '',
                        'funcionario_nacionalidad'                                  => '',
                        'funcionario_email'                                         => '',
                        'funcionario_fecha_ingreso'                                 => '',
                        'funcionario_gerencia'                                      => '',
                        'funcionario_deparmento'                                    => '',
                        'funcionario_cargo'                                         => '',
                        'funcionario_foto'                                          => '../assets/images/users/photo.png',
                        'funcionario_antiguedad'                                    => ''
                    );

                    $result_funcionario[]   = $detalle;
                }

                $stmtMYSQL02= $connMYSQL->prepare($sql02);
                $stmtMYSQL02->execute([$val01]);

                while ($rowMYSQL02 = $stmtMYSQL02->fetch()) {
                    if($rowMYSQL02['funcionario_trabajo_anterior_estado_codigo'] === 'A'){
                        $estado_nombre = 'ACTIVO';
                    } else {
                        $estado_nombre = 'INACTIVO';
                    }

                    $detalle    = array(
                        'funcionario_trabajo_anterior_codigo'                       => $rowMYSQL02['funcionario_trabajo_anterior_codigo'],
                        'funcionario_trabajo_anterior_estado_codigo'                => $rowMYSQL02['funcionario_trabajo_anterior_estado_codigo'],
                        'funcionario_trabajo_anterior_estado_nombre'                => $estado_nombre,
                        'funcionario_trabajo_anterior_empresa_codigo'               => $rowMYSQL02['funcionario_trabajo_anterior_empresa_codigo'],
                        'funcionario_trabajo_anterior_empresa_nombre'               => strtoupper($rowMYSQL02['funcionario_trabajo_anterior_empresa_nombre']),
                        'funcionario_trabajo_anterior_fecha_desde'                  => date("Y-m-d", strtotime($rowMYSQL02['funcionario_trabajo_anterior_fecha_desde'])),
                        'funcionario_trabajo_anterior_fecha_hasta'                  => date("Y-m-d", strtotime($rowMYSQL02['funcionario_trabajo_anterior_fecha_hasta'])),
                        'funcionario_trabajo_anterior_observacion'                  => strtoupper($rowMYSQL02['funcionario_trabajo_anterior_observacion']),
                        'funcionario_trabajo_anterior_cargo_codigo'                 => $rowMYSQL02['funcionario_trabajo_anterior_cargo_codigo'],
                        'funcionario_trabajo_anterior_cargo_nombre'                 => strtoupper($rowMYSQL02['funcionario_trabajo_anterior_cargo_nombre']),
                        'funcionario_trabajo_anterior_motivo_salida_codigo'         => $rowMYSQL02['funcionario_trabajo_anterior_motivo_salida_codigo'],
                        'funcionario_trabajo_anterior_motivo_salida_nombre'         => strtoupper($rowMYSQL02['funcionario_trabajo_anterior_motivo_salida_nombre']),
                        'auditoria_usuario'                                         => strtoupper($rowMYSQL02['auditoria_usuario']),
                        'auditoria_fecha'                                           => date("d/m/Y", strtotime($rowMYSQL02['auditoria_fecha'])),
                        'auditoria_ip'                                              => strtoupper($rowMYSQL02['auditoria_ip'])         
                    );

                    $result_funcionario_trabajo_anterior[]   = $detalle;
                }

                if (!isset($result_funcionario_trabajo_anterior)){
                    $detalle    = array(
                        'funcionario_trabajo_anterior_codigo'                       => '',
                        'funcionario_trabajo_anterior_estado_codigo'                => '',
                        'funcionario_trabajo_anterior_estado_nombre'                => '',
                        'funcionario_trabajo_anterior_empresa_codigo'               => '',
                        'funcionario_trabajo_anterior_empresa_nombre'               => '',
                        'funcionario_trabajo_anterior_fecha_desde'                  => '',
                        'funcionario_trabajo_anterior_fecha_hasta'                  => '',
                        'funcionario_trabajo_anterior_observacion'                  => '',
                        'funcionario_trabajo_anterior_cargo_codigo'                 => '',
                        'funcionario_trabajo_anterior_cargo_nombre'                 => '',
                        'funcionario_trabajo_anterior_motivo_salida_codigo'         => '',
                        'funcionario_trabajo_anterior_motivo_salida_nombre'         => '',
                        'auditoria_usuario'                                         => '',
                        'auditoria_fecha'                                           => '',
                        'auditoria_ip'                                              => ''
                    );

                    $result_funcionario_trabajo_anterior[]   = $detalle;
                }

                $stmtMYSQL03= $connMYSQL->prepare($sql03);
                $stmtMYSQL03->execute([$val01]);

                while ($rowMYSQL03 = $stmtMYSQL03->fetch()) {
                    if($rowMYSQL03['funcionario_actividad_economica_estado_codigo'] === 'A'){
                        $estado_nombre = 'ACTIVO';
                    } else {
                        $estado_nombre = 'INACTIVO';
                    }

                    $detalle    = array(
                        'funcionario_actividad_economica_codigo'                    => $rowMYSQL03['funcionario_actividad_economica_codigo'],
                        'funcionario_actividad_economica_estado_codigo'             => $rowMYSQL03['funcionario_actividad_economica_estado_codigo'],
                        'funcionario_actividad_economica_estado_nombre'             => $estado_nombre,
                        'funcionario_actividad_economica_nombre'                    => strtoupper($rowMYSQL03['funcionario_actividad_economica_nombre']),
                        'funcionario_actividad_economica_observacion'               => strtoupper($rowMYSQL03['funcionario_actividad_economica_observacion']),
                        'funcionario_actividad_economica_tipo_codigo'               => $rowMYSQL03['funcionario_actividad_economica_tipo_codigo'],
                        'funcionario_actividad_economica_tipo_nombre'               => strtoupper($rowMYSQL03['funcionario_actividad_economica_tipo_nombre']),
                        'auditoria_usuario'                                         => strtoupper($rowMYSQL03['auditoria_usuario']),
                        'auditoria_fecha'                                           => date("d/m/Y", strtotime($rowMYSQL03['auditoria_fecha'])),
                        'auditoria_ip'                                              => strtoupper($rowMYSQL03['auditoria_ip'])       
                    );

                    $result_funcionario_actividad_economica[]   = $detalle;
                }

                if (!isset($result_funcionario_actividad_economica)){
                    $detalle    = array(
                        'funcionario_actividad_economica_codigo'                    => '',
                        'funcionario_actividad_economica_estado_codigo'             => '',
                        'funcionario_actividad_economica_estado_nombre'             => '',
                        'funcionario_actividad_economica_nombre'                    => '',
                        'funcionario_actividad_economica_observacion'               => '',
                        'funcionario_actividad_economica_tipo_codigo'               => '',
                        'funcionario_actividad_economica_tipo_nombre'               => '',
                        'auditoria_usuario'                                         => '',
                        'auditoria_fecha'                                           => '',
                        'auditoria_ip'                                              => ''
                    );

                    $result_funcionario_actividad_economica[]   = $detalle;
                }

                $stmtMYSQL04= $connMYSQL->prepare($sql04);
                $stmtMYSQL04->execute([$val01]);

                while ($rowMYSQL04 = $stmtMYSQL04->fetch()) {
                    if($rowMYSQL04['funcionario_particulares_estado_codigo'] === 'A'){
                        $estado_nombre = 'ACTIVO';
                    } else {
                        $estado_nombre = 'INACTIVO';
                    }

                    $detalle    = array(
                        'funcionario_particulares_codigo'                           => $rowMYSQL04['funcionario_particulares_codigo'],
                        'funcionario_particulares_estado_codigo'                    => $rowMYSQL04['funcionario_particulares_estado_codigo'],
                        'funcionario_particulares_estado_nombre'                    => $estado_nombre,
                        'funcionario_particulares_casa_numero'                      => strtoupper($rowMYSQL04['funcionario_particulares_casa_numero']),
                        'funcionario_particulares_calle_1'                          => strtoupper($rowMYSQL04['funcionario_particulares_calle_1']),
                        'funcionario_particulares_calle_2'                          => strtoupper($rowMYSQL04['funcionario_particulares_calle_2']),
                        'funcionario_particulares_calle_3'                          => strtoupper($rowMYSQL04['funcionario_particulares_calle_3']),
                        'funcionario_particulares_posicion'                         => strtoupper($rowMYSQL04['funcionario_particulares_posicion']),
                        'funcionario_particulares_telefono_codigo_1'                => $rowMYSQL04['funcionario_particulares_telefono_codigo_1'],
                        'funcionario_particulares_telefono_numero_1'                => strtoupper($rowMYSQL04['funcionario_particulares_telefono_numero_1']),
                        'funcionario_particulares_telefono_nombre_1'                => strtoupper($rowMYSQL04['funcionario_particulares_telefono_nombre_1']),
                        'funcionario_particulares_celular_codigo_1'                 => $rowMYSQL04['funcionario_particulares_celular_codigo_1'],
                        'funcionario_particulares_celular_nombre_1'                 => strtoupper($rowMYSQL04['funcionario_particulares_celular_nombre_1']),
                        'funcionario_particulares_celular_numero_1'                 => strtoupper($rowMYSQL04['funcionario_particulares_celular_numero_1']),
                        'funcionario_particulares_celular_codigo_2'                 => $rowMYSQL04['funcionario_particulares_celular_codigo_2'],
                        'funcionario_particulares_celular_nombre_2'                 => strtoupper($rowMYSQL04['funcionario_particulares_celular_nombre_2']),
                        'funcionario_particulares_celular_numero_2'                 => strtoupper($rowMYSQL04['funcionario_particulares_celular_numero_2']),
                        'funcionario_particulares_email'                            => strtolower($rowMYSQL04['funcionario_particulares_email']),
                        'funcionario_particulares_observacion'                      => strtoupper($rowMYSQL04['funcionario_particulares_observacion']),
                        'funcionario_particulares_vivienda_codigo'                  => $rowMYSQL04['funcionario_particulares_vivienda_codigo'],
                        'funcionario_particulares_vivienda_nombre'                  => strtoupper($rowMYSQL04['funcionario_particulares_vivienda_nombre']),
                        'funcionario_particulares_ciudad_codigo'                    => $rowMYSQL04['funcionario_particulares_ciudad_codigo'],
                        'funcionario_particulares_ciudad_nombre'                    => strtoupper($rowMYSQL04['funcionario_particulares_ciudad_nombre']),
                        'funcionario_particulares_barrio_codigo'                    => $rowMYSQL04['funcionario_particulares_barrio_codigo'],
                        'funcionario_particulares_barrio_nombre'                    => strtoupper($rowMYSQL04['funcionario_particulares_barrio_nombre']),
                        'auditoria_usuario'                                         => strtoupper($rowMYSQL04['auditoria_usuario']),
                        'auditoria_fecha'                                           => date("d/m/Y", strtotime($rowMYSQL04['auditoria_fecha'])),
                        'auditoria_ip'                                              => strtoupper($rowMYSQL04['auditoria_ip'])
                    );

                    $result_funcionario_particulares[]   = $detalle;
                }

                if (!isset($result_funcionario_particulares)){
                    $detalle    = array(
                        'funcionario_particulares_codigo'                           => '',
                        'funcionario_particulares_estado_codigo'                    => '',
                        'funcionario_particulares_estado_nombre'                    => '',
                        'funcionario_particulares_casa_numero'                      => '',
                        'funcionario_particulares_calle_1'                          => '',
                        'funcionario_particulares_calle_2'                          => '',
                        'funcionario_particulares_calle_3'                          => '',
                        'funcionario_particulares_posicion'                         => '',
                        'funcionario_particulares_telefono_codigo_1'                => '',
                        'funcionario_particulares_telefono_numero_1'                => '',
                        'funcionario_particulares_telefono_nombre_1'                => '',
                        'funcionario_particulares_celular_codigo_1'                 => '',
                        'funcionario_particulares_celular_nombre_1'                 => '',
                        'funcionario_particulares_celular_numero_1'                 => '',
                        'funcionario_particulares_celular_codigo_2'                 => '',
                        'funcionario_particulares_celular_nombre_2'                 => '',
                        'funcionario_particulares_celular_numero_2'                 => '',
                        'funcionario_particulares_email'                            => '',
                        'funcionario_particulares_observacion'                      => '',
                        'funcionario_particulares_vivienda_codigo'                  => '',
                        'funcionario_particulares_vivienda_nombre'                  => '',
                        'funcionario_particulares_ciudad_codigo'                    => '',
                        'funcionario_particulares_ciudad_nombre'                    => '',
                        'funcionario_particulares_barrio_codigo'                    => '',
                        'funcionario_particulares_barrio_nombre'                    => '',
                        'auditoria_usuario'                                         => '',
                        'auditoria_fecha'                                           => '',
                        'auditoria_ip'                                              => ''
                    );

                    $result_funcionario_particulares[]   = $detalle;
                }

                $stmtMYSQL05= $connMYSQL->prepare($sql05);
                $stmtMYSQL05->execute([$val01]);

                while ($rowMYSQL05 = $stmtMYSQL05->fetch()) {
                    if($rowMYSQL05['funcionario_referencia_estado_codigo'] === 'A'){
                        $estado_nombre = 'ACTIVO';
                    } else {
                        $estado_nombre = 'INACTIVO';
                    }

                    $detalle    = array(
                        'funcionario_referencia_codigo'                             => $rowMYSQL05['funcionario_referencia_codigo'],
                        'funcionario_referencia_estado_codigo'                      => $rowMYSQL05['funcionario_referencia_estado_codigo'],
                        'funcionario_referencia_estado_nombre'                      => $estado_nombre,
                        'funcionario_referencia_nombre'                             => strtoupper($rowMYSQL05['funcionario_referencia_nombre']),
                        'funcionario_referencia_celular_numero'                     => $rowMYSQL05['funcionario_referencia_celular_numero'],
                        'funcionario_referencia_telefono_numero'                    => $rowMYSQL05['funcionario_referencia_telefono_numero'],
                        'funcionario_referencia_observacion'                        => strtoupper($rowMYSQL05['funcionario_referencia_observacion']),
                        'funcionario_referencia_celular_codigo'                     => $rowMYSQL05['funcionario_referencia_celular_codigo'],
                        'funcionario_referencia_celular_nombre'                     => strtoupper($rowMYSQL05['funcionario_referencia_celular_nombre']),
                        'funcionario_referencia_telefono_codigo'                    => $rowMYSQL05['funcionario_referencia_telefono_codigo'],
                        'funcionario_referencia_telefono_nombre'                    => strtoupper($rowMYSQL05['funcionario_referencia_telefono_nombre']),
                        'auditoria_usuario'                                         => strtoupper($rowMYSQL05['auditoria_usuario']),
                        'auditoria_fecha'                                           => date("d/m/Y", strtotime($rowMYSQL05['auditoria_fecha'])),
                        'auditoria_ip'                                              => strtoupper($rowMYSQL05['auditoria_ip'])      
                    );

                    $result_funcionario_referencia[]   = $detalle;
                }

                if (!isset($result_funcionario_referencia)){
                    $detalle    = array(
                        'funcionario_referencia_codigo'                             => '',
                        'funcionario_referencia_estado_codigo'                      => '',
                        'funcionario_referencia_estado_nombre'                      => '',
                        'funcionario_referencia_nombre'                             => '',
                        'funcionario_referencia_celular_numero'                     => '',
                        'funcionario_referencia_telefono_numero'                    => '',
                        'funcionario_referencia_observacion'                        => '',
                        'funcionario_referencia_celular_codigo'                     => '',
                        'funcionario_referencia_celular_nombre'                     => '',
                        'funcionario_referencia_telefono_codigo'                    => '',
                        'funcionario_referencia_telefono_nombre'                    => '',
                        'auditoria_usuario'                                         => '',
                        'auditoria_fecha'                                           => '',
                        'auditoria_ip'                                              => ''
                    );

                    $result_funcionario_referencia[]   = $detalle;
                }

                $stmtMYSQL06= $connMYSQL->prepare($sql06);
                $stmtMYSQL06->execute([$val01]);

                while ($rowMYSQL06 = $stmtMYSQL06->fetch()) {
                    if($rowMYSQL06['funcionario_actividad_estado_codigo'] === 'A'){
                        $estado_nombre = 'ACTIVO';
                    } else {
                        $estado_nombre = 'INACTIVO';
                    }

                    $detalle    = array(
                        'funcionario_actividad_codigo'                              => $rowMYSQL06['funcionario_actividad_codigo'],
                        'funcionario_actividad_estado_codigo'                       => $rowMYSQL06['funcionario_actividad_estado_codigo'],
                        'funcionario_actividad_estado_nombre'                       => $estado_nombre,
                        'funcionario_actividad_movilidad_codigo'                    => strtoupper($rowMYSQL06['funcionario_actividad_movilidad_codigo']),
                        'funcionario_actividad_hobbie_especificar'                  => strtoupper($rowMYSQL06['funcionario_actividad_hobbie_especificar']),
                        'funcionario_actividad_proyecto_especificar'                => strtoupper($rowMYSQL06['funcionario_actividad_proyecto_especificar']),
                        'funcionario_actividad_cantidad_dependiente'                => strtoupper($rowMYSQL06['funcionario_actividad_cantidad_dependiente']),
                        'funcionario_actividad_cantidad_contribuyente'              => strtoupper($rowMYSQL06['funcionario_actividad_cantidad_contribuyente']),
                        'funcionario_actividad_tiempo_traslado'                     => strtoupper($rowMYSQL06['funcionario_actividad_tiempo_traslado']),
                        'funcionario_actividad_observacion'                         => strtoupper($rowMYSQL06['funcionario_actividad_observacion']),
                        'funcionario_actividad_hobbie_codigo'                       => $rowMYSQL06['funcionario_actividad_hobbie_codigo'],
                        'funcionario_actividad_hobbis_nombre'                       => strtoupper($rowMYSQL06['funcionario_actividad_hobbis_nombre']),
                        'funcionario_actividad_proyecto_codigo'                     => $rowMYSQL06['funcionario_actividad_proyecto_codigo'],
                        'funcionario_actividad_proyecto_nombre'                     => strtoupper($rowMYSQL06['funcionario_actividad_proyecto_nombre']),
                        'auditoria_usuario'                                         => strtoupper($rowMYSQL06['auditoria_usuario']),
                        'auditoria_fecha'                                           => date("d/m/Y", strtotime($rowMYSQL06['auditoria_fecha'])),
                        'auditoria_ip'                                              => strtoupper($rowMYSQL06['auditoria_ip'])      
                    );

                    $result_funcionario_actividad[]   = $detalle;
                }

                if (!isset($result_funcionario_actividad)){
                    $detalle    = array(
                        'funcionario_actividad_codigo'                              => '',
                        'funcionario_actividad_estado_codigo'                       => '',
                        'funcionario_actividad_estado_nombre'                       => '',
                        'funcionario_actividad_movilidad_codigo'                    => '',
                        'funcionario_actividad_hobbie_especificar'                  => '',
                        'funcionario_actividad_proyecto_especificar'                => '',
                        'funcionario_actividad_cantidad_dependiente'                => '',
                        'funcionario_actividad_cantidad_contribuyente'              => '',
                        'funcionario_actividad_tiempo_traslado'                     => '',
                        'funcionario_actividad_observacion'                         => '',
                        'funcionario_actividad_hobbie_codigo'                       => '',
                        'funcionario_actividad_hobbis_nombre'                       => '',
                        'funcionario_actividad_proyecto_codigo'                     => '',
                        'funcionario_actividad_proyecto_nombre'                     => '',
                        'auditoria_usuario'                                         => '',
                        'auditoria_fecha'                                           => '',
                        'auditoria_ip'                                              => ''
                    );

                    $result_funcionario_actividad[]   = $detalle;
                }

                $stmtMYSQL07= $connMYSQL->prepare($sql07);
                $stmtMYSQL07->execute([$val01]);

                while ($rowMYSQL07 = $stmtMYSQL07->fetch()) {
                    if($rowMYSQL07['funcionario_familiares_estado_codigo'] === 'A'){
                        $estado_nombre = 'ACTIVO';
                    } else {
                        $estado_nombre = 'INACTIVO';
                    }

                    $detalle    = array(
                        'funcionario_familiares_codigo'                             => $rowMYSQL07['funcionario_familiares_codigo'],
                        'funcionario_familiares_estado_codigo'                      => $rowMYSQL07['funcionario_familiares_estado_codigo'],
                        'funcionario_familiares_estado_nombre'                      => $estado_nombre,
                        'funcionario_familiares_nombre'                             => strtoupper($rowMYSQL07['funcionario_familiares_nombre']),
                        'funcionario_familiares_apellido'                           => strtoupper($rowMYSQL07['funcionario_familiares_apellido']),
                        'funcionario_familiares_completo'                           => strtoupper($rowMYSQL07['funcionario_familiares_nombre']).', '.strtoupper($rowMYSQL07['funcionario_familiares_apellido']),
                        'funcionario_familiares_documento_numero'                   => strtoupper($rowMYSQL07['funcionario_familiares_documento_numero']),
                        'funcionario_familiares_fecha_nacimiento'                   => date("Y-m-d", strtotime($rowMYSQL07['funcionario_familiares_fecha_nacimiento'])),
                        'funcionario_familiares_empresa'                            => strtoupper($rowMYSQL07['funcionario_familiares_empresa']),
                        'funcionario_familiares_ocupacion'                          => strtoupper($rowMYSQL07['funcionario_familiares_ocupacion']),
                        'funcionario_familiares_celular_codigo'                     => $rowMYSQL07['funcionario_familiares_celular_codigo'],
                        'funcionario_familiares_celular_nombre'                     => strtoupper($rowMYSQL07['funcionario_familiares_celular_nombre']),
                        'funcionario_familiares_celular_numero'                     => strtoupper($rowMYSQL07['funcionario_familiares_celular_numero']),
                        'funcionario_familiares_telefono_codigo'                    => $rowMYSQL07['funcionario_familiares_telefono_codigo'],
                        'funcionario_familiares_telefono_nombre'                    => strtoupper($rowMYSQL07['funcionario_familiares_telefono_nombre']),
                        'funcionario_familiares_telefono_numero'                    => strtoupper($rowMYSQL07['funcionario_familiares_telefono_numero']),
                        'funcionario_familiares_observacion'                        => strtoupper($rowMYSQL07['funcionario_familiares_observacion']),
                        'funcionario_familiares_parentezco_codigo'                  => $rowMYSQL07['funcionario_familiares_parentezco_codigo'],
                        'funcionario_familiares_parentezco_nombre'                  => strtoupper($rowMYSQL07['funcionario_familiares_parentezco_nombre']),
                        'auditoria_usuario'                                         => strtoupper($rowMYSQL07['auditoria_usuario']),
                        'auditoria_fecha'                                           => date("d/m/Y", strtotime($rowMYSQL07['auditoria_fecha'])),
                        'auditoria_ip'                                              => strtoupper($rowMYSQL07['auditoria_ip'])         
                    );

                    $result_funcionario_familiares[]   = $detalle;
                }

                if (!isset($result_funcionario_familiares)){
                    $detalle    = array(
                        'funcionario_familiares_codigo'                             => '',
                        'funcionario_familiares_estado_codigo'                      => '',
                        'funcionario_familiares_estado_nombre'                      => '',
                        'funcionario_familiares_nombre'                             => '',
                        'funcionario_familiares_apellido'                           => '',
                        'funcionario_familiares_completo'                           => '',
                        'funcionario_familiares_documento_numero'                   => '',
                        'funcionario_familiares_fecha_nacimiento'                   => '',
                        'funcionario_familiares_empresa'                            => '',
                        'funcionario_familiares_ocupacion'                          => '',
                        'funcionario_familiares_celular_codigo'                     => '',
                        'funcionario_familiares_celular_nombre'                     => '',
                        'funcionario_familiares_celular_numero'                     => '',
                        'funcionario_familiares_telefono_codigo'                    => '',
                        'funcionario_familiares_telefono_nombre'                    => '',
                        'funcionario_familiares_telefono_numero'                    => '',
                        'funcionario_familiares_observacion'                        => '',
                        'funcionario_familiares_parentezco_codigo'                  => '',
                        'funcionario_familiares_parentezco_nombre'                  => '',
                        'auditoria_usuario'                                         => '',
                        'auditoria_fecha'                                           => '',
                        'auditoria_ip'                                              => ''
                    );

                    $result_funcionario_familiares[]   = $detalle;
                }

                $stmtMYSQL08= $connMYSQL->prepare($sql08);
                $stmtMYSQL08->execute([$val01]);

                while ($rowMYSQL08 = $stmtMYSQL08->fetch()) {
                    if($rowMYSQL08['funcionario_movil_estado_codigo'] === 'A'){
                        $estado_nombre = 'ACTIVO';
                    } else {
                        $estado_nombre = 'INACTIVO';
                    }

                    $detalle    = array(
                        'funcionario_movil_codigo'                                  => $rowMYSQL08['funcionario_movil_codigo'],
                        'funcionario_movil_estado_codigo'                           => $rowMYSQL08['funcionario_movil_estado_codigo'],
                        'funcionario_movil_estado_nombre'                           => $estado_nombre,
                        'funcionario_movil_modelo'                                  => strtoupper($rowMYSQL08['funcionario_movil_modelo']),
                        'funcionario_movil_anho_compra'                             => strtoupper($rowMYSQL08['funcionario_movil_anho_compra']),
                        'funcionario_movil_observacion'                             => strtoupper($rowMYSQL08['funcionario_movil_observacion']),
                        'funcionario_movil_marca_codigo'                            => $rowMYSQL08['funcionario_movil_marca_codigo'],
                        'funcionario_movil_marca_nombre'                            => strtoupper($rowMYSQL08['funcionario_movil_marca_nombre']),
                        'funcionario_movil_color_codigo'                            => $rowMYSQL08['funcionario_movil_color_codigo'],
                        'funcionario_movil_color_nombre'                            => strtoupper($rowMYSQL08['funcionario_movil_color_nombre']),
                        'auditoria_usuario'                                         => strtoupper($rowMYSQL08['auditoria_usuario']),
                        'auditoria_fecha'                                           => date("d/m/Y", strtotime($rowMYSQL08['auditoria_fecha'])),
                        'auditoria_ip'                                              => strtoupper($rowMYSQL08['auditoria_ip'])       
                    );

                    $result_funcionario_movil[]   = $detalle;
                }

                if (!isset($result_funcionario_movil)){
                    $detalle    = array(
                        'funcionario_movil_codigo'                                  => '',
                        'funcionario_movil_estado_codigo'                           => '',
                        'funcionario_movil_estado_nombre'                           => '',
                        'funcionario_movil_modelo'                                  => '',
                        'funcionario_movil_anho_compra'                             => '',
                        'funcionario_movil_observacion'                             => '',
                        'funcionario_movil_marca_codigo'                            => '',
                        'funcionario_movil_marca_nombre'                            => '',
                        'funcionario_movil_color_codigo'                            => '',
                        'funcionario_movil_color_nombre'                            => '',
                        'auditoria_usuario'                                         => '',
                        'auditoria_fecha'                                           => '',
                        'auditoria_ip'                                              => ''
                    );

                    $result_funcionario_movil[]   = $detalle;
                }

                $stmtMYSQL09= $connMYSQL->prepare($sql09);
                $stmtMYSQL09->execute([$val01]);

                while ($rowMYSQL09 = $stmtMYSQL09->fetch()) {
                    switch ($rowMYSQL09['funcionario_datos_estado_codigo']) {
                        case 'A':
                            $estado_nombre = 'ACTIVO';
                            break;
                        
                        case 'P':
                                $estado_nombre = 'PENDIENTE';
                                break;

                        default:
                            $estado_nombre = 'INACTIVO';
                            break;
                    }

                    $str                            = trim($rowMYSQL09['funcionario_datos_nombre']);
                    $pos                            = strpos($str, ' ');
                    $funcionario_datos_nombre_1     = substr($str, 0, $pos);
                    $funcionario_datos_nombre_2     = substr($str, ($pos + 1));

                    $str                            = trim($rowMYSQL09['funcionario_datos_apellido']);
                    $pos                            = strpos($str, ' ');
                    $funcionario_datos_apellido_1   = substr($str, 0, $pos);
                    $funcionario_datos_apellido_2   = substr($str, ($pos + 1));

                    $detalle    = array(
                        'funcionario_datos_codigo'                                  => $rowMYSQL09['funcionario_datos_codigo'],
                        'funcionario_datos_estado_codigo'                           => $rowMYSQL09['funcionario_datos_estado_codigo'],
                        'funcionario_datos_estado_nombre'                           => $estado_nombre,
                        'funcionario_datos_nombre_1'                                => strtoupper($funcionario_datos_nombre_1),
                        'funcionario_datos_nombre_2'                                => strtoupper($funcionario_datos_nombre_2),
                        'funcionario_datos_apellido_1'                              => strtoupper($funcionario_datos_apellido_1),
                        'funcionario_datos_apellido_2'                              => strtoupper($funcionario_datos_apellido_2),
                        'funcionario_datos_documento_numero'                        => strtoupper($rowMYSQL09['funcionario_datos_documento_numero']),
                        'funcionario_datos_fecha_nacimiento'                        => date("Y-m-d", strtotime($rowMYSQL09['funcionario_datos_fecha_nacimiento'])),
                        'funcionario_datos_email'                                   => strtolower($rowMYSQL09['funcionario_datos_email']),
                        'funcionario_datos_foto'                                    => strtolower($rowMYSQL09['funcionario_datos_foto']),
                        'funcionario_datos_observacion'                             => strtoupper($rowMYSQL09['funcionario_datos_observacion']),
                        'funcionario_datos_documento_codigo'                        => $rowMYSQL09['funcionario_datos_documento_codigo'],
                        'funcionario_datos_documento_nombre'                        => strtoupper($rowMYSQL09['funcionario_datos_documento_nombre']),
                        'funcionario_datos_documento_vencimiento'                   => date("Y-m-d", strtotime($rowMYSQL09['funcionario_datos_documento_vencimiento'])),
                        'funcionario_datos_sexo_codigo'                             => $rowMYSQL09['funcionario_datos_sexo_codigo'],
                        'funcionario_datos_sexo_nombre'                             => strtoupper($rowMYSQL09['funcionario_datos_sexo_nombre']),
                        'funcionario_datos_estado_civil_codigo'                     => $rowMYSQL09['funcionario_datos_estado_civil_codigo'],
                        'funcionario_datos_estado_civil_nombre'                     => strtoupper($rowMYSQL09['funcionario_datos_estado_civil_nombre']),
                        'funcionario_datos_nacionalidad_codigo'                     => $rowMYSQL09['funcionario_datos_nacionalidad_codigo'],
                        'funcionario_datos_nacionalidad_nombre'                     => strtoupper($rowMYSQL09['funcionario_datos_nacionalidad_nombre']),
                        'auditoria_usuario'                                         => strtoupper($rowMYSQL09['auditoria_usuario']),
                        'auditoria_fecha'                                           => date("d/m/Y", strtotime($rowMYSQL09['auditoria_fecha'])),
                        'auditoria_ip'                                              => strtoupper($rowMYSQL09['auditoria_ip'])      
                    );

                    $result_funcionario_datos[]   = $detalle;
                }

                if (!isset($result_funcionario_datos)){
                    $detalle    = array(
                        'funcionario_datos_codigo'                                  => '',
                        'funcionario_datos_estado_codigo'                           => '',
                        'funcionario_datos_estado_nombre'                           => '',
                        'funcionario_datos_nombre_1'                                => '',
                        'funcionario_datos_nombre_2'                                => '',
                        'funcionario_datos_apellido_1'                              => '',
                        'funcionario_datos_apellido_2'                              => '',
                        'funcionario_datos_documento_numero'                        => '',
                        'funcionario_datos_documento_vencimiento'                   => '',
                        'funcionario_datos_fecha_nacimiento'                        => '',
                        'funcionario_datos_email'                                   => '',
                        'funcionario_datos_foto'                                    => '',
                        'funcionario_datos_observacion'                             => '',
                        'funcionario_datos_documento_codigo'                        => '',
                        'funcionario_datos_documento_nombre'                        => '',
                        'funcionario_datos_sexo_codigo'                             => '',
                        'funcionario_datos_sexo_nombre'                             => '',
                        'funcionario_datos_estado_civil_codigo'                     => '',
                        'funcionario_datos_estado_civil_nombre'                     => '',
                        'funcionario_datos_nacionalidad_codigo'                     => '',
                        'funcionario_datos_nacionalidad_nombre'                     => '',
                        'auditoria_usuario'                                         => '',
                        'auditoria_fecha'                                           => '',
                        'auditoria_ip'                                              => ''
                    );

                    $result_funcionario_datos[]   = $detalle;
                }

                $stmtMYSQL10= $connMYSQL->prepare($sql10);
                $stmtMYSQL10->execute([$val01]);

                while ($rowMYSQL10 = $stmtMYSQL10->fetch()) {
                    if($rowMYSQL10['funcionario_academico_estado_codigo'] === 'A'){
                        $estado_nombre = 'ACTIVO';
                    } else {
                        $estado_nombre = 'INACTIVO';
                    }

                    $detalle    = array(
                        'funcionario_academico_codigo'                              => $rowMYSQL10['funcionario_academico_codigo'],
                        'funcionario_academico_estado_codigo'                       => $rowMYSQL10['funcionario_academico_estado_codigo'],
                        'funcionario_academico_estado_nombre'                       => $estado_nombre,
                        'funcionario_academico_observacion'                         => strtoupper($rowMYSQL10['funcionario_academico_observacion']),
                        'funcionario_academico_universidad_codigo'                  => $rowMYSQL10['funcionario_academico_universidad_codigo'],
                        'funcionario_academico_universidad_nombre'                  => strtoupper($rowMYSQL10['funcionario_academico_universidad_nombre']),
                        'funcionario_academico_carrera_codigo'                      => $rowMYSQL10['funcionario_academico_carrera_codigo'],
                        'funcionario_academico_carrera_nombre'                      => strtoupper($rowMYSQL10['funcionario_academico_carrera_nombre']),
                        'funcionario_academico_grado_academico_codigo'              => $rowMYSQL10['funcionario_academico_grado_academico_codigo'],
                        'funcionario_academico_grado_academico_nombre'              => strtoupper($rowMYSQL10['funcionario_academico_grado_academico_nombre']),
                        'funcionario_academico_grado_estado_codigo'                 => $rowMYSQL10['funcionario_academico_grado_estado_codigo'],
                        'funcionario_academico_grado_estado_nombre'                 => strtoupper($rowMYSQL10['funcionario_academico_grado_estado_nombre']),
                        'auditoria_usuario'                                         => strtoupper($rowMYSQL10['auditoria_usuario']),
                        'auditoria_fecha'                                           => date("d/m/Y", strtotime($rowMYSQL10['auditoria_fecha'])),
                        'auditoria_ip'                                              => strtoupper($rowMYSQL10['auditoria_ip'])       
                    );

                    $result_funcionario_academico[]   = $detalle;
                }

                if (!isset($result_funcionario_academico)){
                    $detalle    = array(
                        'funcionario_academico_codigo'                              => '',
                        'funcionario_academico_estado_codigo'                       => '',
                        'funcionario_academico_estado_nombre'                       => '',
                        'funcionario_academico_observacion'                         => '',
                        'funcionario_academico_universidad_codigo'                  => '',
                        'funcionario_academico_universidad_nombre'                  => '',
                        'funcionario_academico_carrera_codigo'                      => '',
                        'funcionario_academico_carrera_nombre'                      => '',
                        'funcionario_academico_grado_academico_codigo'              => '',
                        'funcionario_academico_grado_academico_nombre'              => '',
                        'funcionario_academico_grado_estado_codigo'                 => '',
                        'funcionario_academico_grado_estado_nombre'                 => '',
                        'auditoria_usuario'                                         => '',
                        'auditoria_fecha'                                           => '',
                        'auditoria_ip'                                              => ''
                    );

                    $result_funcionario_academico[]   = $detalle;
                }

                $stmtMYSQL11= $connMYSQL->prepare($sql11);
                $stmtMYSQL11->execute([$val01]);

                while ($rowMYSQL11 = $stmtMYSQL11->fetch()) {
                    if($rowMYSQL11['funcionario_capacitacion_estado_codigo'] === 'A'){
                        $estado_nombre = 'ACTIVO';
                    } else {
                        $estado_nombre = 'INACTIVO';
                    }

                    $detalle    = array(
                        'funcionario_capacitacion_codigo'                           => $rowMYSQL11['funcionario_capacitacion_codigo'],
                        'funcionario_capacitacion_estado_codigo'                    => $rowMYSQL11['funcionario_capacitacion_estado_codigo'],
                        'funcionario_capacitacion_estado_nombre'                    => $estado_nombre,
                        'funcionario_capacitacion_empresa'                          => strtoupper($rowMYSQL11['funcionario_capacitacion_empresa']),
                        'funcionario_capacitacion_curso'                            => strtoupper($rowMYSQL11['funcionario_capacitacion_curso']),
                        'funcionario_capacitacion_periodo'                          => strtoupper($rowMYSQL11['funcionario_capacitacion_periodo']),
                        'funcionario_capacitacion_observacion'                      => strtoupper($rowMYSQL11['funcionario_capacitacion_observacion']),
                        'auditoria_usuario'                                         => strtoupper($rowMYSQL11['auditoria_usuario']),
                        'auditoria_fecha'                                           => date("d/m/Y", strtotime($rowMYSQL11['auditoria_fecha'])),
                        'auditoria_ip'                                              => strtoupper($rowMYSQL11['auditoria_ip'])
                    );

                    $result_funcionario_capacitacion[]   = $detalle;
                }

                if (!isset($result_funcionario_capacitacion)){
                    $detalle    = array(
                        'funcionario_capacitacion_codigo'                           => '',
                        'funcionario_capacitacion_estado_codigo'                    => '',
                        'funcionario_capacitacion_estado_nombre'                    => '',
                        'funcionario_capacitacion_empresa'                          => '',
                        'funcionario_capacitacion_curso'                            => '',
                        'funcionario_capacitacion_periodo'                          => '',
                        'funcionario_capacitacion_observacion'                      => '',
                        'auditoria_usuario'                                         => '',
                        'auditoria_fecha'                                           => '',
                        'auditoria_ip'                                              => ''
                    );

                    $result_funcionario_capacitacion[]   = $detalle;
                }

                $result = array(
                    'funcionario'                       => $result_funcionario,
                    'funcionario_datos'                 => $result_funcionario_datos,
                    'funcionario_trabajo_anterior'      => $result_funcionario_trabajo_anterior,
                    'funcionario_actividad_economica'   => $result_funcionario_actividad_economica,
                    'funcionario_particulares'          => $result_funcionario_particulares,
                    'funcionario_referencia'            => $result_funcionario_referencia,
                    'funcionario_actividad'             => $result_funcionario_actividad,
                    'funcionario_familiares'            => $result_funcionario_familiares,
                    'funcionario_movil'                 => $result_funcionario_movil,
                    'funcionario_academico'             => $result_funcionario_academico,
                    'funcionario_capacitacion'          => $result_funcionario_capacitacion,
                );

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'funcionario_codigo'                    => '',
                        'funcionario_usuario'                   => '',
                        'funcionario_completo'                  => '',
                        'funcionario_documento'                 => '',
                        'funcionario_fecha_nacimiento'          => '',
                        'funcionario_edad'                      => '',
                        'funcionario_sexo'                      => '',
                        'funcionario_estado_civil'              => '',
                        'funcionario_nacionalidad'              => '',
                        'funcionario_email'                     => '',
                        'funcionario_fecha_ingreso'             => '',
                        'funcionario_gerencia'                  => '',
                        'funcionario_deparmento'                => '',
                        'funcionario_cargo'                     => '',
                        'funcionario_foto'                      => '../assets/images/users/photo.png',
                        'funcionario_antiguedad'                => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;

                $stmtMYSQL02->closeCursor();
                $stmtMYSQL02 = null;

                $stmtMYSQL03->closeCursor();
                $stmtMYSQL03 = null;

                $stmtMYSQL04->closeCursor();
                $stmtMYSQL04 = null;

                $stmtMYSQL05->closeCursor();
                $stmtMYSQL05 = null;

                $stmtMYSQL06->closeCursor();
                $stmtMYSQL06 = null;

                $stmtMYSQL07->closeCursor();
                $stmtMYSQL07 = null;

                $stmtMYSQL08->closeCursor();
                $stmtMYSQL08 = null;

                $stmtMYSQL09->closeCursor();
                $stmtMYSQL09 = null;

                $stmtMYSQL10->closeCursor();
                $stmtMYSQL10 = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        $connMYSQL  = null;
        
        return $json;
    });

    $app->get('/v1/500', function($request) {
        require __DIR__.'/../src/connect.php';

        $sql00  = "SELECT
        a.AiDept            AS          departamento_codigo,
        a.AiNomb            AS          departamento_nombre

        FROM FST004 a
        
        ORDER BY a.AiNomb";

        try {
            $connMSSQL  = getConnectionMSSQL();
            $stmtMSSQL  = $connMSSQL->prepare($sql00);
            $stmtMSSQL->execute(); 

            while ($rowMSSQL = $stmtMSSQL->fetch()) {
                $detalle    = array(
                    'departamento_codigo'           => $rowMSSQL['departamento_codigo'],
                    'departamento_nombre'           => trim(strtoupper($rowMSSQL['departamento_nombre']))
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle = array(
                    'departamento_codigo'           => '',
                    'departamento_nombre'           => ''
                );

                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }

            $stmtMSSQL->closeCursor();
            $stmtMSSQL = null;
        } catch (PDOException $e) {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v1/500/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.AiDept            AS          departamento_codigo,
            a.AiNomb            AS          departamento_nombre

            FROM FST004 a

            WHERE a.AiDept = ?
            
            ORDER BY a.AiNomb";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $detalle    = array(
                        'departamento_codigo'           => $rowMSSQL['departamento_codigo'],
                        'departamento_nombre'           => trim(strtoupper($rowMSSQL['departamento_nombre']))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'departamento_codigo'           => '',
                        'departamento_nombre'           => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v1/600', function($request) {
        require __DIR__.'/../src/connect.php';

        $sql00  = "SELECT
        a.ApCiud            AS          ciudad_codigo,
        a.ApNomb            AS          ciudad_nombre,

        b.AiDept            AS          departamento_codigo,
        b.AiNomb            AS          departamento_nombre

        FROM FST003 a
        INNER JOIN FST004 b ON a.AiDept = b.AiDept
        
        ORDER BY b.AiNomb, a.ApNomb";

        try {
            $connMSSQL  = getConnectionMSSQL();
            $stmtMSSQL  = $connMSSQL->prepare($sql00);
            $stmtMSSQL->execute(); 

            while ($rowMSSQL = $stmtMSSQL->fetch()) {
                $detalle    = array(
                    'departamento_codigo'           => $rowMSSQL['departamento_codigo'],
                    'departamento_nombre'           => trim(strtoupper($rowMSSQL['departamento_nombre'])),
                    'ciudad_codigo'                 => $rowMSSQL['ciudad_codigo'],
                    'ciudad_nombre'                 => trim(strtoupper($rowMSSQL['ciudad_nombre']))
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle = array(
                    'departamento_codigo'           => '',
                    'departamento_nombre'           => '',
                    'ciudad_codigo'                 => '',
                    'ciudad_nombre'                 => ''
                );

                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }

            $stmtMSSQL->closeCursor();
            $stmtMSSQL = null;
        } catch (PDOException $e) {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v1/600/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.ApCiud            AS          ciudad_codigo,
            a.ApNomb            AS          ciudad_nombre,

            b.AiDept            AS          departamento_codigo,
            b.AiNomb            AS          departamento_nombre

            FROM FST003 a
            INNER JOIN FST004 b ON a.AiDept = b.AiDept

            WHERE a.ApCiud = ?
            
            ORDER BY b.AiNomb, a.ApNomb";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $detalle    = array(
                        'departamento_codigo'           => $rowMSSQL['departamento_codigo'],
                        'departamento_nombre'           => trim(strtoupper($rowMSSQL['departamento_nombre'])),
                        'ciudad_codigo'                 => $rowMSSQL['ciudad_codigo'],
                        'ciudad_nombre'                 => trim(strtoupper($rowMSSQL['ciudad_nombre']))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'departamento_codigo'           => '',
                        'departamento_nombre'           => '',
                        'ciudad_codigo'                 => '',
                        'ciudad_nombre'                 => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v1/650', function($request) {
        require __DIR__.'/../src/connect.php';

        $sql00  = "SELECT
        a.AjBarr            AS          barrio_codigo,
        a.AjNomb            AS          barrio_nombre,

        b.ApCiud            AS          ciudad_codigo,
        b.ApNomb            AS          ciudad_nombre,

        c.AiDept            AS          departamento_codigo,
        c.AiNomb            AS          departamento_nombre

        FROM FST0051 a
        INNER JOIN FST003 b ON a.ApCiud = b.ApCiud
        INNER JOIN FST004 c ON b.AiDept = c.AiDept
        
        ORDER BY c.AiNomb, b.ApNomb, a.AjNomb";

        try {
            $connMSSQL  = getConnectionMSSQL();
            $stmtMSSQL  = $connMSSQL->prepare($sql00);
            $stmtMSSQL->execute(); 

            while ($rowMSSQL = $stmtMSSQL->fetch()) {
                $detalle    = array(
                    'departamento_codigo'           => $rowMSSQL['departamento_codigo'],
                    'departamento_nombre'           => trim(strtoupper($rowMSSQL['departamento_nombre'])),
                    'ciudad_codigo'                 => $rowMSSQL['ciudad_codigo'],
                    'ciudad_nombre'                 => trim(strtoupper($rowMSSQL['ciudad_nombre'])),
                    'barrio_codigo'                 => $rowMSSQL['barrio_codigo'],
                    'barrio_nombre'                 => trim(strtoupper($rowMSSQL['barrio_nombre']))
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle = array(
                    'departamento_codigo'           => '',
                    'departamento_nombre'           => '',
                    'ciudad_codigo'                 => '',
                    'ciudad_nombre'                 => '',
                    'barrio_codigo'                 => '',
                    'barrio_nombre'                 => ''
                );

                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }

            $stmtMSSQL->closeCursor();
            $stmtMSSQL = null;
        } catch (PDOException $e) {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v1/650/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.AjBarr            AS          barrio_codigo,
            a.AjNomb            AS          barrio_nombre,

            b.ApCiud            AS          ciudad_codigo,
            b.ApNomb            AS          ciudad_nombre,

            c.AiDept            AS          departamento_codigo,
            c.AiNomb            AS          departamento_nombre

            FROM FST0051 a
            INNER JOIN FST003 b ON a.ApCiud = b.ApCiud
            INNER JOIN FST004 c ON b.AiDept = c.AiDept

            WHERE a.AjBarr = ?
            
            ORDER BY c.AiNomb, b.ApNomb, a.AjNomb";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $detalle    = array(
                        'departamento_codigo'           => $rowMSSQL['departamento_codigo'],
                        'departamento_nombre'           => trim(strtoupper($rowMSSQL['departamento_nombre'])),
                        'ciudad_codigo'                 => $rowMSSQL['ciudad_codigo'],
                        'ciudad_nombre'                 => trim(strtoupper($rowMSSQL['ciudad_nombre'])),
                        'barrio_codigo'                 => $rowMSSQL['barrio_codigo'],
                        'barrio_nombre'                 => trim(strtoupper($rowMSSQL['barrio_nombre']))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'departamento_codigo'           => '',
                        'departamento_nombre'           => '',
                        'ciudad_codigo'                 => '',
                        'ciudad_nombre'                 => '',
                        'barrio_codigo'                 => '',
                        'barrio_nombre'                 => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v1/650/{departamento}/{ciudad}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getAttribute('departamento');
        $val02      = $request->getAttribute('ciudad');
        
        if (isset($val01) && isset($val02)) {
            $sql00  = "SELECT
            a.AjBarr            AS          barrio_codigo,
            a.AjNomb            AS          barrio_nombre,

            b.ApCiud            AS          ciudad_codigo,
            b.ApNomb            AS          ciudad_nombre,

            c.AiDept            AS          departamento_codigo,
            c.AiNomb            AS          departamento_nombre

            FROM FST0051 a
            INNER JOIN FST003 b ON a.ApCiud = b.ApCiud
            INNER JOIN FST004 c ON b.AiDept = c.AiDept

            WHERE c.AiDept = ? AND b.ApCiud = ?
            
            ORDER BY c.AiNomb, b.ApNomb, a.AjNomb";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01, $val02]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $detalle    = array(
                        'departamento_codigo'           => $rowMSSQL['departamento_codigo'],
                        'departamento_nombre'           => trim(strtoupper($rowMSSQL['departamento_nombre'])),
                        'ciudad_codigo'                 => $rowMSSQL['ciudad_codigo'],
                        'ciudad_nombre'                 => trim(strtoupper($rowMSSQL['ciudad_nombre'])),
                        'barrio_codigo'                 => $rowMSSQL['barrio_codigo'],
                        'barrio_nombre'                 => trim(strtoupper($rowMSSQL['barrio_nombre']))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'departamento_codigo'           => '',
                        'departamento_nombre'           => '',
                        'ciudad_codigo'                 => '',
                        'ciudad_nombre'                 => '',
                        'barrio_codigo'                 => '',
                        'barrio_nombre'                 => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v1/700', function($request) {
        require __DIR__.'/../src/connect.php';

        $sql00  = "SELECT
        a.ECCod         AS          estado_civil_codigo,
        a.ECDsc         AS          estado_civil_nombre

        FROM ESTCIV a
        
        ORDER BY a.ECDsc";

        try {
            $connMSSQL  = getConnectionMSSQL();
            $stmtMSSQL  = $connMSSQL->prepare($sql00);
            $stmtMSSQL->execute(); 

            while ($rowMSSQL = $stmtMSSQL->fetch()) {
                $detalle    = array(
                    'estado_civil_codigo'           => $rowMSSQL['estado_civil_codigo'],
                    'estado_civil_nombre'           => strtoupper($rowMSSQL['estado_civil_nombre'])
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle = array(
                    'estado_civil_codigo'           => '',
                    'estado_civil_nombre'           => ''
                );

                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }

            $stmtMSSQL->closeCursor();
            $stmtMSSQL = null;
        } catch (PDOException $e) {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v1/700/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.ECCod         AS          estado_civil_codigo,
            a.ECDsc         AS          estado_civil_nombre

            FROM ESTCIV a

            WHERE a.ECCod = ?
            
            ORDER BY a.ECDsc";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $detalle    = array(
                        'estado_civil_codigo'           => $rowMSSQL['estado_civil_codigo'],
                        'estado_civil_nombre'           => strtoupper($rowMSSQL['estado_civil_nombre'])
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'estado_civil_codigo'           => '',
                        'estado_civil_nombre'           => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v1/800', function($request) {
        require __DIR__.'/../src/connect.php';

        $sql00  = "SELECT
        a.FuDesvCod             AS          motivo_despido_codigo,
        a.FuDesvDesc            AS          motivo_despido_nombre

        FROM FUMOTDESV a

        WHERE a.FuDesvDesc IS NOT NULL
        
        ORDER BY a.FuDesvDesc";

        try {
            $connMSSQL  = getConnectionMSSQL();
            $stmtMSSQL  = $connMSSQL->prepare($sql00);
            $stmtMSSQL->execute(); 

            while ($rowMSSQL = $stmtMSSQL->fetch()) {
                $detalle    = array(
                    'motivo_despido_codigo'         => $rowMSSQL['motivo_despido_codigo'],
                    'motivo_despido_nombre'         => strtoupper($rowMSSQL['motivo_despido_nombre'])
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle = array(
                    'motivo_despido_codigo'         => '',
                    'motivo_despido_nombre'         => ''
                );

                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }

            $stmtMSSQL->closeCursor();
            $stmtMSSQL = null;
        } catch (PDOException $e) {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v1/800/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.FuDesvCod             AS          motivo_despido_codigo,
            a.FuDesvDesc            AS          motivo_despido_nombre

            FROM FUMOTDESV a

            WHERE a.FuDesvDesc IS NOT NULL AND a.FuDesvCod = ?
            
            ORDER BY a.FuDesvDesc";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $detalle    = array(
                        'motivo_despido_codigo'         => $rowMSSQL['motivo_despido_codigo'],
                        'motivo_despido_nombre'         => strtoupper($rowMSSQL['motivo_despido_nombre'])
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'motivo_despido_codigo'         => '',
                        'motivo_despido_nombre'         => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v1/900', function($request) {
        require __DIR__.'/../src/connect.php';

        $sql00  = "SELECT
        a.RRHH231ID             AS          hobbies_codigo,
        a.RRHH231DSC            AS          hobbies_nombre

        FROM RRHH231 a
        
        ORDER BY a.RRHH231ID";

        try {
            $connMSSQL  = getConnectionMSSQL();
            $stmtMSSQL  = $connMSSQL->prepare($sql00);
            $stmtMSSQL->execute(); 

            while ($rowMSSQL = $stmtMSSQL->fetch()) {
                $detalle    = array(
                    'hobbies_codigo'            => $rowMSSQL['hobbies_codigo'],
                    'hobbies_nombre'            => strtoupper($rowMSSQL['hobbies_nombre'])
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle = array(
                    'hobbies_codigo'            => '',
                    'hobbies_nombre'            => ''
                );

                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }

            $stmtMSSQL->closeCursor();
            $stmtMSSQL = null;
        } catch (PDOException $e) {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v1/900/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.RRHH231ID             AS          hobbies_codigo,
            a.RRHH231DSC            AS          hobbies_nombre

            FROM RRHH231 a

            WHERE a.RRHH231ID = ?
            
            ORDER BY a.RRHH231ID";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $detalle    = array(
                        'hobbies_codigo'            => $rowMSSQL['hobbies_codigo'],
                        'hobbies_nombre'            => strtoupper($rowMSSQL['hobbies_nombre'])
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'hobbies_codigo'            => '',
                        'hobbies_nombre'            => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v1/1000', function($request) {
        require __DIR__.'/../src/connect.php';

        $sql00  = "SELECT
        a.FGPARAMNUM            AS          parentezco_codigo,
        a.FGPARAMVC             AS          parentezco_nombre

        FROM FGPARAM a

        WHERE a.FGPARAMDES = 'Parametros de Parentezco. TH'
        
        ORDER BY a.FGPARAMNUM";

        try {
            $connMSSQL  = getConnectionMSSQL();
            $stmtMSSQL  = $connMSSQL->prepare($sql00);
            $stmtMSSQL->execute(); 

            while ($rowMSSQL = $stmtMSSQL->fetch()) {
                $detalle    = array(
                    'parentezco_codigo'         => $rowMSSQL['parentezco_codigo'],
                    'parentezco_nombre'         => strtoupper($rowMSSQL['parentezco_nombre'])
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle = array(
                    'parentezco_codigo'         => '',
                    'parentezco_nombre'         => ''
                );

                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }

            $stmtMSSQL->closeCursor();
            $stmtMSSQL = null;
        } catch (PDOException $e) {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v1/1000/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.FGPARAMNUM            AS          parentezco_codigo,
            a.FGPARAMVC             AS          parentezco_nombre

            FROM FGPARAM a

            WHERE a.FGPARAMDES = 'Parametros de Parentezco. TH' AND a.FGPARAMNUM = ?
            
            ORDER BY a.FGPARAMNUM";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $detalle    = array(
                        'parentezco_codigo'         => $rowMSSQL['parentezco_codigo'],
                        'parentezco_nombre'         => strtoupper($rowMSSQL['parentezco_nombre'])
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'parentezco_codigo'         => '',
                        'parentezco_nombre'         => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v1/1100', function($request) {
        require __DIR__.'/../src/connect.php';

        $sql00  = "SELECT
        a.CjCar         AS          cargo_codigo,
        a.CjNom         AS          cargo_nombre,
        a.CjAbr         AS          cargo_abreviado

        FROM FST053 a
        
        ORDER BY a.CjNom";

        try {
            $connMSSQL  = getConnectionMSSQL();
            $stmtMSSQL  = $connMSSQL->prepare($sql00);
            $stmtMSSQL->execute(); 

            while ($rowMSSQL = $stmtMSSQL->fetch()) {
                $detalle    = array(
                    'cargo_codigo'              => $rowMSSQL['cargo_codigo'],
                    'cargo_nombre'              => strtoupper($rowMSSQL['cargo_nombre']),
                    'cargo_abreviado'           => strtoupper($rowMSSQL['cargo_abreviado'])
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle = array(
                    'cargo_codigo'              => '',
                    'cargo_nombre'              => '',
                    'cargo_abreviado'           => ''
                );

                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }

            $stmtMSSQL->closeCursor();
            $stmtMSSQL = null;
        } catch (PDOException $e) {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v1/1100/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.CjCar         AS          cargo_codigo,
            a.CjNom         AS          cargo_nombre,
            a.CjAbr         AS          cargo_abreviado

            FROM FST053 a

            WHERE a.CjCar = ?
            
            ORDER BY a.CjNom";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $detalle    = array(
                        'cargo_codigo'              => $rowMSSQL['cargo_codigo'],
                        'cargo_nombre'              => strtoupper($rowMSSQL['cargo_nombre']),
                        'cargo_abreviado'           => strtoupper($rowMSSQL['cargo_abreviado'])
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'cargo_codigo'              => '',
                        'cargo_nombre'              => '',
                        'cargo_abreviado'           => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v1/1200', function($request) {
        require __DIR__.'/../src/connect.php';

        $sql00  = "SELECT 
        a.BDEMPCO       AS empresa_codigo, 
        a.BDNOMBE       AS empresa_nombre 
        
        FROM FST067 a 
        
        WHERE LTRIM(RTRIM(a.BDNOMBE)) != ''
        
        ORDER BY a.BDNOMBE";

        try {
            $connMSSQL  = getConnectionMSSQL();
            $stmtMSSQL  = $connMSSQL->prepare($sql00);
            $stmtMSSQL->execute(); 

            while ($rowMSSQL = $stmtMSSQL->fetch()) {
                $empresa_nombre = trim($rowMSSQL['empresa_nombre']);
                $empresa_nombre = str_replace('"', '', $empresa_nombre);
                $empresa_nombre = str_replace('´', '', $empresa_nombre);
                $empresa_nombre = str_replace('`', '', $empresa_nombre);
                $empresa_nombre = str_replace('.', '', $empresa_nombre);
                $empresa_nombre = str_replace('*', '', $empresa_nombre);
                $empresa_nombre = str_replace('+', '', $empresa_nombre);
                $empresa_nombre = str_replace(':', '', $empresa_nombre);
                $empresa_nombre = str_replace("\n", '', $empresa_nombre);
                $empresa_nombre = str_replace("\r", '', $empresa_nombre);
                $empresa_nombre = str_replace("\n\r", '', $empresa_nombre);
                $empresa_nombre = str_replace("'", '', $empresa_nombre);

                $detalle    = array(
                    'empresa_codigo'            => $rowMSSQL['empresa_codigo'],
                    'empresa_nombre'            => strtoupper($empresa_nombre)
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle = array(
                    'empresa_codigo'            => '',
                    'empresa_nombre'            => ''
                );

                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }

            $stmtMSSQL->closeCursor();
            $stmtMSSQL = null;
        } catch (PDOException $e) {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v1/1200/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT 
            a.BDEMPCO       AS empresa_codigo, 
            a.BDNOMBE       AS empresa_nombre 
            
            FROM FST067 a 
            
            WHERE a.BDEMPCO = ? AND LTRIM(RTRIM(a.BDNOMBE)) != '' AND (BDFECALT >= GETDATE() OR BDFECMOD >= GETDATE())
            
            ORDER BY a.BDNOMBE";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $empresa_nombre = trim($rowMSSQL['empresa_nombre']);
                    $empresa_nombre = str_replace('"', '', $empresa_nombre);
                    $empresa_nombre = str_replace('´', '', $empresa_nombre);
                    $empresa_nombre = str_replace('`', '', $empresa_nombre);
                    $empresa_nombre = str_replace('.', '', $empresa_nombre);
                    $empresa_nombre = str_replace('*', '', $empresa_nombre);
                    $empresa_nombre = str_replace('+', '', $empresa_nombre);
                    $empresa_nombre = str_replace(':', '', $empresa_nombre);
                    $empresa_nombre = str_replace("\n", '', $empresa_nombre);
                    $empresa_nombre = str_replace("\r", '', $empresa_nombre);
                    $empresa_nombre = str_replace("\n\r", '', $empresa_nombre);
                    $empresa_nombre = str_replace("'", '', $empresa_nombre);

                    $detalle    = array(
                        'empresa_codigo'            => $rowMSSQL['empresa_codigo'],
                        'empresa_nombre'            => strtoupper($empresa_nombre)
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'empresa_codigo'            => '',
                        'empresa_nombre'            => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });
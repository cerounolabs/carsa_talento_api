<?php
    $app->delete('/v1/000/dominio/{codigo}', function($request) {
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

        if (isset($val00)) {
            $sql00  = "DELETE FROM DOMFIC WHERE DOMFICCOD = ?";

            try {
                $connMYSQL  = getConnectionMYSQL();
                $stmtMYSQL  = $connMYSQL->prepare($sql00);
                $stmtMYSQL->execute([$val00]); 
                
                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success DELETE', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMYSQL->closeCursor();
                $stmtMYSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error DELETE: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMYSQL  = null;
        
        return $json;
    });

    $app->delete('/v1/100/campanha/{codigo}', function($request) {
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
        
        if (isset($val00)) {
            $sql00  = "DELETE FROM CAMFIC WHERE CAMFICCOD = ?";

            try {
                $connMYSQL  = getConnectionMYSQL();
                $stmtMYSQL  = $connMYSQL->prepare($sql00);
                $stmtMYSQL->execute([$val00]); 
                
                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success DELETE', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMYSQL->closeCursor();
                $stmtMYSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error DELETE: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMYSQL  = null;
        
        return $json;
    });
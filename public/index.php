<?php
	session_start();

//	header("Access-Control-Allow-Origin: http://talento.carsa.com.py");
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
	header("Access-Control-Allow-Credentials: true");
	header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

	date_default_timezone_set('America/Asuncion');

	use \Psr\Http\Message\ServerRequestInterface as Request;
	use \Psr\Http\Message\ResponseInterface as Response;
	use \Slim\Middleware\HttpBasicAuthentication;

	require __DIR__.'/../vendor/autoload.php';
	$settings = require __DIR__.'/../src/settings.php';

	$app = new \Slim\App($settings);
	require __DIR__.'/../src/dependencies.php';

	$app->add(new \Slim\Middleware\HttpBasicAuthentication([
		"users" => [
			"th_admin" => "th_admin2020"
		]
	]));

	//ROUTES
	require __DIR__.'/../src/routes.php';

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
		})->add(basicAuth());
	
	$app->run();
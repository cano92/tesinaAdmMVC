<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

header("Access-Control-Allow-Origin: *");

require '../src/vendor/autoload.php';
require '../src/config/db.php';
require '../src/config/PDORepository.php';
require '../src/model/TesisRepository.php';
require '../src/model/UserRepository.php';
require '../src/controller/TesinaController.php';
require '../src/entity/Tesina.php';
require '../src/entity/CurlRequest.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;


$app = new \Slim\App(['settings' => $config]);

$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");

    return $response;
});


$app->get('/api/tesinas', function (Request $request, Response $response) {

    $tesinas=TesinaController::getInstance()->tesinasEnCurso();
    //echo json_encode($tesinas);
    return $response->withJson( $tesinas, 200 );
});

$app->get('/api/tesinas/{estado}', function (Request $request, Response $response,array $args) {
    $estado = $args['estado'];
    $tesinas=TesinaController::getInstance()->tesinasEstado($estado);
  
    //echo json_encode($tesinas);
    return $response->withJson( $tesinas, 200 );
});

$app->get('/api/tesinas/alumno/{legajo}', function (Request $request, Response $response,array $args) {
    $legajo = $args['legajo'];
    $tesinas=TesinaController::getInstance()->tesinasLegAlumno($legajo);
  
    //echo json_encode($tesinas);
    return $response->withJson( $tesinas, 200 );
});

$app->run();
 


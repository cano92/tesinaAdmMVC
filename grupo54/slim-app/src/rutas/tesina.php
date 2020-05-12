<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
 

$app = new \Slim\App;

// GET tesinas en curso
$app->get('/api/tesinas', function (Request $request, Response $response) {
    echo "todas las tesinas";

});

$app->run();
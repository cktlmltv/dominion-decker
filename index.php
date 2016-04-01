<?php

$composerLoader = require 'vendor/autoload.php';

require 'config.php';

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Models\Cards;
$app = new \Slim\App;
$app->get('/', function (Request $request, Response $response) {
    $oCard = new Cards();
    $expansion = $oCard->getExpansion();
    require 'App/Views/index.php';
});
$app->post('/decker/', function (Request $request, Response $response) {
    $oCard = new Cards();
    $oRes = $oCard->generateDeck();

    $aDeck = $oRes->deck;
    $allActionCards = $oRes->allActionCards;
    require 'App/Views/decker.php';
});
$app->run();

//require_once __DIR__.'/src/index.php';
?>
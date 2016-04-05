<?php

$composerLoader = require 'vendor/autoload.php';

require 'config.php';

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Models\Cards;
use \App\Classes\Decker;
$app = new \Slim\App;
$app->get('/', function (Request $request, Response $response) {
    $oCard = new Cards();
    $expansion = $oCard->getExpansion();
    require 'App/Views/index.php';
});
$app->post('/decker/', function (Request $request, Response $response) {
    $oCard = new Cards();
    $oDeck = new Decker();
    $aPref = $aExp= array();
    if(isset($_POST['expansion']))
        $aExp = $_POST['expansion'];
    if(isset($_POST['pref']))
        $aPref = $_POST['pref'];
    
    $aCards = $oCard->generateDeck($aExp);
    $oRes = $oDeck->sortDeck($aCards,$aPref);
    $aDeck = $oRes->deck;
    $allActionCards = $oRes->allActionCards;
    require 'App/Views/decker.php';
});
$app->get('/decker/', function (Request $request, Response $response) {
    echo "<pre>";
    $oCard = new Cards();
    $oDeck = new Decker();
    $aPref = $aExp= array();
    if(isset($_POST['expansion']))
        $aExp = $_POST['expansion'];
    if(isset($_POST['pref']))
        $aPref = $_POST['pref'];
    
    $aCards = $oCard->generateDeck($aExp);
    $oRes = $oDeck->sortDeck($aCards,$aPref);
    print_r($oRes);
});
$app->run();

//require_once __DIR__.'/src/index.php';
?>
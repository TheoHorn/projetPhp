<?php

use Slim\Http\Request;
use Slim\Http\Response;
use wishlist\conf\Database;
use wishlist\controleur as Control;

require_once __DIR__ . '/src/vendor/autoload.php';

Database::connect();

$c = new \Slim\Container(["settings"=>[
    "displayErrorDetails" => true]]);
$app= new \Slim\App($c);

$app->get('/', function(Request $rq, Response $rs, array $args): Response {
    return (new Control\Controleur)->acceuil($rq,$rs,$args);
});

$app->get('/item', function(Request $rq, Response $rs, array $args): Response {
    return (new Control\ItemControleur)->afficheItems($rq,$rs,$args);
});

$app->get('/item/{id}', function(Request $rq, Response $rs, array $args): Response {
    return (new Control\ItemControleur)->afficheItem($rq,$rs,$args);
});

$app->get('/liste', function(Request $rq, Response $rs, array $args): Response {
    return (new Control\ListeControleur)->afficherListes($rq,$rs,$args);
});

$app->get('/liste/new', function(Request $rq, Response $rs, array $args): Response {
    return (new Control\ListeControleur)->nouvelleListe($rq,$rs,$args);
});

$app->post('/liste/new/ajouter', function(Request $rq, Response $rs, array $args): Response {
    return (new Control\ListeControleur)->ajouterListeBdd($rq,$rs,$args);
});

$app->get('/liste/{token}', function(Request $rq, Response $rs, array $args): Response {
    return (new Control\ListeControleur)->afficherListe($rq,$rs,$args);
});

$app->get('/Connection', function(Request $rq, Response $rs, array $args): Response {
    return (new Control\Controleur)->seConnecter($rq,$rs,$args);
});

$app->get('/Inscription', function(Request $rq, Response $rs, array $args): Response {
    return (new Control\Controleur)->inscription($rq,$rs,$args);
});


try {
    $app->run();
} catch (Throwable $e) {
}
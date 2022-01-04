<?php

use Slim\Http\Request;
use Slim\Http\Response;

require_once __DIR__ . '/src/vendor/autoload.php';

\wishlist\conf\Database::connect();

$c = new \Slim\Container(["settings"=>[
    "displayErrorDetails" => true]]);
$app= new \Slim\App($c);

$app->get('/', function(Request $rq, Response $rs, array $args): Response {
    return (new \wishlist\controleur\Controleur)->acceuil($rq,$rs,$args);
});

$app->get('/item', function(Request $rq, Response $rs, array $args): Response {
    return (new wishlist\controleur\ItemControleur)->afficheItems($rq,$rs,$args);
});

$app->get('/item/{id}', function(Request $rq, Response $rs, array $args): Response {
    return (new wishlist\controleur\ItemControleur)->afficheItem($rq,$rs,$args);
});

$app->get('/liste', function(Request $rq, Response $rs, array $args): Response {
    return (new \wishlist\controleur\ListeControleur)->afficheListes($rq,$rs,$args);
});

$app->get('/liste/new', function(Request $rq, Response $rs, array $args): Response {
    return (new \wishlist\controleur\ListeControleur)->nouvelleListe($rq,$rs,$args);
});

$app->get('/liste/{token}', function(Request $rq, Response $rs, array $args): Response {
    return (new \wishlist\controleur\ListeControleur)->afficheListe($rq,$rs,$args);
});

$app->get('/Connection', function(Request $rq, Response $rs, array $args): Response {
    return (new \wishlist\controleur\Controleur)->seConnecter($rq,$rs,$args);
});

$app->get('/VueMembre', function(Request $rq, Response $rs, array $args): Response {
    return (new \wishlist\vue\VueMembre)->acceuil($rq,$rs,$args);
});


try {
    $app->run();
} catch (Throwable $e) {
}
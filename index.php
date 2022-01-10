<?php

use Slim\Http\Request;
use Slim\Http\Response;
use wishlist\conf\Database;

require_once __DIR__ . '/src/vendor/autoload.php';

Database::connect();

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
    return (new \wishlist\controleur\ListeControleur)->afficherListes($rq,$rs,$args);
});

$app->get('/liste/new', function(Request $rq, Response $rs, array $args): Response {
    return (new \wishlist\controleur\ListeControleur)->nouvelleListe($rq,$rs,$args);
});

$app->get('/liste/{token}', function(Request $rq, Response $rs, array $args): Response {
    return (new \wishlist\controleur\ListeControleur)->afficherListe($rq,$rs,$args);
});

$app->get('/Connection', function(Request $rq, Response $rs, array $args): Response {
    return (new \wishlist\controleur\Controleur)->seConnecter($rq,$rs,$args);
});

$app->get('/Inscription', function(Request $rq, Response $rs, array $args): Response {
    return (new \wishlist\controleur\Controleur)->inscription($rq,$rs,$args);
});


try {
    $app->run();
} catch (Throwable $e) {
}
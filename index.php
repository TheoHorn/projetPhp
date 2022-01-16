<?php

use Slim\Http\Request;
use Slim\Http\Response;
use wishlist\conf\Database;

require_once __DIR__ . '/src/vendor/autoload.php';

Database::connect();

$app= new \Slim\App(["settings"=>[
    "displayErrorDetails" => true]]);
$container = $app->getContainer();

$app->get('/', function(Request $rq, Response $rs, array $args) use($app) {
    return (new \wishlist\controleur\Controleur)->acceuil($rq,$rs,$args);
})->setName('home');

$app->get('/item', function(Request $rq, Response $rs, array $args): Response {
    return (new wishlist\controleur\ItemControleur)->afficheItems($rq,$rs,$args);
});

$app->get('/item/{id}', function(Request $rq, Response $rs, array $args): Response {
    return (new wishlist\controleur\ItemControleur)->afficheItem($rq,$rs,$args);
});

$app->post('/item/{id}', function(Request $rq, Response $rs, array $args): Response {
    return (new wishlist\controleur\ItemControleur)->afficheItem($rq,$rs,$args);
});

$app->get('/liste', function(Request $rq, Response $rs, array $args): Response {
    return (new \wishlist\controleur\ListeControleur)->afficherListes($rq,$rs,$args);
});

$app->get('/liste/new', function(Request $rq, Response $rs, array $args): Response {
    return (new \wishlist\controleur\ListeControleur)->nouvelleListe($rq,$rs,$args);
});

$app->post('/liste/new', function(Request $rq, Response $rs, array $args): Response {
    return (new \wishlist\controleur\ListeControleur)->nouvelleListe($rq,$rs,$args);
});

$app->post('/liste/new/', function(Request $rq, Response $rs, array $args): Response {
    return (new \wishlist\controleur\ListeControleur)->nouvelleListe($rq,$rs,$args);
});

$app->get('/liste/{tokenV}', function(Request $rq, Response $rs, array $args): Response {
    return (new \wishlist\controleur\ListeControleur)->afficherListe($rq,$rs,$args);
});

$app->get('/Connexion', function(Request $rq, Response $rs, array $args) use($app) {
    return (new \wishlist\controleur\UserControleur)->connection($rq,$rs,$args);
});

$app->post('/Connexion', function(Request $rq, Response $rs, array $args) use($app) {
    return (new \wishlist\controleur\UserControleur)->connection($rq,$rs,$args);
});

$app->get('/Inscription', function(Request $rq, Response $rs, array $args) use($app) {
    return (new \wishlist\controleur\UserControleur)->inscription($rq,$rs,$args);
});

$app->post('/Inscription', function(Request $rq, Response $rs, array $args )use($app) {
    return (new \wishlist\controleur\UserControleur)->inscription($rq,$rs,$args);
});

try {
    $app->run();
} catch (Throwable $e) {
}
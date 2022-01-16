<?php

use Slim\Http\Request;
use Slim\Http\Response;
use wishlist\conf\Database;
use wishlist\controleur\UserControleur;

require_once __DIR__ . '/src/vendor/autoload.php';

session_start();

Database::connect();

$app= new \Slim\App(["settings"=>[
    "displayErrorDetails" => true]]);
$container = $app->getContainer();

$app->get('/', function(Request $rq, Response $rs, array $args): Response {
    return (new wishlist\controleur\UserControleur)->acceuil($rq,$rs,$args);
})->setName('Home');

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

$app->post('/liste/new', function(Request $rq, Response $rs, array $args) use ($app): Response {
    return (new \wishlist\controleur\ListeControleur)->nouvelleListe($rq,$rs,$args);
});

$app->get('/liste/{tokenV}', function(Request $rq, Response $rs, array $args): Response {
    return (new \wishlist\controleur\ListeControleur)->afficherListe($rq,$rs,$args);
});

$app->get('/Connexion', function(Request $rq, Response $rs, array $args) use($app) {
    return (new \wishlist\controleur\UserControleur)->connection($rq,$rs,$args);
})->setName('Connection');

$app->post('/Connexion', function(Request $rq, Response $rs, array $args) use($app) {
    return (new \wishlist\controleur\UserControleur)->verifConnection($rq,$rs,$args);
});

$app->get('/Inscription', function(Request $rq, Response $rs, array $args) use($app) {
    return (new \wishlist\controleur\UserControleur)->inscription($rq,$rs,$args);
})->setName('Inscription');

$app->post('/Inscription', function(Request $rq, Response $rs, array $args )use($app) {
    return (new \wishlist\controleur\UserControleur)->verifInscription($rq,$rs,$args);
});


try {
    $app->run();
} catch (Throwable $e) {
}
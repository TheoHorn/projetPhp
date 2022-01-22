<?php

use Slim\Http\Request;
use Slim\Http\Response;
use wishlist\conf\Database;
use wishlist\controleur as Control;

session_start();

require_once __DIR__ . '/src/vendor/autoload.php';

Database::connect();

$c = new \Slim\Container(["settings"=>[
    "displayErrorDetails" => true]]);
$app= new \Slim\App($c);

$app->get('/', function(Request $rq, Response $rs, array $args): Response {
    return (new Control\UserControleur)->acceuil($rq,$rs,$args);
});

$app->post('/', function(Request $rq, Response $rs, array $args): Response {
    return (new Control\ListeControleur)->redirectionListe($rq,$rs,$args);
});

$app->get('/item', function(Request $rq, Response $rs, array $args): Response {
    return (new Control\ItemControleur)->afficheItems($rq,$rs,$args);
});

$app->get('/item/{id}', function(Request $rq, Response $rs, array $args): Response {
    return (new Control\ItemControleur)->afficheItem($rq,$rs,$args);
});

$app->get('/item/{id}/commentaire', function(Request $rq, Response $rs, array $args): Response {
    return (new Control\ItemControleur)->laisserCommentaireItem($rq,$rs,$args);
});

$app->post('/item/{id}/commentaire', function(Request $rq, Response $rs, array $args): Response {
    return (new Control\ItemControleur)->saveCommentItemBdd($rq,$rs,$args);
});

$app->get('/item/{id}/reservation', function(Request $rq, Response $rs, array $args): Response {
    return (new Control\ItemControleur)->reserveItem($rq,$rs,$args);
});

$app->post('/item/{id}/reservation', function(Request $rq, Response $rs, array $args): Response {
    return (new Control\ItemControleur)->SaveReservationBdd($rq,$rs,$args);
});

$app->get('/liste', function(Request $rq, Response $rs, array $args): Response {
    return (new Control\ListeControleur)->afficherListes($rq,$rs,$args);
});

$app->get('/liste/new', function(Request $rq, Response $rs, array $args): Response {
    return (new Control\ListeControleur)->nouvelleListe($rq,$rs,$args);
});

$app->post('/liste/new/ajouter', function(Request $rq, Response $rs, array $args): Response {
    return (new Control\ListeControleur)->ajoutListeDb($rq,$rs,$args);
});

$app->get('/liste/voir/{tokenV}', function(Request $rq, Response $rs, array $args): Response {
    return (new Control\ListeControleur)->afficherListe($rq,$rs,$args);
});

$app->get('/liste/modifier/{tokenM}', function(Request $rq, Response $rs, array $args): Response {
    return (new Control\ListeControleur)->afficherModifListe($rq, $rs, $args);
});

$app->get('/liste/modifier/{tokenM}/infosG', function(Request $rq, Response $rs, array $args): Response {
    return (new Control\ListeControleur)->afficherModifInfosG($rq, $rs, $args);
});


$app->post('/liste/modifier/{tokenM}/infosG/verification', function(Request $rq, Response $rs, array $args): Response {
     return (new Control\ListeControleur)->modifierListeBdd($rq,$rs,$args);
});

$app->get('/liste/modifier/{tokenM}/ajoutItem', function(Request $rq, Response $rs, array $args): Response {
    return (new Control\ListeControleur)->affichageAjouterItem($rq,$rs,$args);
});


$app->post('/liste/modifier/{tokenM}/ajoutItem/verification', function(Request $rq, Response $rs, array $args): Response {
    return (new Control\ListeControleur)->ajouterItemListe($rq,$rs,$args);
});

$app->get('/liste/modifier/{tokenM}/modifierItem/{id}', function(Request $rq, Response $rs, array $args): Response {
    return (new Control\ItemControleur)->affichageModifierItem($rq,$rs,$args);});

$app->post('/liste/modifier/{tokenM}/modifierItem/{id}/verification', function(Request $rq, Response $rs, array $args): Response {
return (new Control\ItemControleur)->modifierItemListe($rq,$rs,$args);});

$app->get('/liste/modifier/{tokenM}/modifierItem/{id}/suppression', function(Request $rq, Response $rs, array $args): Response {
    return (new Control\ItemControleur)->supprimerItemListe($rq,$rs,$args);});

$app->get('/Connexion', function(Request $rq, Response $rs, array $args) use($app) {
    return (new Control\UserControleur)->connection($rq,$rs,$args);
})->setName('Connection');

$app->post('/Connexion', function(Request $rq, Response $rs, array $args) use($app) {
    return (new Control\UserControleur)->verifConnection($rq,$rs,$args);
});

$app->get('/Inscription', function(Request $rq, Response $rs, array $args) use($app) {
    return (new Control\UserControleur)->inscription($rq,$rs,$args);
})->setName('Inscription');

$app->post('/Inscription', function(Request $rq, Response $rs, array $args )use($app) {
    return (new Control\UserControleur)->verifInscription($rq,$rs,$args);
});

$app->get('/mesListes', function(Request $rq, Response $rs, array $args): Response {
    return (new Control\ListeControleur)->afficherMesListes($rq,$rs,$args);
})->setName('mesListes');

$app->post('/mesListes', function(Request $rq, Response $rs, array $args): Response {
    return (new Control\ListeControleur)->ajouterListeUser($rq,$rs,$args);
})->setName('mesListes');

$app->get('/logout', function (Request $rq, Response $rs, array $args): Response {
    return (new Control\UserControleur)->logout($rq,$rs,$args);
});

try {
    $app->run();
} catch (Throwable $e) {
}
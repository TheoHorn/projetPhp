<?php

namespace wishlist\controleur;

use Slim\Http\Request;
use Slim\Http\Response;
use wishlist\vue\VueMembre;
use wishlist\vue\VueParticipant;

class Controleur
{
    function acceuil(Request $rq, Response $rs, array $args)
    {
        session_start();
        if(isset($_SESSION['username'])) {
            $v = new VueMembre(array(), VueMembre::ACCEUIL);
        } else {
            $v = new VueParticipant(array(), VueParticipant::ACCEUIL);
        }
        $rs->getBody()->write($v->render());
        return $rs;
    }

    function seConnecter(Request $rq, Response $rs, array $args)
    {
        $html = '<h1>Connection<h1>

        <form method="post" action="connexion.php">
            <p>Nom</p>
            <input type="text" name="nom">
            <p>Password</p>
            <input type="password" name="password">
            <p>Répetez votre password</p>
            <input type="password" name="repeatpassword"><br><br>
            <input type="submit" name="submit" value="Valider">
        </form>';
        $rs->getBody()->write($html);
        return $rs;
    }

    function inscription(Request $rq, Response $rs, array $args)
    {
        $v = new VueParticipant(array(), VueParticipant::INSCRIPTION);
        $rs->getBody()->write($v->render());
        return $rs;
    }
}
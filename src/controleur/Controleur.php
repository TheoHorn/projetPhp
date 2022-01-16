<?php

namespace wishlist\controleur;

use Slim\Http\Request;
use Slim\Http\Response;
use wishlist\vue\VueMembre;
use wishlist\vue\VueParticipant;
use wishlist\vue\VueUtilisateur;

class Controleur
{
    function acceuil(Request $rq, Response $rs, array $args)
    {
        $v = null;
        if(isset($_SESSION['username'])) {
            $v = new VueMembre(null, VueMembre::ACCEUIL);
        } else {
            $v = new VueUtilisateur(VueUtilisateur::ACCEUIL);
        }
        $rs->getBody()->write($v->render());
        return $rs;
    }
}
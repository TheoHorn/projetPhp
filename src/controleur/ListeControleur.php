<?php

namespace wishlist\controleur;

use Slim\Http\Request;
use Slim\Http\Response;
use wishlist\model\Item;
use wishlist\model\Liste;
use wishlist\vue\VueParticipant;

class ListeControleur
{
    public function afficherListes(Request $rq, Response $rs, $args):Response{
        $liste = Liste::all();
        $v = new VueParticipant( $liste , VueParticipant::LISTS_VIEW) ;
        $rs->getBody()->write($v->render()) ;
        return $rs ;
    }

    function afficherListe(Request $rq, Response $rs, array $args): Response {
        $identifiant = $args['token'];
        $liste = Liste::query()->get('*')->where('token', '=', $identifiant);
        $v = new VueParticipant( $liste , VueParticipant::LIST_VIEW) ;
        $rs->getBody()->write($v->render()) ;
        return $rs ;
    }

    function nouvelleListe(Request $rq, Response $rs, array $args) : Response
    {

        return $rs;
    }
}
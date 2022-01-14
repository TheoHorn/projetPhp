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
        $identifiant = $args['tokenV'];
        $liste = Liste::query()->get('*')->where('tokenV', '=', $identifiant);
        $v = new VueParticipant( $liste , VueParticipant::LIST_VIEW) ;
        $rs->getBody()->write($v->render()) ;
        return $rs ;
    }

    function nouvelleListe(Request $rq, Response $rs, array $args) : Response
    {
        $v = new VueParticipant( array() , VueParticipant::NEW_LISTE) ;
        $rs->getBody()->write($v->render()) ;
        return $rs;
    }

    public function afficherModifListe(Request $rq, Response $rs, array $args)
    {
        $identifiant = $args['tokenM'];
        $liste = Liste::query()->get('*')->where('tokenM', '=', $identifiant);
        $v = new VueParticipant( $liste , VueParticipant::MODIF_VIEW) ;
        $rs->getBody()->write($v->render()) ;
        return $rs ;
    }

    function ajouterListeBdd(Request $rq, Response $rs, array $args) : Response{

        $nom = filter_var($_POST["Nom"],
            FILTER_SANITIZE_STRING);
        $desc =filter_var($_POST["Description"] ,
            FILTER_SANITIZE_STRING);
        $date = $_POST["Date"];

        $tokenV = "nosecure".rand(1, 10000);
        $tokenM = "nomodif".rand(1,10000);

        //ajout dans la bdd
        // il faut récupérer le user id quand la connexion sera faite TODO
        Liste::query()->insert(array('user_id'=>0,'titre'=>$nom,'description'=>$desc,'expiration'=>$date,'tokenV'=> $tokenV,'tokenM'=>$tokenM));
        $v = new VueParticipant(array("0"=>$tokenV,"1"=>$tokenM),VueParticipant::AJOUT_LISTE);
        $rs->getBody()->write($v->render());
        return $rs;
    }

    function modifierListeBdd(Request $rq, Response $rs, array $args) : Response{
        $identifiant = $args['tokenM'];
        $l = Liste::query()->get('*')->where('tokenM', '=', $identifiant);
        foreach($l as $value){
            $liste = $value;
        }
        $id = $liste->no;

        $nom = filter_var($_POST["Nom"],
            FILTER_SANITIZE_STRING);
        $desc =filter_var($_POST["Description"] ,
            FILTER_SANITIZE_STRING);
        $date = $_POST["Date"];

        //modif dans la bdd
        // il faut récupérer le user id quand la connexion sera faite TODO
        Liste::query()->where("no",$id)->update(array('titre'=>$nom,'description'=>$desc,'expiration'=>$date));
        $v = new VueParticipant(array($id),VueParticipant::MODIF_EFFECTUE);
        $rs->getBody()->write($v->render());
        return $rs;
    }

    public function afficherModifInfosG(Request $rq, Response $rs, array $args)
    {
        $identifiant = $args['tokenM'];
        $l = Liste::query()->get('*')->where('tokenM', '=', $identifiant);
        $v = new VueParticipant( $l , VueParticipant::MODIF_INFOSG) ;
        $rs->getBody()->write($v->render()) ;
        return $rs;
    }
}
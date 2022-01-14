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
        $html = '<h1>Creation de liste<h1>

        <form method="POST" action="new/ajouter">
            <p>Nom Liste</p>
            <input type="text" name="Nom">
            <p>Description</p>
            <input type="test" name="Description">
            <p>Date de fin de la liste</p>
            <input type="date" name="Date"><br><br>
            <input type="submit" name="submit" value="Valider">
        </form>';
        $rs->getBody()->write($html);
        return $rs;
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

    public function afficherModifListe(Request $rq, Response $rs, array $args)
    {
        $identifiant = $args['tokenM'];
        $liste = Liste::query()->get('*')->where('tokenM', '=', $identifiant);
        $v = new VueParticipant( $liste , VueParticipant::MODIF_VIEW) ;
        $rs->getBody()->write($v->render()) ;
        return $rs ;
    }
}
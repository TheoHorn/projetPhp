<?php

namespace wishlist\controleur;

use Slim\Http\Request;
use Slim\Http\Response;
use wishlist\model\Item;
use wishlist\model\Liste;
use wishlist\vue\VueMembre;
use wishlist\vue\VueParticipant;
use const http\Client\Curl\POSTREDIR_301;

class ListeControleur
{
    public function afficherListes(Request $rq, Response $rs, array $args):Response{
        if($rq->getParam('tokenV')) {

        }
        if(isset($_SESSION['name'])) {
            $liste = Liste::query()->get('*')->where('user_id','=',$_SESSION['id']);
            $v = new VueMembre($liste, VueMembre::LISTS_VIEW);
        } else {
            $liste = Liste::query()->get('*')->where('visible','=','public');
            $v = new VueParticipant( $liste , VueParticipant::LISTS_VIEW) ;
        }
        $rs->getBody()->write($v->render()) ;
        return $rs ;
    }

    function afficherListe(Request $rq, Response $rs, array $args): Response {
        $identifiant = $args['tokenV'];
        $liste = Liste::query()->get('*')->where('tokenV', '=', $identifiant)->first();
        $v = new VueParticipant( $liste , VueParticipant::LIST_VIEW) ;
        $rs->getBody()->write($v->render()) ;
        return $rs ;
    }

    function nouvelleListe(Request $rq, Response $rs, array $args) : Response
    {
        $v = new VueParticipant( array() , VueParticipant::NEW_LISTE);
        $rs->getBody()->write($v->render()) ;
        return $rs;
    }

    function ajoutListeDb(Request $rq, Response $rs, array $args) {
        $v = null;
        if(isset($_POST['submit'])) {
            $nom = filter_var($_POST['Nom'],
                FILTER_SANITIZE_STRING);
            $desc = filter_var($_POST['Description'],
                FILTER_SANITIZE_STRING);
            $date = $_POST["Date"];
            $visible = filter_var($_POST['visible'],
                FILTER_SANITIZE_STRING);

            $tokenV = base_convert(hash('sha256', time() . mt_rand()), 16, 36);
            $tokenM = base_convert(hash('sha256', time() . mt_rand()), 16, 36);

            //selection d'une sous chaine dans la chaine
            $tokenV = substr($tokenV, rand(0, 38), 12);
            $tokenM = substr($tokenM, rand(0, 38), 12);

            //verification si connexion effectue
            if (isset($_SESSION['userid'])) {
                $uid = $_SESSION['userid'];
            } else {
                $uid = 0;
            }
            //ajout dans la bdd
            Liste::query()->insert(array('user_id' => $uid, 'titre' => $nom, 'description' => $desc, 'expiration' => $date, 'tokenV' => $tokenV, 'tokenM' => $tokenM, 'visible' => $visible));
            $v = new VueParticipant(array("0" => $tokenV, "1" => $tokenM), VueParticipant::AJOUT_LISTE);
        }
        $rs->getBody()->write($v->render()) ;
        return $rs;
    }

    public function afficherModifListe(Request $rq, Response $rs, array $args)
    {
        $identifiant = $args['tokenM'];
        $liste = Liste::query()->get('*')->where('tokenM', '=', $identifiant)->first();
        $v = new VueParticipant( $liste , VueParticipant::MODIF_VIEW) ;
        $rs->getBody()->write($v->render()) ;
        return $rs ;
    }

    function modifierListeBdd(Request $rq, Response $rs, array $args) : Response{
        $identifiant = $args['tokenM'];
        $l = Liste::query()->get('*')->where('tokenM', '=', $identifiant)->first();
        $id = $l->no;

        $nom = filter_var($_POST["Nom"],
            FILTER_SANITIZE_STRING);
        $desc =filter_var($_POST["Description"] ,
            FILTER_SANITIZE_STRING);
        $date = $_POST["Date"];

        //modif dans la bdd
        // il faut r??cup??rer le user id quand la connexion sera faite TODO
        Liste::query()->where("no",$id)->update(array('titre'=>$nom,'description'=>$desc,'expiration'=>$date));
        $v = new VueParticipant($l,VueParticipant::MODIF_EFFECTUE);
        $rs->getBody()->write($v->render());
        return $rs;
    }

    public function afficherModifInfosG(Request $rq, Response $rs, array $args)
    {
        $identifiant = $args['tokenM'];
        $l = Liste::query()->get('*')->where('tokenM', '=', $identifiant)->first();
        $v = new VueParticipant( $l , VueParticipant::MODIF_INFOSG) ;
        $rs->getBody()->write($v->render()) ;
        return $rs;
    }

    public function affichageAjouterItem(Request $rq, Response $rs, array $args)
    {
        $identifiant = $args['tokenM'];
        $l = Liste::query()->get('*')->where('tokenM', '=', $identifiant)->first();
        $v = new VueParticipant( $l , VueParticipant::AJOUT_ITEM) ;
        $rs->getBody()->write($v->render()) ;
        return $rs;
    }


    public function ajouterItemListe(Request $rq, Response $rs, array $args)
    {
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
        $url =filter_var($_POST["Url"] ,
            FILTER_SANITIZE_STRING);
        $prix = $_POST["Prix"];
        $image = filter_var($_POST["Image"],
            FILTER_SANITIZE_STRING);



        //modif dans la bdd
        Item::query()->insert(["liste_id" => $id, "nom" => $nom, "descr" => $desc, "tarif" => $prix, "url" => $url, "img" => $image]);
        $v = new VueParticipant($liste,VueParticipant::AJOUT_ITEM_EFFECTUE);
        $rs->getBody()->write($v->render());
        return $rs;
    }

    public function redirectionListe(Request $rq, Response $rs, array $args)
    {
        $v = null;
        if(isset($_POST['ajout'])) {
            $liste = Liste::query()->get('*')->where('tokenV','=',$_POST['token'])->first();
            if($liste->tokenV=='prive') {
                if(isset($_SESSION['username'])&&$_SESSION['userid']==$liste->user_id) {
                    $v = new VueMembre($liste, VueMembre::LIST_VIEW);
                } else {
                    return $rs->withHeader('Location','./Connexion');
                }
            } else {
                $v = new VueParticipant($liste, VueParticipant::LIST_VIEW);
            }
        }
        if(isset($_POST['modif'])) {
            $liste = Liste::query()->get('*')->where('tokenM','=',$_POST['tokenM'])->first();
            if($liste!=null) {
                return $rs->withHeader('Location','./liste/modifier/'.$liste->tokenM);
            }
        }
        return $rs->write($v->render());
    }

    public function afficherMesListes(Request $rq, Response $rs, array $args)
    {
        $liste = Liste::query()->get('*')->where('user_id','=',$_SESSION['userid']);
        $v = new VueMembre($liste, VueMembre::MY_LISTS_VIEW);
        $rs->getBody()->write($v->render());
        return $rs;
    }

    public function ajouterListeUser(Request $rq, Response $rs, array $args)
    {
        $identifiant = filter_var($_POST["token"],
            FILTER_SANITIZE_STRING);;
        $l = Liste::query()->get('*')->where('tokenM', '=', $identifiant)->first();
        if ($l->user_id == 0){
            Liste::query()->where('tokenM', '=', $identifiant)->update(["user_id"=>$_SESSION['userid']]);
        }
        return $this->afficherMesListes($rq,$rs,$args);
    }

}
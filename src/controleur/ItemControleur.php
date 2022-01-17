<?php

namespace wishlist\controleur;

use Slim\Http\Request;
use Slim\Http\Response;
use wishlist\model\Item;
use wishlist\model\Liste;
use wishlist\vue\VueParticipant;

class ItemControleur
{
    function afficheItems(Request $rq, Response $rs, array $args): Response {
        $items = \wishlist\model\Item::all();

        foreach ($items as $item) {
            $html = '<p><a href="./item/'.$item->id.'">'.$item->nom.'</a></p>';
            $html .= '<img src="web/img/'.$item->img.'" alt="'.$item->nom.'" height="200" width="200"/>';
            $rs->getBody()->write($html);
        }
        return $rs;
    }

    function afficheItem(Request $rq, Response $rs, array $args): Response {
        $id = $args['id'];
        $item = Item::query()->get('*')->where('id', '=', $id)->first();

        if(isset($_POST['reservation'])) {
            $nom = filter_var($_POST['nom'],FILTER_SANITIZE_STRING);
            Item::query()->where("id", $id)->update(["nomParticipant" => $nom,]);
        }

        $v = new VueParticipant( $item , VueParticipant::ITEM_VIEW);
        $rs->getBody()->write($v->render()) ;
        return $rs ;
    }

    public function affichageModifierItem(Request $rq, Response $rs, array $args): Response
    {
        $identifiant = $args['id'];
        $l = Item::query()->get('*')->where('id', '=', $identifiant)->first();
        $v = new VueParticipant( $l , VueParticipant::MODIF_ITEM) ;
        $rs->getBody()->write($v->render()) ;
        return $rs;
    }

    public function modifierItemListe(Request $rq, Response $rs, array $args)
    {
        $identifiant = $args['tokenM'];
        $id = $args['id'];
        $l = Liste::query()->get('*')->where('tokenM', '=', $identifiant)->first();


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
        Item::query()->where("id",$id)->update(["nom" => $nom, "descr" => $desc, "tarif" => $prix, "url" => $url, "img" => $image]);
        $v = new VueParticipant($l,VueParticipant::MODIF_ITEM_EFFECTUE);
        $rs->getBody()->write($v->render());
        return $rs;
    }

    public function supprimerItemListe(Request $rq, Response $rs, array $args)
    {
        $identifiant = $args['tokenM'];
        $id = $args['id'];
        $l = Liste::query()->get('*')->where('tokenM', '=', $identifiant)->first();


        Item::query()->where("id",$id)->delete();
        $v = new VueParticipant($l,VueParticipant::SUPPRESSION_ITEM_LISTE);
        $rs->getBody()->write($v->render());
        return $rs;
    }
}
<?php

namespace wishlist\controleur;

use Slim\Http\Request;
use Slim\Http\Response;
use wishlist\vue\VueParticipant;

class ItemControleur
{
    function afficheItems(Request $rq, Response $rs, array $args): Response {
        $items = \wishlist\model\Item::all();

        foreach ($items as $item) {
            $html = '<p><a href="./item/'.$item->id.'">'.$item->nom.'</a></p>';
            $html .= '<img src="src/img/'.$item->img.'" alt="'.$item->nom.'" height="200" width="200"/>';
            $rs->getBody()->write($html);
        }
        return $rs;
    }

    function afficheItem(Request $rq, Response $rs, array $args): Response {
        $id = $args['id'];
        $item = \wishlist\model\Item::query()->get('*')->where('id', '=', $id);
        $v = new VueParticipant( $item , VueParticipant::ITEM_VIEW) ;
        $rs->getBody()->write($v->render()) ;
        return $rs ;

    }
}
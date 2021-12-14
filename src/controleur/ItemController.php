<?php

namespace wishlist\controller;
use wishlist\vue\VueItem;
use wishlist\vue\VueParticipant;

class ItemController {

    public function getItem($rq, $rs,$args){
        $item = Item::where('id', '=',$args['id'])->first();
        $v = new VueParticipant($item, ITEM_VIEW);
        $rs->getBody()->write($v->render());

        return $rs;
    }
}
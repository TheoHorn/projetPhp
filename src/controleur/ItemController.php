<?php

namespace wishlist\controller;
use wishlist\vue\VueItem;

class ItemController {

    public function getItem($rq, $rs,$args){
        $item = Item::where('id', '=',$args['id'])->first();
        $v = new VueItem($item, ITEM_VIEW);
        $rs->getBody()->write($v->render());

        return $rs;
    }
}
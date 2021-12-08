<?php

require_once __DIR__. '/src/vendor/autoload.php' ;
use wishlist\modele\Item;

$l = Item::take(10)->get();
echo $l->toJson();


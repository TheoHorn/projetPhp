<?php
require_once __DIR__. '/src/conf/Database.php';
require_once __DIR__. '/src/vendor/autoload.php' ;
use wishlist\modele\Item;

$l = Item::all();
echo $l->toJson();


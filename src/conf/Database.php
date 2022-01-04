<?php

namespace wishlist\conf;
require_once __DIR__ .'/../vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as DB;

class Database
{
    public static function connect(){

        $conf = parse_ini_file(__DIR__.'/conf.ini');

        $db = new DB();
        if($conf) $db->addConnection($conf);

        $db->setAsGlobal();
        $db->bootEloquent();
    }

}
<?php

namespace wishlist\vue;

class VueMembre
{

    public function acceuil(\Slim\Http\Request $rq, \Slim\Http\Response $rs, array $args)
    {
        $rs->getBody()->write('Bonjour, vous etes bien connecter');
        return $rs;
    }
}
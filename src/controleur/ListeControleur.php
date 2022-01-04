<?php

namespace wishlist\controleur;

use Slim\Http\Request;
use Slim\Http\Response;

class ListeControleur
{
    function afficheListes(Request $rq, Response $rs, array $args): Response {
        $listes = \wishlist\model\Liste::all();

        foreach ($listes as $liste) {
            $html = '<p><a href="./liste/'.$liste->token.'">'.$liste->titre.'</a></p>';
            $html .= "<p>". $liste->description ."</p>";
            $rs->getBody()->write($html);
        }
        $rs->getBody()->write('<a href="./liste/new"><input type="button" value="Nouvelle Liste"></a>');
        return $rs;
    }

    function afficheListe(Request $rq, Response $rs, array $args): Response {
        $identifiant = $args['token'];
        $listes = \wishlist\model\Liste::query()->get('*')->where('token', '=', $identifiant);

        foreach ($listes as $liste) {
            $rs->getBody()->write("<p><h1>" . $liste->titre . "</h1> <br> Description : ". $liste->description ."</p>");
            $items = \wishlist\model\Item::query()->get('*')->where('liste_id', '=',$liste->no);
            foreach ($items as $item) {
                $html = '<p><a href="../item/'.$item->id.'">'. $item->nom .'</a></p>';
                $html .= '<img src="../src/img/'.$item->img.'" alt="'.$item->nom.'" height="200" width="200"/>';
                $rs->getBody()->write($html);
            }
        }
        return $rs;
    }

    function nouvelleListe(Request $rq, Response $rs, array $args) : Response
    {

        return $rs;
    }
}
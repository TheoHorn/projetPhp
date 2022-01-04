<?php

namespace wishlist\controleur;

use Slim\Http\Request;
use Slim\Http\Response;
use wishlist\model\Utilisateur;

class Controleur
{
    function acceuil(Request $rq, Response $rs, array $args): Response {

        $urlitem = "item";
        $urllist = "liste";

        $html = "<h1>My WishList </h1>";
        $html .= "<p><a href='$urlitem'>Items</a></p>";
        $html .= "<p><a href='$urllist'>Listes</a></p>";
        $html .='<a href="./Connection"><input type="button" value="Se Connecter"></a>';

        $rs->getBody()->write($html);
        return $rs;
    }

    function seConnecter(Request $rq, Response $rs, array $args)
    {
        $html = '<h1>Connection<h1>

        <form method="post" action="connexion.php">
            <p>Nom</p>
            <input type="text" name="nom">
            <p>Password</p>
            <input type="password" name="password">
            <p>Répetez votre password</p>
            <input type="password" name="repeatpassword"><br><br>
            <input type="submit" name="submit" value="Valider">
        </form>';
        $rs->getBody()->write($html);
        return $rs;
    }
}
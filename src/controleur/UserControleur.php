<?php

namespace wishlist\controleur;

use Slim\Http\Request;
use Slim\Http\Response;
use wishlist\model\Utilisateur;
use wishlist\vue\VueUtilisateur;

class UserControleur
{

    private $dir = __DIR__;

    public function connection(Request $rq, Response $rs, array $args) {
        $v = new VueUtilisateur(VueUtilisateur::CONNEXION);
        if(isset($_POST['connexion'])) {
            Authentication::authenticate($_POST['nom'], $_POST['password']);
        }
        $rs->getBody()->write($v->render());
        return $rs;
    }

    public function inscription(Request $rq, Response $rs, array $args) {
        $v = new VueUtilisateur(VueUtilisateur::INSCRIPTION);
        if (isset($_POST['inscription'])) {
            $name = $_POST['identifiant'];
            $password = $_POST['password'];
            $res = Utilisateur::query()->get('*')->where('username','=',$name);
            if($res!=null) {
                echo "<script>alert('Nom d\'utilisateur déjà existant');</script>";
            } else {
                Authentication::createUser( $name, $password);
            }
        }
        $rs->getBody()->write($v->render());

        return $rs;
    }
}
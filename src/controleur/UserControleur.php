<?php

namespace wishlist\controleur;


use Slim\Http\Request;
use Slim\Http\Response;
use wishlist\model\Utilisateur;
use wishlist\vue\VueMembre;
use wishlist\vue\VueUtilisateur;

class UserControleur
{

    private $dir = __DIR__;

    function acceuil(Request $rq, Response $rs, array $args)
    {
        var_dump($_SESSION);

        $v = null;
        if(isset($_SESSION['username'])) {
            $v = new VueMembre(array(), VueMembre::ACCEUIL);
        } else {
            $v = new VueUtilisateur(array(), VueUtilisateur::ACCEUIL);
        }
        $rs->getBody()->write($v->render());
        return $rs;
    }

    public function connection(Request $rq, Response $rs, array $args) {
        $v = new VueUtilisateur(array(), VueUtilisateur::CONNEXION);
        $rs->getBody()->write($v->render());
        return $rs;
    }

    public function verifConnection(Request $rq, Response $rs, array $args) {
        if(isset($_POST['connexion'])) {
            var_dump($_POST);
            Authentication::authenticate($_POST['nom'], $_POST['password']);
        }
        return $rs->withHeader('Location','./');
    }

    public function inscription(Request $rq, Response $rs, array $args) {
        $v = new VueUtilisateur(VueUtilisateur::INSCRIPTION);
        $rs->getBody()->write($v->render());
        return $rs;
    }

    public function verifInscription(Request $rq, Response $rs, array $args) {
        if (isset($_POST['inscription'])) {
            $name = $_POST['identifiant'];
            $password = $_POST['password'];
            $res = Utilisateur::query()->get('*')->where('username','=',$name)->first();
            if($res!=null) {
                echo "<script>alert('Nom d\'utilisateur déjà existant');</script>";
            } else {
                Authentication::createUser($name, $password);
            }
        }
        return $rs->withHeader('Location','./Connexion');
    }
}
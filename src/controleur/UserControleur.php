<?php

namespace wishlist\controleur;


use Slim\Http\Request;
use Slim\Http\Response;
use wishlist\model\Role;
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
        if(isset($_POST['nom'])) {
            $passw = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
            $name = filter_var($_POST['nom'], FILTER_SANITIZE_STRING);
            $user = Utilisateur::query()->get('*')->where('username','=',$name)->first();
            if(password_verify($passw, $user->password)) {
                self::loadProfile($_POST['identifiant']);
                return $rs->withHeader('Location','./');
            }
        }
        return $rs->getBody()->write('Erreur lors de la connexion');
    }

    public function inscription(Request $rq, Response $rs, array $args) {
        $v = new VueUtilisateur($args,VueUtilisateur::INSCRIPTION);
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

    private function loadProfile($username) {
        if(isset($_SESSION['username'])) {
            session_destroy();
            session_start();
        }
        $user = Utilisateur::query()->get('*')->where('username','=',$username)->first();
        $auth = Role::query()->get('*')->where('id_role','=',$user['id_role'])->first();
        $userid = $user->id;
        $role = $user->id_role;
        $authlevel = $auth->auth_level;
        $_SESSION['username'] = $username;
        $_SESSION['userid'] = 1;
        $_SESSION['role'] = 2;
        $_SESSION['auth_level'] = 3;
    }
}
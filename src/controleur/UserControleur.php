<?php

namespace wishlist\controleur;


use Slim\Http\Request;
use Slim\Http\Response;
use wishlist\model\Liste;
use wishlist\model\Role;
use wishlist\model\Utilisateur;
use wishlist\vue\Vue;
use wishlist\vue\VueMembre;
use wishlist\vue\VueParticipant;
use wishlist\vue\VueUtilisateur;

class UserControleur
{

    private $dir = __DIR__;

    function acceuil(Request $rq, Response $rs, array $args)
    {
        if(isset($_SESSION['username'])) {
            $v = new VueMembre(array(), VueMembre::ACCEUIL);
        } else {
            $v = new VueParticipant(array(), VueParticipant::ACCEUIL);
        }
        $rs->getBody()->write($v->render());
        return $rs;
    }

    public function connection(Request $rq, Response $rs, array $args) {
        $v = new VueParticipant(array(), VueParticipant::CONNEXION);
        $rs->getBody()->write($v->render());
        return $rs;
    }

    public function verifConnection(Request $rq, Response $rs, array $args) {
        if(isset($_POST['nom'])) {
            $passw = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
            $name = filter_var($_POST['nom'], FILTER_SANITIZE_STRING);
            $user = Utilisateur::query()->get('*')->where('username','=',$name)->first();
            if(password_verify($passw, $user->password)) {
                self::loadProfile($_POST['nom']);
                return $rs->withHeader('Location','./');
            }
        }
        return $rs->getBody()->write('Erreur lors de la connexion');
    }

    public function inscription(Request $rq, Response $rs, array $args) {
        $v = new VueParticipant($args,VueParticipant::INSCRIPTION);
        $rs->getBody()->write($v->render());
        return $rs;
    }

    public function verifInscription(Request $rq, Response $rs, array $args) {
        if (isset($_POST['inscription'])) {
            $name = $_POST['identifiant'];
            $password = $_POST['password'];
            if($_POST['password']==$_POST['reppassword']) {
                $res = Utilisateur::query()->get('*')->where('username','=',$name)->first();
                if($res!=null) {
                    echo "<script>alert('Nom d\'utilisateur déjà existant');</script>";
                } else {
                    Authentication::createUser($name, $password);
                }
            } else {
                echo "<script>alert('Les mots de passe ne correspondent pas');</script>";
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
        $_SESSION['username'] = $username;
        $_SESSION['userid'] = $user->id;
        $_SESSION['role'] = $user->id_role;
        $_SESSION['auth_level'] = $auth->auth_level;
    }

    public function logout(Request $rq, Response $rs, array $args) {
        if(isset($_SESSION['username'])) {
            session_destroy();
            session_start();
        }
        return $rs->withHeader('Location', './');
    }

    public function afficherCreateurs(Request $rq, Response $rs, array $args)
    {
        $listes = Liste::query()->get('*')->where('visible', '=','public');
        $creat = array();
        foreach ($listes as $values){
            $ut = Utilisateur::query()->get('*')->where('id','=', $values->user_id)->first();
            if($ut!=null) {
                if (!in_array($ut->username,$creat)){
                    $creat[] = $ut->username;
                }
            }
        }
        $v = new VueParticipant($creat,VueParticipant::CREATEURS_VIEW);
        $rs->getBody()->write($v->render());
        return $rs;
    }

    public function monCompte(Request $rq, Response $rs, array $args) {
        $ut = Utilisateur::query()->get('*')->where('id','=', $_SESSION['userid'])->first();
        if($ut!=null) {
            $v = new VueMembre(array(), VueMembre::MY_ACCOUNT);
            $rs->getBody()->write($v->render());
            return $rs;
        } else {
            echo "<script>alert('Vous n\'avez pas accés à cette fonctionalité);</script>";
            return $rs->withHeader('Location', './');
        }
    }

    public function modifPassword(Request $rq, Response $rs, array $args)
    {
        $v = new VueMembre(array(), VueMembre::MODIF_PASS);
        $rs->getBody()->write($v->render());
        return $rs;
    }

    public function updatePass(Request $rq, Response $rs, array $args) {
        $newpassw = filter_var($_POST['newpassword'], FILTER_SANITIZE_STRING);
        $ancpassw = filter_var($_POST['ancpassword'], FILTER_SANITIZE_STRING);
        $repnewpassw = filter_var($_POST['repnewpassword'], FILTER_SANITIZE_STRING);
        if(isset($_SESSION['username'])){
            $ut = Utilisateur::query()->get('*')->where('id','=',$_SESSION['userid']);
            if(password_verify($ancpassw,$ut->password)) {
                if (isset($_POST['modifpass'])) {
                    if($newpassw!=$ancpassw) {
                        if($newpassw==$repnewpassw) {
                            $hash = password_hash($newpassw, PASSWORD_DEFAULT, ['cost'=> 12]);
                            Authentication::updatePass($_SESSION['userid'], $hash);
                        } else {
                            echo "<script>alert('Les mots de passe ne correspondent pas');</script>";
                        }
                    } else {
                        echo "<script>alert('Vous devez choisir un mot de passe différent de l\'ancien');</script>";
                    }
                }
            } else {
                echo "<script>alert('Le mot de passe que vous avez saisie n\'est pas votre mot de passe actuelle');</script>";
            }

        }
        return $rs->withHeader('Location', './Connexion');
    }

    public function modifIdentifiant(Request $rq, Response $rs, array $args)
    {
        $v = new VueMembre(array(), VueMembre::MODIF_ID);
        $rs->getBody()->write($v->render());
        return $rs;
    }

    public function updateId(Request $rq, Response $rs, array $args) {
        $newid = filter_var($_POST['newId'], FILTER_SANITIZE_STRING);
        if(isset($_SESSION['username'])) {
            if(isset($_POST['valider'])) {
                if($_SESSION['username']!=$newid) {
                    Utilisateur::query()->where('id','=',$_SESSION['userid'])->update(array('username'=>$newid));
                    $_SESSION['username']=$newid;
                } else {
                    echo "<script>alert('Veuillez choisir un identifiant différent de l\'ancien');</script>";
                }
            }
        }
        return $rs->withHeader('Location', './monCompte');
    }


}
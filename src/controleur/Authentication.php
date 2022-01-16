<?php

namespace wishlist\controleur;

use wishlist\model\Role;
use wishlist\model\Utilisateur;

class Authentication
{
    public static function createUser($userid, $password) {
        // vérif injection sql
        $pass = filter_var($password, FILTER_SANITIZE_STRING);
        $name = filter_var($userid, FILTER_SANITIZE_STRING);
        // vérif correspondance avec patterne mdp

        // $alea = random_bytes(32); a ajouter aussi ?
        $hash = password_hash($pass, PASSWORD_DEFAULT, ['cost'=> 12]);
        Utilisateur::query()->insert(array('username'=>$name,'password'=>$hash));
    }

    public static function authenticate($userid,$password) {
        // vérif injection sql
        $passw = filter_var($password, FILTER_SANITIZE_STRING);
        $name = filter_var($userid, FILTER_SANITIZE_STRING);
        $pass = Utilisateur::query()->get('password')->where('username','=',$name);
        if(password_verify($passw, $pass)) {
            self::loadProfile($userid);
        }
    }

    private static function loadProfile($userid) {
        $user = Utilisateur::query()->get(array('id','id_role'))->where('username','=',$userid);
        $auth = Role::query()->get('auth_level')->where('id_role','=',$user['id_role']);
        $_SESSION['username'] = $userid;
        $_SESSION['userid'] = $user['id'];
        $_SESSION['role'] = $user['id_role'];
        $_SESSION['auth_level'] = $auth;
    }

    /**
     * @throws AuthException
     */
    public static function checkAccessRights($required): bool
    {
        if($_SESSION['auth_level']<$required) throw new AuthException;
        return true;
    }
}

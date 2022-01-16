<?php

namespace wishlist\controleur;

use wishlist\model\Role;
use wishlist\model\Utilisateur;

class Authentication
{
    public static function createUser($userid, $password) {
        // Ajout de la vérif de conformiter TODO
        // $alea = random_bytes(32); a ajouter aussi ?
        $hash = password_hash($password, PASSWORD_DEFAULT, ['cost'=> 12]);
        Utilisateur::query()->insert(array('username'=>$userid,'password'=>$hash));
    }

    public static function authenticate($userid,$password) {
        $pass = Utilisateur::query()->get('password')->where('username','=',$userid);
        if(password_verify($password, $pass)) {
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
    public static function checkAccessRights($required) {
        if($_SESSION['auth_level']<$required) throw new AuthException;
    }
}

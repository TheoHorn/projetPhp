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

    /**
     * @throws AuthException
     */
    public static function checkAccessRights($required): bool
    {
        if($_SESSION['auth_level']<$required) throw new AuthException;
        return true;
    }
}

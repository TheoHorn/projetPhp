<?php

namespace wishlist\vue;

use wishlist\controleur\Authentication;

class VueUtilisateur extends Vue
{
    const INSCRIPTION = 1;
    const CONNEXION = 2;
    const ACCEUIL = 3;


    private function acceuil() {
        $urlitem = "item";
        $urllist = "liste";
        $rs = "<h1>My WishList </h1>";
        $rs .= "<p><a href='$urlitem'>Items</a></p>";
        $rs .= "<p><a href='$urllist'>Listes</a></p>";
        $rs .='<a href="./Connexion"><input type="button" value="Se Connecter"></a>';
        $rs .='<a href="./Inscription"><input type="button" value="S\'inscrire"></a>';
        return $rs;
    }

    private function connexion()
    {
        $rs ='';
        $rs .='<div align="center">
                    <h2>Connection</h2>
                    <br><br><br>
                    <form method="post" action="">
                        <table>
                            <tr>
                                <td>
                                    <label for="identifiant">Identifiant :</label>
                                </td>
                                <td>
                                    <input type="text" placeholder="Votre identifiant" name="nom" required>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Mot de passe :</label>
                                </td>
                                <td>
                                    <input type="password" placeholder="Votre mot de passe" name="password" required>
                                </td>
                            </tr>
                        </table>
                        <input type="submit" name="connection" value="Valider">
                    </form>';
        $rs .= '<a href="./Inscription">S\'inscrire</a>';

        return $rs;
    }

    private function inscription()
    {
        $rs ='';
        $rs .='<div align="center">
                    <h2>Inscription</h2>
                    <br><br><br>
                    <form method="post" action="">
                        <table>
                            <tr>
                                <td>
                                    <label for="identifiant">Identifiant :</label>
                                </td>
                                <td>
                                    <input type="text" placeholder="Votre identifiant" name="identifiant" required>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Mot de passe :</label>
                                </td>
                                <td>
                                    <input type="password" placeholder="Votre mot de passe" name="password" required>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Confirmer votre mot de passe :</label>
                                </td>
                                <td>
                                    <input type="password" placeholder="Votre mot de passe" name="reppassword" required>
                                </td>
                            </tr>
                        </table>
                        <br>
                        <input type="submit" name="inscription" value="Je m\'incsris"/>
                    </form>
                </div>';
        return $rs;
    }

    public function render() {
        $content='';
        switch ($this->selecteur){
            case self::INSCRIPTION:
                $content = $this->inscription();
                break;
            case self::CONNEXION:
                $content = $this->connexion();
                break;
            case self::ACCEUIL:
                $content = $this->acceuil();
                break;
            default :
                break;
        }
        $html = <<<END
                <!DOCTYPE html> <html>
                <head>
                    <title>My WishList</title>
                    <meta charset = "utf-8">
                    <link rel="stylesheet" href="./web/css/rendu.css"
                </head>
                <body> 
                <div class="content">
                 $content
                </div>
                </body><html>
                END ;
        return $html;
    }
}
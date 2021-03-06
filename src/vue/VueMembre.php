<?php

namespace wishlist\vue;

use wishlist\model\Item;

class VueMembre extends Vue
{

    const LISTS_VIEW = 1;
    const LIST_VIEW = 2;
    const ACCEUIL = 4;
    const MY_LISTS_VIEW = 3;
    const MODIF_ID = 5;
    const MODIF_PASS = 6;
    const MY_ACCOUNT = 7;

    private function acceuil()
    {
        $urllist = "liste";
        $rs = "<div><h1  class='titre'>My WishList </h1></div>";
        $rs .= '<div><p>Bonjour '.$_SESSION['username'].', vous etes bien connecter</p></div>';
        $rs .= "<p><a href='$urllist'>Listes publiques</a></p>";
        $rs .= "<p><a href='mesListes'>Mes Listes</a></p>";
        $rs .= "<p><a href='./createurs'>Créateurs</a></p>";
        $rs .= "<p><a href='./monCompte'>Mon Compte</a></p>";
        $rs .= '<div>
                    <h2>Acceder à une liste</h2>
                    <form method="post" action="">
                        <table>
                            <tr>
                                <td>
                                    <label for="identifiant">Veuillez entre le token pour voir la liste :</label>
                                </td>
                                <td>
                                    <input type="text" placeholder="Token de Vision" name="token" required>
                                </td>
                            </tr>
                        </table>
                        <br><input type="submit" name="submit" value="Valider">
                    </form>
                </div>';
        $rs .= '<div>
            <h2>Modification d\'une liste</h2>
                    <form method="post" action="">
                        <table>
                            <tr>
                                <td>
                                    <label for="identifiant">Veuillez entre le Token de Modification de la liste :</label>
                                </td>
                                <td>
                                    <input type="text" placeholder="Token de Modification" name="tokenM" required>
                                </td>
                            </tr>
                        </table>
                        <br><input type="submit" name="modif" value="Valider">
                    </form>
        </div>';
        $rs.='<br><a href="./liste/new">Créer une nouvelle liste</a><br><br>';
        $rs.= '<a href="./logout">Déconnexion</a>';
        return $rs;
    }

    private function affichageListe()
    {
        $rs = "";
        foreach ($this->tab as $liste) {
            $rs .= "<div><p><h1>" . $liste->titre . "</h1> <br> Description : " . $liste->description . "</p><ol>";
            $items = Item::query()->get('*')->where('liste_id', '=', $liste["no"]);
            foreach ($items as $item) {
                $rs .= '<li><a href="../item/' . $item->id . '">' . $item->nom . '</a>';
                $rs .= '<img src="../web/img/' . $item->img . '" alt="' . $item->nom . '" height="200" width="200"/>';
            }
            $rs .= "</ol></div>";
            $rs .= "<div>
                    <a href='../item/new'>Ajouter un Item à la liste</a>
                </div>";
        }
        return $rs;
    }

    private function affichageListes()
    {
        $s = "<div><ol>";
        foreach ($this->tab as $val) {
            $s .= "<li>" . '<a href="./liste/'.$val->token.'">'.$val->titre.'</a>'. "</li>";
        }
        $s .= "</ol></div>";
        return $s;
    }

    private function affichageMesListes()
    {
        $s = "<h1>Mes Listes</h1>";
        $s .= "<div><ol>";
        foreach ($this->tab as $val) {
            $s .= "<li>" . '<a href="./liste/voir/'.$val->tokenV.'">'.$val->titre.'</a>';
            $s .= '<a href="./liste/modifier/'.$val->tokenM.'"><input type="button" value=" Modifier "></a></li>';
        }
        $s .= "</ol></div>";
        $s .= '<div>
                    <h2>Ajout d\'une liste</h2>
                    <form method="post" action="">
                        <table>
                            <tr>
                                <td>
                                    <label for="identifiant">Veuillez entre le Token de Modification de la liste :</label>
                                </td>
                                <td>
                                    <input type="text" placeholder="Token de Modification" name="token" required>
                                </td>
                            </tr>
                        </table>
                        <br><input type="submit" name="ajout" value="Valider">
                    </form>
                </div>';
        return $s;
    }


    public function render(){
        switch ($this->selecteur){
            case self::LISTS_VIEW :
                $content = $this->affichageListes();
                break;
            case self::LIST_VIEW :
                $content = $this->affichageListe();
                break;
            case self::ACCEUIL :
                $content = $this->acceuil();
                break;
            case self::MY_LISTS_VIEW :
                $content = $this->affichageMesListes();
                break;
            case self::MY_ACCOUNT :
                $content = $this->monCompte();
                break;
            case self::MODIF_PASS :
                $content = $this->modifPass();
                break;
            case self::MODIF_ID :
                $content = $this->modifId();
                break;
            default :
                break;
        }
        $html = <<<END
                <!DOCTYPE html> <html>
                <head>
                    <title>My WishList</title>
                    <meta charset = "utf-8">
                    <link rel="stylesheet" href="./web/css/rendu.css">
                </head>
                <body> 
                <div class="content">
                 $content
                </div>
                </body><html>
                END ;
        return $html;

    }

    private function monCompte()
    {
        $rs='<div align="center"><h1>Mon Compte</h1>
                <div>
                    <label>Mon identifant : </label>'.$_SESSION['username'].' 
                     <a href="./username">Modifier mon identifiant</a>
                </div>
                <a href="./password">Modifier mon mot de passe</a></div>';
        return $rs;
    }

    private function modifPass()
    {
        $rs='<div align="center">
                    <h2>Modification du mot de passe</h2>
                    <br><br><br>
                    <form method="post" action="">
                        <table>
                            <tr>
                                <td>
                                    <label>Ancien mot de passe :</label>
                                </td>
                                <td>
                                    <input type="password" placeholder="Votre ancien mot de passe" name="ancpassword" pattern=".[a-zA-z&0-9_!]{8,20}" required>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Nouveau mot de passe :</label>
                                </td>
                                <td>
                                    <input type="password" placeholder="Votre nouveau mot de passe" name="newpassword" pattern=".[a-zA-z&0-9_!]{8,20}" required>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Confirmer votre nouveau mot de passe :</label>
                                </td>
                                <td>
                                    <input type="password" placeholder="Votre nouveau mot de passe" name="repnewpassword" pattern=".[a-zA-z&0-9_]{8,20}" required>
                                </td>
                            </tr>
                        </table>
                        <br>
                        <input type="submit" name="modifpass" value="Je change"/>
                    </form>
                </div>';
        return $rs;
    }

    private function modifId()
    {
        $rs='<div align="center">
                    <h2>Inscription</h2>
                    <br><br><br>
                    <form method="post" action="">
                        <table>
                            <tr>
                                <td>
                                    <label>Identifiant :</label>
                                </td>
                                <td>
                                     <label>'.$_SESSION['username'].'</label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Nouvel identifiant :</label>
                                </td>
                                <td>
                                    <input type="text" placeholder="Votre nouvel identifiant" name="newId" pattern=".[a-zA-z0-9]{3,20}" required>
                                </td>
                            </tr>
                        </table>
                        <br>
                        <input type="submit" name="valider" value="Je change"/>
                    </form>
                </div>';
        return $rs;
    }


}
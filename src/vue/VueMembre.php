<?php

namespace wishlist\vue;

use wishlist\model\Item;

class VueMembre extends Vue
{

    const LISTS_VIEW = 1;
    const LIST_VIEW = 2;
    const ACCEUIL = 4;
    const MY_LISTS_VIEW = 3;


    private function acceuil()
    {
        $urlitem = "item";
        $urllist = "liste";
        $rs = "<h1>My WishList </h1>";
        $rs .= '<div><p>Bonjour '.$_SESSION['username'].', vous etes bien connecter</p></div>';
        $rs .= "<p><a href='$urlitem'>Items</a></p>";
        $rs .= "<p><a href='$urllist'>Listes</a></p>";
        $rs .= "<p><a href='mesListes'</a>Mes Listes</p>";
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
            $s .= "<li>" . '<a href="./liste/'.$val->token.'">'.$val->titre.'</a>'. "</li>";
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
                        <br><input type="submit" name="submit" value="Valider">
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
            default :
                break;
        }
        $html = <<<END
                <!DOCTYPE html> <html>
                <head>
                    <title>My WishList</title>
                    <meta charset = "utf-8">
                    <link rel="stylesheet" href="../../web/css/rendu.css"
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
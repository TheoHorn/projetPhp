<?php

namespace wishlist\vue;

use wishlist\model\Item;

class VueParticipant
{

    private $tabListeItem;
    private $selecteur;
    const LISTS_VIEW = 1;
    const LIST_VIEW = 2;
    const INSCRIPTION = 3;
    const ACCEUIL = 4;

    public function __construct($li, $selec)
    {
        $this->tabListeItem = $li;
        $this->selecteur = $selec;
    }

    private function affichageListes(){
        $s = "<div><ol>";
        foreach ($this->tabListeItem as $val) {
            $s .= "<li>" . '<a href="./liste/'.$val->token.'">'.$val->titre.'</a>'. "</li>";
        }
        $s .= "</ol></div>";
        return $s;
    }

    private function affichageListe()
    {
        $rs = "";
        foreach ($this->tabListeItem as $liste) {
            $rs .= "<div><p><h1>" . $liste->titre . "</h1> <br> Description : " . $liste->description . "</p><ol>";
            $items = Item::query()->get('*')->where('liste_id', '=', $liste["no"]);
            foreach ($items as $item) {
                $rs .= '<li><a href="../item/' . $item->id . '">' . $item->nom . '</a>';
                $rs .= '<img src="../src/img/' . $item->img . '" alt="' . $item->nom . '" height="200" width="200"/>';
            }
            $rs .= "</ol></div>";
        }
        return $rs;
    }

    private function acceuil() {
        $urlitem = "item";
        $urllist = "liste";

        $rs = "<h1>My WishList </h1>";
        $rs .= "<p><a href='$urlitem'>Items</a></p>";
        $rs .= "<p><a href='$urllist'>Listes</a></p>";
        $rs .='<a href="./Connection"><input type="button" value="Se Connecter"></a>';
        $rs .='<a href="./Inscription"><input type="button" value="S\'inscrire"></a>';

        return $rs;
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
            default :
                $content = $this->affichageListes();
                break;
        }
        $html = <<<END
                <!DOCTYPE html> <html>
                <body> 
                <div class="content">
                 $content
                </div>
                </body><html>
                END ;
        return $html;

    }
}
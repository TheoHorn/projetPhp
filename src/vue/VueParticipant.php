<?php

namespace wishlist\vue;

use wishlist\model\Item;

class VueParticipant
{

    private $tabListeItem;
    private $selecteur;
    const LISTS_VIEW = 1;
    const LIST_VIEW = 2;

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

    public function render(){
        switch ($this->selecteur){
            case self::LISTS_VIEW :
                $content = $this->affichageListes();
                break;
            case self::LIST_VIEW :
                $content = $this->affichageListe();
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
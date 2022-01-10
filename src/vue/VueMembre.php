<?php

namespace wishlist\vue;

use wishlist\model\Item;

class VueMembre
{
    private $tabListeItem;
    private $selecteur;
    const LISTS_VIEW = 1;
    const LIST_VIEW = 2;
    const ACCEUIL = 4;

    public function __construct($li, $selec)
    {
        $this->tabListeItem = $li;
        $this->selecteur = $selec;
    }

    private function acceuil()
    {
        $rs = 'Bonjour, vous etes bien connecter';
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

    private function affichageListe()
    {
        $rs = "";
        foreach ($this->tabListeItem as $liste) {
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
        foreach ($this->tabListeItem as $val) {
            $s .= "<li>" . '<a href="./liste/'.$val->token.'">'.$val->titre.'</a>'. "</li>";
        }
        $s .= "</ol></div>";
        return $s;
    }
}
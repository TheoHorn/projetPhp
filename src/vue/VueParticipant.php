<?php

namespace wishlist\vue;

use wishlist\model\Item;

class VueParticipant
{


    private $tab;
    private $selecteur;
    const LISTS_VIEW = 1;
    const LIST_VIEW = 2;
    const INSCRIPTION = 3;
    const ACCEUIL = 4;
    const ITEM_VIEW = 5;
    const AJOUT_LISTE = 6;
    const MODIF_VIEW = 7;

    public function __construct($li, $selec)
    {
        $this->tab = $li;
        $this->selecteur = $selec;
    }

    private function affichageListes(){
        $s = "<div><ol>";
        foreach ($this->tab as $val) {
            $s .= "<li>" . '<a href="./liste/voir/'.$val->tokenV.'">'.$val->titre.'</a>'. "</li>";
        }
        $s .= "<a href=\"./liste/new\"><input type=\"button\" value=\" Creer une nouvelle liste \"></a>";
        $s .= "</ol></div>";
        return $s;
    }

    private function affichageListe()
    {
        $rs = "";
        foreach ($this->tab as $liste) {
            $rs .= "<div><p><h1>" . $liste->titre . "</h1> <br> Description : " . $liste->description . "</p><ol>";
            $items = Item::query()->get('*')->where('liste_id', '=', $liste["no"]);
            foreach ($items as $item) {
                $rs .= '<li><a href="../../item/' . $item->id . '">' . $item->nom . '</a>';
                $rs .= '<img src="../../web/img/' . $item->img . '" alt="' . $item->nom . '" height="200" width="200"/>';
                //if pas encore reserve
                $rs .= '<a href="../../item/' . $item->id . '/reservation">Reserver</a>';
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

    private function affichageItem()
    {
        foreach ($this->tab as $item) {
            $rs = '<div>'.$item->nom . '<br>' . $item->descr . '<br>'. $item->tarif .' €</div>';
            $rs .= '<img src="../web/img/' . $item->img . '" alt="' . $item->nom . '" height="200" width="200"/>';
        }
        return $rs;
    }

    private function ajoutListe(){
        $html = "<h1> La liste a été crée vous pouvez y ajouter des items</h1>";
        $html .= "<div>
                  <p> Le token pour acceder aux informations de la nouvelle liste est le suivant : ".$this->tab[0]."</p>
                  <p> Si vous souhaitez modifier votre liste, utiliser ce token : ".$this->tab[1]."</p>
                  </div>";
        return $html;
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
            case self::ITEM_VIEW :
                $content = $this->affichageItem();
                break;
            case self::AJOUT_LISTE :
                $content = $this->ajoutListe();
                break;
            case self::MODIF_VIEW :
                $content = $this->modifierListe();
                break;
            default :
                $content = "<p>selecteur de la vue inadéquat</p>";
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

    private function modifierListe()
    {
        //affiche uniquement la liste TODO
        $rs = "";
        foreach ($this->tab as $liste) {
            $rs .= "<div><p><h1>" . $liste->titre . "</h1> <br> Description : " . $liste->description . "</p><ol>";
            $items = Item::query()->get('*')->where('liste_id', '=', $liste["no"]);
            foreach ($items as $item) {
                $rs .= '<li><a href="../../item/' . $item->id . '">' . $item->nom . '</a>';
                $rs .= '<img src="../../web/img/' . $item->img . '" alt="' . $item->nom . '" height="200" width="200"/>';
                //if pas encore reserve
                $rs .= '<a href="../../item/' . $item->id . '/reservation">Reserver</a>';
            }
            $rs .= "</ol></div>";
        }
        return $rs;
    }


}
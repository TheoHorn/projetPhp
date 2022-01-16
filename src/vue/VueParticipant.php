<?php

namespace wishlist\vue;

use wishlist\model\Item;

class VueParticipant
{



    private $tab;
    private $selecteur;
    const LISTS_VIEW = 1;
    const LIST_VIEW = 2;
    const ACCEUIL = 4;
    const ITEM_VIEW = 5;
    const AJOUT_LISTE = 6;
    const MODIF_VIEW = 7;
    const NEW_LISTE = 8;
    const MODIF_INFOSG = 9;
    const MODIF_EFFECTUE = 10;
    const AJOUT_ITEM = 11;
    const AJOUT_ITEM_EFFECTUE = 12;
    const MODIF_ITEM = 13;
    const MODIF_ITEM_EFFECTUE = 14;
    const SUPPRESSION_ITEM_LISTE = 15 ;

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
        $rs .='<a href="./Connexion"><input type="button" value="Se Connecter"></a>';
        $rs .='<a href="./Inscription"><input type="button" value="S\'inscrire"></a>';

        return $rs;
    }

    private function affichageItem()
    {

        $rs = '<div>'.$this->tab->nom . '<br>' . $this->tab->descr . '<br>'. $this->tab->tarif .' €</div>';
        $rs .= '<img src="../web/img/' . $this->tab->img . '" alt="' . $this->tab->nom . '" height="200" width="200"/>';
        if($this->tab->nomParticipant == null) {
            $rs.='<h1>Réserver<h1>
            <form method="post" action="">
                <p>Nom</p>
                <input type="text" name="nom" required>
                <input type="submit" name="reservation" value="Valider">
            </form>';
        } else {
            $rs.='<p>Réserver par : '.$this->tab->nomParticipant .'</p>';
        }
        return $rs;
    }

    private function ajoutListe(){
        $html = "<h1> La liste a été crée vous pouvez y ajouter des items</h1>";
        $html .= "<div>
                  <p> Le token pour acceder aux informations de la nouvelle liste est le suivant : ".$this->tab[0]."</p>
                  <p> Si vous souhaitez modifier votre liste, utiliser ce token : ".$this->tab[1]."</p>
                  </div>";
        $html .= '<a href="../">Compris</a>';
        return $html;
    }

    private function affichageModifEffectue()
    {
        $html = "<h1> La liste a été modifié avec succès</h1>";
        $html .= '<a href="./../../'.$this->tab->tokenM.'"><input type="button" value=" Retour "></a>';
        return $html;
    }

    private function ajoutItemEffectue()
    {
        $html = "<h1> L'item a été ajouté avec succès</h1>";
        $html .= '<a href="./../../'.$this->tab->tokenM.'"><input type="button" value=" Retour "></a>';
        return $html;
    }

    private function affichageModifItemEffectue()
    {
        $html = "<h1> L'item a été modifié avec succès</h1>";
        $html .= '<a href="./../../../'.$this->tab->tokenM.'"><input type="button" value=" Retour "></a>';
        return $html;
    }

    private function affichageSuppressionItemEffectue()
    {
        $html = "<h1> L'item a été supprimé avec succès</h1>";
        $html .= '<a href="./../../../'.$this->tab->tokenM.'"><input type="button" value=" Retour "></a>';
        return $html;
    }

    private function modifierListe()
    {
        $rs = "";
        foreach ($this->tab as $liste) {
            $rs .= "<div><p><h1>" . $liste->titre . "</h1> <br> Description : " . $liste->description . "</p>";
            $items = Item::query()->get('*')->where('liste_id', '=', $liste["no"]);
            $rs.= "<p>Les items présents dans la liste :</p><ol>";
            foreach ($items as $item) {
                $rs .= '<li><a href="../../item/' . $item->id . '">' . $item->nom . '</a><a href="./'.$liste->tokenM.'/modifierItem/'.$item->id.'"><input type="button" value=" Modifier cet item "></a>';
            }
            $rs .= "</ol></div>";
            $rs .='<a href="./'.$liste->tokenM.'/infosG"><input type="button" value=" Modifier les informations générales "></a>';
            $rs .='<a href="./'.$liste->tokenM.'/ajoutItem"><input type="button" value=" Ajouter un item "></a>';
        }
        return $rs;
    }

    private function nouvelleListe()
    {
        $html = '<h1>Creation de liste<h1>

        <form method="POST" action="">
            <p>Nom Liste</p>
            <input type="text" name="Nom">
            <p>Description</p>
            <input type="test" name="Description">
            <p>Date de fin de la liste</p>
            <input type="date" name="Date"><br><br>
            <input type="submit" name="submit" value="Valider">
        </form>';
        return $html;
    }


    private function modifierInfosG()
    {
        foreach($this->tab as $value){
            $liste = $value;
        }
        //$_POST['id'] = $liste->no;
        $html = '<h1>Modification de liste<h1>

        <form method="POST" action="infosG/verification">
            <p>Nom Liste</p>
            <input type="text" name="Nom" value="'.$liste->titre.'">
            <p>Description</p>
            <input type="test" name="Description" value="'.$liste->description.'">
            <p>Date de fin de la liste</p>
            <input type="date" name="Date" value="'.$liste->expiration.'"><br><br>
            <input type="submit" name="submit" value="Valider">
        </form>';
        return $html;
    }

    private function affichageAjoutItem()
    {
        $html = '<h1>Ajout d\'un item<h1>

        <form method="POST" action="ajoutItem/verification">
            <p>Nom Item</p>
            <input type="text" name="Nom">
            <p>Description</p>
            <input type="test" name="Description" >
            <p>Prix en €</p>
            <input type="number" step="0.01" name="Prix" ><br><br>
            <p>Url renvoyant su un site tierce pour plus details du produit</p>
            <input type="url" name="Url" >
            <p>Image</p>
            <input type="text" name="Image" >
            <input type="submit" name="submit" value="Valider">
        </form>';
        return $html;
    }

    private function affichageModifItem()
    {
        foreach($this->tab as $value){
            $item = $value;
        }

        $html = '<h1>Modification d\'un item<h1>

        <form method="POST" action="'.$item->id.'/verification">
            <p>Nom Item</p>
            <input type="text" name="Nom" value="'.$item->nom.'">
            <p>Description</p>
            <input type="test" name="Description" value="'.$item->descr.'">
            <p>Prix en €</p>
            <input type="number" step="0.01" name="Prix" value="'.$item->tarif.'"><br><br>
            <p>Url renvoyant su un site tierce pour plus details du produit</p>
            <input type="url" name="Url" value="'.$item->url.'">
            <p>Image</p>
            <input type="text" name="Image" value="'.$item->img.'">
            <input type="submit" name="submit" value="Valider">
        </form>';
        $html .= '<a href="'.$item->id.'/suppression"><input type="button" value=" Supprimer cet item "></a>';
        return $html;
    }


    public function render()
    {
        switch ($this->selecteur) {
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
            case self::NEW_LISTE :
                $content = $this->nouvelleListe();
                break;
            case self::MODIF_INFOSG :
                $content = $this->modifierInfosG();
                break;
            case self::MODIF_EFFECTUE :
                $content = $this->affichageModifEffectue();
                break;
            case self::AJOUT_ITEM :
                $content = $this->affichageAjoutItem();
                break;
            case self::AJOUT_ITEM_EFFECTUE :
                $content = $this->ajoutItemEffectue();
                break;
            case self::MODIF_ITEM :
                $content = $this->affichageModifItem();
                break;
            case self::MODIF_ITEM_EFFECTUE :
                $content = $this->affichageModifItemEffectue();
                break;
            case self::SUPPRESSION_ITEM_LISTE :
                $content = $this->affichageSuppressionItemEffectue();
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
                END;
        return $html;

    }


}
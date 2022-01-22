<?php

namespace wishlist\vue;

use wishlist\model\CommentaireItem;
use wishlist\model\Item;

class VueParticipant extends Vue
{

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
    const SUPPRESSION_ITEM_LISTE = 15;
    const ITEM_RESERV = 51;
    const SAVE_RESERV = 52;
    const ITEM_COMMENT = 53;
    const ITEM_COMMENT_DONE = 54;


    private function affichageListes(): string
    {
        $s = "<div><ol>";
        foreach ($this->tab as $val) {
            $s .= "<li>" . '<a href="./liste/voir/'.$val->tokenV.'">'.$val->titre.'</a>'. "</li>";
        }
        $s .= "<a href=\"./liste/new\"><input type=\"button\" value=\" Creer une nouvelle liste \"></a>";
        $s .= "</ol></div>";
        return $s;
    }

    private function affichageListe(): string
    {
        $rs = "";
        $rs .= "<div><p><h1>" . $this->tab->titre . "</h1> <br> Description : " . $this->tab->description . "</p><ol>";
        $items = Item::query()->get('*')->where('liste_id', '=', $this->tab->no);
        foreach ($items as $item) {
            $rs .= '<li><a href="../../item/' . $item->id . '">' . $item->nom . '</a>';
            $rs .= '<img src="../../web/img/' . $item->img . '" alt="' . $item->nom . '" height="200" width="200"/>';
        }
        $rs .= "</ol></div>";

        return $rs;
    }

    private function acceuil(): string
    {
        $urlitem = "item";
        $urllist = "liste";

        $rs = "<div class='titre'><h1>My WishList </h1></div>";

        $rs .= "<p><a href='$urllist'>Listes publiques</a></p>";
        $rs .='<a href="./Connexion"><input type="button" value="Se Connecter"></a>';
        $rs .='<a href="./Inscription"><input type="button" value="S\'inscrire"></a>';
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
        return $rs;
    }

    private function affichageItem(): string
    {
        $rs = '<div>'.$this->tab->nom . '<br>' . $this->tab->descr . '<br>'. $this->tab->tarif .' €</div>';
        $rs .= '<img src="../web/img/' . $this->tab->img . '" alt="' . $this->tab->nom . '" height="200" width="200"/><br>';
        if($this->tab->nomParticipant == null) {
            $rs .='<a href="./'.$this->tab->id.'/reservation"><input type="button" value=" Réserver "></a>';
        } else {
            $rs.='<p>Réservé par : '.$this->tab->nomParticipant .'</p>';
        }
        $rs .= '<br><p>Zone Commentaires :</p>';
        foreach ($this->tab->getComment as $c){
            $rs.='<br><p>'.$c->contenu.'</p>';
        }
        $rs .='<br><a href="./'.$this->tab->id.'/commentaire"><input type="button" value=" Ajouter un commentaire "></a>';
        return $rs;
    }

    private function laisserCommentItemVue(): string
    {
        return '<br><form method="POST" action="./commentaire/save">
            <p>Laisser un commentaire anonyme</p>
            <br><input type="textarea" name="com">
            <br><input type="submit" name="submit" value="Valider">
        </form>';
    }

    private function commentItemDone(): string
    {
        return '<p>Commentaire posté</p><br>
                <a href="../../'.$this->tab->id.'"><input type="button" value=" Ok "></a>';
    }

    private function AffReseverItem(): string
    {
        $html = '<h1>Réserver<h1>
        <form method="POST" action="reservation/save">
            <ul><li>Nom
            <input type="text" name="NomP">
            <input type="submit" name="submit" value="Valider"></li></ul>
        </form>';
        return $html;
    }

    private function AffSavedResever(): string
    {
        $rs = "<h1> La Reservation à bien été effectuée </h1>";
        $rs .= '<br><a href="../../../"><input type="button" value=" Acceuil "></a>';
        return $rs;
    }

    private function ajoutListe(): string
    {
        $html = "<h1> La liste a été crée vous pouvez y ajouter des items</h1>";
        $html .= "<div>
                  <p> Le token pour acceder aux informations de la nouvelle liste est le suivant : ".$this->tab[0]."</p>
                  <p> Si vous souhaitez modifier votre liste, utiliser ce token : ".$this->tab[1]."</p>
                  </div>";
        $html .= '<a href="../../liste">Compris</a>';
        return $html;
    }

    private function affichageModifEffectue(): string
    {
        $html = "<h1> La liste a été modifié avec succès</h1>";
        $html .= '<a href="./../../'.$this->tab->tokenM.'"><input type="button" value=" Retour "></a>';
        return $html;
    }

    private function ajoutItemEffectue(): string
    {
        $html = "<h1> L'item a été ajouté avec succès</h1>";
        $html .= '<a href="./../../'.$this->tab->tokenM.'"><input type="button" value=" Retour "></a>';
        return $html;
    }

    private function affichageModifItemEffectue(): string
    {
        $html = "<h1> L'item a été modifié avec succès</h1>";
        $html .= '<a href="./../../../'.$this->tab->tokenM.'"><input type="button" value=" Retour "></a>';
        return $html;
    }

    private function affichageSuppressionItemEffectue(): string
    {
        $html = "<h1> L'item a été supprimé avec succès</h1>";
        $html .= '<a href="./../../../'.$this->tab->tokenM.'"><input type="button" value=" Retour "></a>';
        return $html;
    }

    private function modifierListe(): string
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

    private function nouvelleListe(): string
    {
        $html = '
        <div align="center">
        <h1>Creation de liste</h1>
            <form method="post" action="./new/ajouter">
            <table>
                <tr>
                    <td>
                        <label>Nom de la liste</label>
                    </td>
                    <td>
                        <input type="text" name="Nom">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Description</label>
                    </td>
                    <td>
                        <input type="text" name="Description">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Date de fin de la liste</label>
                    </td>
                    <td>
                        <input type="date" name="Date">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Visibilité</label>
                    </td>
                    <td>
                        <input type="text" name="visible">
                    </td>
                </tr>
            </table>
                <input type="submit" name="submit" value="Valider">
            </form>
        </div>
        ';
        return $html;
    }


    private function modifierInfosG(): string
    {
        $liste = $this->tab;
        //$_POST['id'] = $liste->no;
        $html = '<div align="center">
                <h1>Modification de liste</h1>
                    <form method="post" action="" >
                    <table>
                        <tr>
                            <td>
                                <label>Nom de la liste</label>
                            </td>
                            <td>
                                <input type="text" name="Nom" value="'.$liste->titre.'">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Description</label>
                            </td>
                            <td>
                                <input type="text" name="Description" value="'.$liste->description.'">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Date de fin de la liste</label>
                            </td>
                            <td>
                                <input type="date" name="Date" value="'.$liste->expiration.'">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Visibilité</label>
                            </td>
                            <td>
                                <input type="text" name="visible" value="'.$liste->visible.'">
                            </td>
                        </tr>
                    </table>
                        <input type="submit" name="submit" value="Valider">
                    </form>
                </div>';
        return $html;
    }

    private function affichageAjoutItem(): string
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

    private function affichageModifItem(): string
    {
        $item=$this->tab;

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


    public function render(): string
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
            case self::ITEM_RESERV :
                $content = $this->AffReseverItem();
                break;
            case self::SAVE_RESERV :
                $content = $this->AffSavedResever();
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
            case self::ITEM_COMMENT :
                $content = $this->laisserCommentItemVue();
                break;
            case self::ITEM_COMMENT_DONE :
                $content = $this->commentItemDone();
                break;
            default :
                $content = "<p>selecteur de la vue inadéquat</p>";
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
                END;
        return $html;

    }


}
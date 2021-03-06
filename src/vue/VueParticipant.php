<?php

namespace wishlist\vue;

use wishlist\model\CommentaireItem;
use wishlist\model\Item;

class VueParticipant extends Vue
{

    const LISTS_VIEW = 1;
    const LIST_VIEW = 2;
    const AJOUT_LISTE = 11;
    const MODIF_VIEW = 12;
    const NEW_LISTE = 13;
    const MODIF_INFOSG = 21;
    const MODIF_EFFECTUE = 22;
    const AJOUT_ITEM = 31;
    const AJOUT_ITEM_EFFECTUE = 32;
    const MODIF_ITEM = 33;
    const MODIF_ITEM_EFFECTUE = 34;
    const SUPPRESSION_ITEM_LISTE = 35;
    const ITEMS_VIEW = 41;
    const ITEM_VIEW = 42;
    const ITEM_RESERV = 51;
    const SAVE_RESERV = 52;
    const ITEM_COMMENT = 53;
    const ITEM_COMMENT_DONE = 54;
    const ACCEUIL = 61;
    const CREATEURS_VIEW =70;
    const INSCRIPTION = 80;
    const CONNEXION = 81;


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
        $urlcreat = "createurs";
        $urllist = "liste";

        $rs = "<div><h1 class='titre'>My WishList </h1></div>";

        // nav bar
        $rs .=<<<END
                <div class="nav-bar">
                    <a href='$urllist'>Listes publiques</a>
                    <a href='$urlcreat'>Cr??ateurs</a>
                    <a href="./Connexion">Se Connecter</a>
                    <a href="./Inscription">S'inscrire</a>
                </div>
                END;
        $rs .= '<div class="access">
                    <h2>Acceder ?? une liste</h2>
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
        $rs .= '<div class="modify">
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
        return $rs;
    }

    private function affichageItem(): string
    {
        $rs = '<div>'.$this->tab->nom . '<br>' . $this->tab->descr . '<br>'. $this->tab->tarif .' ???</div>';
        $rs .= '<img src="../web/img/' . $this->tab->img . '" alt="' . $this->tab->nom . '" height="200" width="200"/><br>';
        if($this->tab->nomParticipant == null) {
            $rs .='<a href="./'.$this->tab->id.'/reservation"><input type="button" value=" R??server "></a>';
        } else {
            $rs.='<p>R??serv?? par : '.$this->tab->nomParticipant .'</p>';
        }
        $rs .= '<br><p>Zone Commentaires :</p>';
        foreach ($this->tab->getComment as $c){
            $rs.='<br><p>'.$c->contenu.'</p>';
        }
        $rs .='<br><a href="./'.$this->tab->id.'/commentaire"><input type="button" value=" Ajouter un commentaire "></a>';
        return $rs;
    }

    private function afficherItems(){
        $html = "";
        foreach ($this->tab as $item) {
            $html = '<p><a href="./item/'.$item->id.'">'.$item->nom.'</a></p>';
            $html .= '<img src="web/img/'.$item->img.'" alt="'.$item->nom.'" height="200" width="200"/>';
        }
        return $html;
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
        return '<p>Commentaire post??</p><br>
                <a href="../../'.$this->tab->id.'"><input type="button" value=" Ok "></a>';
    }

    private function AffReseverItem(): string
    {
        $html = '<h1>R??server<h1>
        <form method="POST" action="reservation/save">
            <ul><li>Nom
            <input type="text" name="NomP">
            <input type="submit" name="submit" value="Valider"></li></ul>
        </form>';
        return $html;
    }

    private function AffSavedResever(): string
    {
        $rs = "<h1> La Reservation ?? bien ??t?? effectu??e </h1>";
        $rs .= '<br><a href="../../../"><input type="button" value=" Acceuil "></a>';
        return $rs;
    }

    private function ajoutListe(): string
    {
        $html = "<h1> La liste a ??t?? cr??e vous pouvez y ajouter des items</h1>";
        $html .= "<div>
                  <p> Le token pour acceder aux informations de la nouvelle liste est le suivant : ".$this->tab[0]."</p>
                  <p> Pour partager cette liste, vous pouvez utiliser cette url : liste/voir/".$this->tab[0]."</p>
                  <p> Si vous souhaitez modifier votre liste, utiliser ce token : ".$this->tab[1]."</p>
                  <p> Pour modifier cette liste, vous pouvez utiliser cette url : liste/modifier/".$this->tab[1]."</p>
                  </div>";
        $html .= '<a href="../../liste">Compris</a>';
        return $html;
    }

    private function affichageModifEffectue(): string
    {
        $html = "<h1> La liste a ??t?? modifi?? avec succ??s</h1>";
        $html .= '<a href="./../../.."><input type="button" value=" Retour "></a>';
        return $html;
    }

    private function ajoutItemEffectue(): string
    {
        $html = "<h1> L'item a ??t?? ajout?? avec succ??s</h1>";
        $html .= '<a href="./../../'.$this->tab->tokenM.'"><input type="button" value=" Retour "></a>';
        return $html;
    }

    private function affichageModifItemEffectue(): string
    {
        $html = "<h1> L'item a ??t?? modifi?? avec succ??s</h1>";
        $html .= '<a href="./../../../'.$this->tab->tokenM.'"><input type="button" value=" Retour "></a>';
        return $html;
    }

    private function affichageSuppressionItemEffectue(): string
    {
        $html = "<h1> L'item a ??t?? supprim?? avec succ??s</h1>";
        $html .= '<a href="./../../../'.$this->tab->tokenM.'"><input type="button" value=" Retour "></a>';
        return $html;
    }

    private function modifierListe(): string
    {
        $rs = "";
        $rs .= "<div><p><h1>" . $this->tab->titre . "</h1> <br> Description : " . $this->tab->description . "</p>";
        $items = Item::query()->get('*')->where('liste_id', '=', $this->tab["no"]);
        $rs.= "<p>Les items pr??sents dans la liste :</p><ol>";
        foreach ($items as $item) {
            $rs .= '<li><a href="../../item/' . $item->id . '">' . $item->nom . '</a><a href="./'.$this->tab->tokenM.'/modifierItem/'.$item->id.'"><input type="button" value=" Modifier cet item "></a>';
        }
        $rs .= "</ol></div>";
        $rs .='<a href="./'.$this->tab->tokenM.'/infosG"><input type="button" value=" Modifier les informations g??n??rales "></a>';
        $rs .='<a href="./'.$this->tab->tokenM.'/ajoutItem"><input type="button" value=" Ajouter un item "></a>';
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
                        <label>Visibilit??</label>
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
                                <label>Visibilit??</label>
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
            <p>Prix en ???</p>
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
            <p>Prix en ???</p>
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

    private function afficherCreateurs()
    {
        $rs = "<div class='titre'><h1> Cr??ateurs </h1></div>";
        foreach ($this->tab as $creat) {
            $rs .= '<li>' . $creat. '</a>';
        }
        return $rs;
    }

    private function connexion()
    {
        $rs ='';
        $rs .='<div align="center">
                    <h2>Connexion</h2>
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
                                    <input type="password" placeholder="Votre mot de passe" name="password" pattern=".[a-zA-z&0-9_!]{8,20}" required>
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
                                    <input type="password" placeholder="Votre mot de passe" name="password" pattern=".[a-zA-z&0-9_!]{8,20}" required>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Confirmer votre mot de passe :</label>
                                </td>
                                <td>
                                    <input type="password" placeholder="Votre mot de passe" name="reppassword" pattern=".[a-zA-z&0-9_]{8,20}" required>
                                </td>
                            </tr>
                        </table>
                        <br>
                        <input type="submit" name="inscription" value="Je m\'inscris"/>
                    </form>
                </div>';
        return $rs;
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
            case self::ITEMS_VIEW :
                $content = $this->afficherItems();
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
            case self::CREATEURS_VIEW :
                $content = $this->afficherCreateurs();
                break;
            case self::INSCRIPTION:
                $content = $this->inscription();
                break;
            case self::CONNEXION:
                $content = $this->connexion();
                break;
            default :
                $content = "<p>selecteur de la vue inad??quat</p>";
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
<?php

namespace wishlist\vue;
use wishlist\modele\Item;

class VueParticipant{

    private $tab;

    public function __construct($t){
        $this->tab = $t;
    }

    private function afflist(){}

    private function htmllist(){}
    
    private function htmlitem(){}

    public function render($selecteur){

        switch($selecteur){

            case ITEM_VIEW : {
                $content = $this->htmlUnItem();
                break;
            }
        }

    $html = <<<END
    <!DOCTYPE html> <html></html>
    END;

    return $html;
    }
}
<?php

namespace wishlist\vue;

class Vue
{
    protected $tab;
    protected $selecteur;

    public function __construct($li, $selec)
    {
        $this->tab= $li;
        $this->selecteur = $selec;
    }
}
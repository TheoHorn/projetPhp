<?php


namespace wishlist\modele;

use Illuminate\Database\Eloquent\Model;

class Liste extends Model{
    protected $table = 'liste';
    protected $primaryKey = 'no';
    public $timestamps = false;

    public function items() {
        return $this->hasMany('wishlist\src\modele\Item', 'liste_id');
    }
}
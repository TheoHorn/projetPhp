<?php
namespace wishlist\modele;

use Illuminate\Database\Eloquent\Model;

class Item extends Model {
    protected $table = 'item';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function liste() {
        return $this->belongsTo('wishlist\modele\Liste', 'liste_id');
    }
}
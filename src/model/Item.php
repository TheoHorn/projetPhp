<?php

namespace wishlist\model;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'item';
    protected $primaryKey = 'id';

    public function liste() {
        return $this->hasMany('wishlist\model\Liste', 'liste_id');
    }
}
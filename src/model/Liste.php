<?php

namespace wishlist\model;

use Illuminate\Database\Eloquent\Model;

class Liste extends Model
{
    protected $table = 'liste';
    protected $primaryKey = 'no';
    public $timestamps = false;

    public function items(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('wishlist\model\Item', 'liste_id');
    }

    public function getComment(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CommentaireListe::class);
    }
}
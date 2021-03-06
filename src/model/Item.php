<?php

namespace wishlist\model;



use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'item';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function liste(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('wishlist\model\Liste', 'liste_id');
    }

    public function getComment(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('wishlist\model\CommentaireItem',"item_id");
    }
}
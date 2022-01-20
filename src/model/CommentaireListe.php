<?php

namespace wishlist\model;

use Illuminate\Database\Eloquent\Model;

class CommentaireListe extends Model
{
    protected $table = 'commentaireListe';
    public $timestamps = false;

    public function liste(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('wishlist\model\liste', 'liste_no');
    }

}
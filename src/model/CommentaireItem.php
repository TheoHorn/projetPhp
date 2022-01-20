<?php

namespace wishlist\model;

use Illuminate\Database\Eloquent\Model;

class CommentaireItem extends Model
{
    protected $table = 'itemcomment';
    public $timestamps = false;

    public function item(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('wishlist\model\item', 'item_id');
    }

}
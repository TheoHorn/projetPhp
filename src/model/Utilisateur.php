<?php

namespace wishlist\model;

class Utilisateur extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
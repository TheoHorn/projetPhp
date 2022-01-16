<?php

namespace wishlist\model;

class Role extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'role';
    protected $primaryKey = 'id_role';
    public $timestamps = false;
}
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $guarded = [];

    public function getIsCompletedAttribute($value)
    {
        return boolval($value);
    }
}

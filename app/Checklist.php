<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    protected $guarded = [];

    public function link()
    {
        return url("/checklists/{$this->id}");
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}

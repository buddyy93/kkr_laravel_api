<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $guarded = [];

    public function checklist()
    {
        return $this->hasOne(ChecklistTemplate::class);
    }

    public function items()
    {
        return $this->hasMany(ItemTemplate::class);
    }

    public function link()
    {
        return url("/api/v1/template/{$this->id}");
    }
}

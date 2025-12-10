<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Crew extends Model
{
    protected $guarded = [];

    protected $hidden = ['id'];
    
    public function cosmonauts()
    {
        return $this->belongsToMany(Cosmonaut::class);
    }
}

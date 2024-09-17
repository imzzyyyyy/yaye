<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = ['name', 'short_name', 'icon'];

    public function properties()
    {
        return $this->belongsToMany(Property::class, 'item_properties')
                    ->withPivot('value');
    }

    public function parts()
    {
        return $this->hasMany(Part::class); // Assuming you have a Part model
    }
}



<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $fillable = ['label'];

    public function items()
    {
        return $this->belongsToMany(Item::class, 'item_properties')
                    ->withPivot('value');
    }
}



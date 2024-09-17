<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    use HasFactory;

    protected $fillable = ['item_id', 'part_name', 'name', 'required', 'property_id'];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    // You can specify the table if it's different from the model name (pluralized and snake-cased by default)
    protected $table = 'units'; 

    // Define fillable attributes if necessary
    protected $fillable = ['name', 'status', 'serial', 'type', 'assigned_to', 'from'];

    // Define other model properties and methods as needed
}

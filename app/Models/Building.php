<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    use HasFactory;

    // Specify the table if it doesn't follow Laravel's naming convention
    // protected $table = 'buildings';

    // Specify the attributes that are mass assignable
    protected $fillable = [
        'name',
        'status',
    ];

    // Optionally, if you don't want the `created_at` and `updated_at` columns
    // protected $timestamps = false;
}

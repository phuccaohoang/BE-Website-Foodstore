<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $table = "images";

    protected $fillable = [
        'food_id',
        'img',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $table = "reviews";
    protected $hidden = [
        'created_at',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}

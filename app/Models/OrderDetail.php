<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $table = "order_details";

    protected $fillable = [
        'order_id',
        'food_id',
        'price',
        'discount',
        'quantity',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function food()
    {
        return $this->belongsTo(Food::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = "orders";
    protected $hidden = [
        'created_at',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }
    public function order_status()
    {
        return $this->belongsTo(OrderStatus::class);
    }
    public function order_details()
    {
        return $this->hasMany(OrderDetail::class);
    }
}

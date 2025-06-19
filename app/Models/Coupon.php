<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $table = "coupons";
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function customers()
    {
        return $this->belongsToMany(Customer::class, 'coupons_customers', 'coupon_id', 'customer_id');
    }
}

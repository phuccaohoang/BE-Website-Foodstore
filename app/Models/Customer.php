<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = "customers";

    protected $fillable = [
        'fullname',
        'phone',
        'address',
        'account_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
    public function coupons()
    {
        return $this->belongsToMany(Coupon::class, 'coupons_customers', 'customer_id', 'coupon_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponCustomer extends Model
{
    use HasFactory;
    protected $table = "coupons_customers";
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}

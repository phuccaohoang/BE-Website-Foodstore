<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatale;

use Tymon\JWTAuth\Contracts\JWTSubject;

class Account extends Authenticatale implements JWTSubject
{
    use HasFactory;
    protected $table = "accounts";

    protected $fillable = [
        'email',
        'password',
        'avatar',
        'is_admin',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    protected $hidden = [
        'password',
        'created_at',
        'updated_at',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
    public function administrators()
    {
        return $this->hasMany(Administrator::class);
    }
}

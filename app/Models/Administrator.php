<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrator extends Model
{
    use HasFactory;
    protected $table = "administrators";
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function administrator()
    {
        return $this->belongsTo(Account::class);
    }
}

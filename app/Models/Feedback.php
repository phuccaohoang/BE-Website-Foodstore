<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;
    protected $table = "feedbacks";
    protected $hidden = [
        'created_at',
    ];

    public function administrator()
    {
        return $this->belongsTo(Administrator::class);
    }
    public function review()
    {
        return $this->belongsTo(Review::class);
    }
}

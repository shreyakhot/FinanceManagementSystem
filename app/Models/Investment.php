<?php

// app/Models/Investment.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    use HasFactory;

    protected $fillable = ['portfolio_id', 'user_id','type', 'symbol', 'amount', 'price'];

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }
}

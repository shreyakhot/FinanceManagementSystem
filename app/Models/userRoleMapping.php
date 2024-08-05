<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userRoleMapping extends Model
{
    use HasFactory;
    protected $table = 'userrolesmapping';

    protected $fillable = [
        "userId"	,
        "roleId"
    ];
}

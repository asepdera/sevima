<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'class_code',
    ];

    protected $table = 'class';
}

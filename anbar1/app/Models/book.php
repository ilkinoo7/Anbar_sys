<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class book extends Model
{
    use HasFactory;

    use HasFactory;
    
    protected $fillable = [
        'title', 'code', 'author', 'image'
    ];
}
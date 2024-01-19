<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;

    protected $table = 'm_resources';

    protected $fillable = [
        'title',
        'content',
        'image',
        'is_deleted',
        'updated_at',
        'created_at',
    ];
}

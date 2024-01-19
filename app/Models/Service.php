<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = 'm_services';

    protected $fillable = [
        'image',
        'content',
        'file',
        'is_deleted',
        'updated_at',
        'created_at',
    ];
}

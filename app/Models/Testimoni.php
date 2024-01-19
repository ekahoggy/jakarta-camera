<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimoni extends Model
{
    use HasFactory;
    
    // public $timestamps = false;
    protected $table = 'm_testimoni';

    protected $fillable = [
        'photo',
        'name',
        'testimoni',
        'testimoni_en',
        'position',
        'is_status',
        'created_at',
        'updated_at',
    ];
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;
    protected $table = 'm_faq';

    protected $fillable = [
        'title',
        'title_en',
        'content',
        'content_en',
        'position',
        'created_at',
        'updated_at'
    ];
}

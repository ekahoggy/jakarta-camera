<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GaleryPage extends Model
{
    use HasFactory;

    protected $table = 'm_galeri';

    protected $fillable = [
        'm_pages',
        'photo',
        'title',
        'content',
        'title_en',
        'content_en'
    ];
}

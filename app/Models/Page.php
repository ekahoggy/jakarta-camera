<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $table = 'm_pages';

    protected $fillable = [
        'title',
        'title_en',
        'date',
        'to',
        'short_description',
        'short_description_en',
        'picture',
        'short_content',
        'short_content_en',
        'content',
        'content_en',
        'link_youtube',
        'email',
        'phone_number',
        'is_status',
        'publish_at',
        'created_by',
        'updated_at'
    ];

    public function users(){

        return $this->belongsTo(User::class, 'created_by')->select('name', 'id');
    }

    public function galeri(){
        return $this->hasMany(GaleryPage::class, 'm_pages')->select('id', 'photo', 'm_pages', 'title', 'content', 'title_en', 'content_en');
    }
}
